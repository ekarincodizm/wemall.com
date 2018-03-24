<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetAppCategoryMenu extends Widget
{

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'appCategoryMenu';
    private $noCacheQString = "no-cache-navmenu";
    public $data = array();
    private $brandRepository;
    private $allBrands;

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array(
        "category" => array()
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.
        $this->brandRepository = App::make("BrandRepositoryInterface");
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {

        $attrs = $this->getAttributes();
        $cacheKey = implode("-", array(Request::root(), Lang::locale(), "WidgetAppCategoryMenu"));
        $nocache = $this->getFromApi();

        if (!$nocache)
            if ($response = $this->getCache($cacheKey, $nocache))
                return $response;

        $this->data['category'] = $this->getTopMenuCollections();
        $categoryCollection = array_get($this->data, "category.collections", array());

        if (!empty($categoryCollection)) {

            $this->allBrands = $this->getBrandsList();
            $this->correctCollection($categoryCollection);
        }


        if (!empty($this->data['category'])) {

            $attrs["category"] = $this->data['category'];
            $this->setCache($cacheKey, $attrs);
        }

        return $attrs;
    }

    private function getBrandsInCollection($old_brands)
    {
        $brands = array();

        /// find correct image from new brand ///
        foreach ($old_brands as $old_brand) {
            $brandPkey = $old_brand['pkey'];

            if (!isset($this->allBrands[$brandPkey]))
                $this->allBrands[$brandPkey] = $this->getBrandByPkey($brandPkey);

            array_push($brands, $this->getLastestBrandDetail($this->allBrands[$brandPkey], $old_brand));
        }

        return $brands;
    }

    private function getLastestBrandDetail($newBrand, $oldBrand)
    {
        if (array_key_exists('metas', $newBrand) &&
            array_key_exists('banner-icon', $newBrand['metas'])
        ) {

            return array(
                'pkey' => $newBrand['pkey'],
                'slug' => $newBrand['slug'],
                'name' => $newBrand['name'],
                'image' => $this->getImageMenu($newBrand),
                'translates' => $newBrand['translate'],
            );
        }

        return $oldBrand;
    }

    private function getBrandByPkey($pkey)
    {
        return $this->brandRepository->getByPkey($pkey);
    }

    private function getBrandsList()
    {
        $brands_list = $this->brandRepository->getAll();

        return $this->sortBrandByPkey($brands_list);
    }

    private function sortBrandByPkey($brands_list)
    {
        $brands = array();
        foreach ($brands_list as $brand) {
            $brands[$brand['pkey']] = $brand;
        }

        return $brands;
    }

    private function getImageMenu($brand)
    {
        $image_menu = array_get($brand, 'metas.banner-icon', null);
        if (is_null($image_menu)) {
            $image_menu = array_get($brand, 'metas.small-logo', null);
        }
        return $image_menu;
    }

    private function getFromApi()
    {
        return Input::has($this->noCacheQString);
    }

    private function getCache($ckey, $nocache = false)
    {
        return ElastiCache::getResultV2($ckey, null, $nocache);
    }

    private function setCache($ckey, $data, $url = null, $ttl = 60)
    {
        return ElastiCache::save($ckey, $data, $url, $ttl);
    }

    private function getTopMenuCollections()
    {
        return App::make('CollectionRepository')->getAppCategoryTopMenu();
    }

    private function correctCollection($categoryCollection)
    {
        foreach ($categoryCollection as $index => $collection) {
            $old_brands = array_get($this->data, "category.collections.${index}.brands", null);
            $this->data['category']['collections'][$index]['brands'] = $this->getBrandsInCollection($old_brands);
        }

        return $this->data;
    }

}

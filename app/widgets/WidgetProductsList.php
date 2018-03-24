<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsList extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-list';

    /**
     * Watching widget tpl on everywhere.
     *
     * @var boolean
     */
    public $watch = false;

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array(
        'data' => array(),
        'paginator' => array()
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        Config::set('view.pagination', 'pagination.itruemart');


        $theme->asset()->container('footer')->writeScript('CheckingInputPage', '

            $(".checkLimitPage").submit(function(e){

                var page = parseInt($(this).find("input[name=\"page\"]").val());

                if (isNaN(page)) {

                    $(this).find("input[name=\"page\"]").val(1);


                } else {

                    var total_page = $(this).find(".total_page").text();

                    if (page > total_page)
                    {
                        $(this).find("input[name=\"page\"]").val(1);
                    }
                }

            });

            ', array('jquery'));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {

        $attrs = $this->getAttributes();

        $page = Input::get('page', 1);

        $data = $attrs['data'];

        // START Criteo tag
        $product_list = array();
        if(isset($data['products'])) {
            foreach ($data['products'] as $key => $item) {
                $product_list[] = $item['pkey'];
            }
        }
        $this->theme->append('criteo_tag', criteoTagLevelC($product_list, array_get($data, 'collection_name', '')));
        // END Criteo tag

        // test
        // $attrs['paginator'] = Paginator::make($data['products'], 1000, 10);

        if (empty($data['products']))
        {
            $attrs['total_item'] = 0;
            $attrs['products'] = null;
            $attrs['total_page'] = '';
            $attrs['page'] = '';
            $attrs['next'] = '';
            $attrs['prev'] = '';
            $attrs['paginator'] = Paginator::make(array(), 0, Input::get('per_page', 21));
        }
        else
        {
            $attrs['paginator'] = Paginator::make($data['products'], $data['total_item'], Input::get('per_page', 21));
            $attrs['total_item'] = $data['total_item'];
            $attrs['products'] = $data['products'];

            // page pagination
            $attrs['total_page'] = $data['total_page'];
            $attrs['page'] = $data['page'];
            if ($data['page'] == 1 || $page == 1)
            {
                $data['prev'] = null;
            }
            else
            {
                $data['prev'] = $data['page'] - 1;
            }
            $attrs['prev'] = $data['prev'];

            if ($page == $data['total_page'])
            {
                $data['next'] = null;
            }
            else
            {
                $data['next'] = $data['page'] + 1;
            }
            $attrs['next'] = $data['next'];
        }
        // sd($attrs);
        return $attrs;
    }

}


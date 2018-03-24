<?php
/**
 *  @author  Preme W. <preme_won@truecorp.co.th>
 *  @since   Jan 29, 2014
 *  @version  1.0
 *  @desc  Widget for generate news category menus 
 */

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetNewsCategory extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'news-category-menu';

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
    public $attributes = array('category_id' => '');

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {

    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = $this->getAttributes();

        $newsRepository = new \NewsRepository; 

        $args = array(
            'cat_id' => 0,
            'condition' => 'group',
            'format' => 'json'
        );
        $categories = $newsRepository->getNewsGroup($args);

        $total_group = 0; 
        $group_list = array(
            $total_group => array(
                'id' => 0,
                'name_en' => 'announcement',
                'name_th' => 'announcement'
            )
        );

        if ( ! empty($categories['status']) && $categories['status'] == 200 && $categories['total'] > 0)
        {
            foreach ($categories['data_response']['data_record'] as $key => $value)
            {
                $group_list[++$total_group] = array(
                    'id'        => $value['news_group_id'],
                    'name_en'   => $value['title_en'],
                    'name_th'   => $value['title_th']
                );
            }
        }

        $attrs['categories'] = $group_list;        

        return $attrs;
    }

}
<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetHomeShowroom extends Widget
{

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'home-showroom';

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
        'slug' => '',
        'page' => 1,
        'limit' => 1,
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init()
    {
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array array(
     *   display_next_page - render next page for normal request
     *   next_page  - link for next page
     *   showroom   - showroom data
     *   total_page - showroom total page
     *   no_cache   - render link on next page with no cache param
     *   page       - current page
     *   limit      - limit for ajax
     * )
     */
    public function run()
    {
        $attributes = $this->getAttributes();

        // define default attribute
        $_page = array_get($attributes, 'page', 1);
        $_limit = array_get($attributes, 'limit', 1);
        $_no_cache = array_get($attributes, 'noCache', false);
        $_next_page = URL::toLang("ajax/showroom") . '?';

        if ($_no_cache) {
            $_next_page .= '&no-cache=1';
        }

        $showroom = App::make('ShowroomRepositoryInterface');
        $response = $showroom->getData($_page, $_limit);

        array_set($attributes, 'display_next_page', $_page==1);
        array_set($attributes, 'next_page', $_next_page);
        array_set($attributes, 'showroom', array_get($response, 'data.showroom', array()));
        array_set($attributes, 'total_page', array_get($response, 'data.total_page', 1));
        array_set($attributes, 'no_cache', $_no_cache);
        array_set($attributes, 'page', $_page);
        array_get($attributes, 'limit', $_limit);

        return $attributes;
    }

}
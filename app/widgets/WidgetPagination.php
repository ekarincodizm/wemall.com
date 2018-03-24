<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetPagination extends Widget
{

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'pagination';

    /**
     * Watching widget tpl on everywhere.
     *
     * @var boolean
     */
    public $watch = true;

    /**
     * Arrtibutes pass from a widget.
     *
     * @var array
     */
    public $attributes = array(
        "page" => 1,
        "total_page" => 0,
        "page_lists" => array(),
        "adjacent" => 5,
        "link" => ""
    );

    /**
     * Turn on/off widget.
     *
     * @var boolean
     */
    public $enable = true;

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

        $page_lists = array();
        $adjacent = intval($attrs["adjacent"]);
        $page = intval($attrs["page"]);
        $total_page = intval($attrs["total_page"]);
        $link = (strpos($attrs["link"], "?") === false ) ? $attrs["link"] . "?" : $attrs["link"] . "&";
        $fhalf = ceil($adjacent / 2);
        $lhalf = $adjacent - $fhalf;

        $startPage = ($page - $fhalf > 0) ? $page - $fhalf : 1;
        $endPage = ($page + $lhalf < $total_page) ? $page + $lhalf : $total_page;

        if ($startPage > 1) {
            $page_lists[] = array(
                "value" => 1,
                "link" => $link . "page=1",
                "class" => ($page == 1) ? "active" : ""
            );
            $page_lists[] = array(
                "value" => "..."
            );
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $page_lists[] = array(
                "value" => $i,
                "link" => $link . "page=" . $i,
                "class" => (intval($i) == $page)? "active" : ""
            );
        }

        if ( $endPage < $total_page ) {
            $page_lists[] = array(
                "value" => "..."
            );
            $page_lists[] = array(
                "value" => $total_page,
                "link" => $link . "page=" . $total_page,
                "class" => ($total_page == $page) ? "active" : ""
            );
        }

        $attrs["page_lists"] = $page_lists;
        $attrs["link"] = $link;
        $attrs["page"] = $page;
        $attrs["total_page"] = $total_page;
        $attrs["back_link"] = $link . "page=" . ($page - 1);
        $attrs["next_link"] = $link . "page=" . ($page + 1);

        return $attrs;
    }

}
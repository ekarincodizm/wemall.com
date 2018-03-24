<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetProductsPolicies extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'products-policies';

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
        // 'product' => array(),
        'policies' => array()
    );

    /**
     * Code to start this widget.
     *
     * @return void
     */
    public function init(Theme $theme)
    {
        // Initialize widget.

        //$theme->asset()->usePath()->add('widget-name', 'js/widget-execute.js', array('jquery', 'jqueryui'));
        //$this->setAttribute('user', User::find($this->getAttribute('userId')));
    }

    /**
     * Logic given to a widget and pass to widget's view.
     *
     * @return array
     */
    public function run()
    {
        $attrs = array();
        $this->setAttribute('policies', $this->getPolicies());

        return $attrs;
    }

    public function getPolicies()
    {
        $product = $this->getAttribute('product');
        $locale = langToLocale(Lang::getLocale());
        $policies = array();
        //extract policies
        foreach ($product['policies'] as $policy)
        {

            switch ($policy['type_id'])
            {
                //free delivery policy
                case '3':
                    if ($locale == 'th_TH')
                    {
                        $policies['shipping']['title'] = $policy['title'];
                        $policies['shipping']['description'] = $policy['description'];

                    }
                    else
                    {
                        if(isset($policy['translates'][$locale]))
                            $policies['shipping'] = $policy['translates'][$locale];
                        else
                        {
                            $policies['shipping']['title'] = $policy['title'];
                            $policies['shipping']['description'] = $policy['description'];
                        }

                    }
                    $policies['shipping']['type'] = $policy['type'][$locale];
                    break;
                //money back policy
                case '2':
                    if ($locale == 'th_TH')
                    {
                        $policies['refund']['title'] = $policy['title'];
                        $policies['refund']['description'] = $policy['description'];
                        // $policies['type'] = $policy['type'][$locale];
                    }
                    else
                    {
                        if(isset($policy['translates'][$locale]))
                            $policies['refund'] = $policy['translates'][$locale];
                        else
                        {
                            $policies['refund']['title'] = $policy['title'];
                            $policies['refund']['description'] = $policy['description'];
                        }

                    }
                    $policies['refund']['type'] = $policy['type'][$locale];
                    break;
                //return policy
                case '1':
                    if ($locale == 'th_TH')
                    {
                        $policies['returnItem']['title'] = $policy['title'];
                        $policies['returnItem']['description'] = $policy['description'];
                        // $policies['type'] = $policy['type'][$locale];
                    }
                    else
                    {
                        if(isset($policy['translates'][$locale]))
                            $policies['returnItem'] = $policy['translates'][$locale];
                        else
                        {
                            $policies['returnItem']['title'] = $policy['title'];
                            $policies['returnItem']['description'] = $policy['description'];
                        }

                    }
                    $policies['returnItem']['type'] = $policy['type'][$locale];
                    break;
            }


        }
        // dd($policies);
        return $policies;

    }
}
<?php

use Teepluss\Theme\Theme;
use Teepluss\Theme\Widget;

class WidgetPayInstallment extends Widget {

    /**
     * Widget template.
     *
     * @var string
     */
    public $template = 'pay-installment';

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
        'userId' => 9999,
        'label'  => 'Generated Widget',
        'monthly_installment' => array(),
        'cart' => array(),
        'installTotalPrice' => array(),
        'installTotalPriceActive' => array(),
        "activeInstallmentBank" => "",
        "bank_images" => array(
            "kbank" => "icon_kbank.png",
            "bay" => "icon_krungsri.png",
            "centralcard" => "icon_central.png",
            "firstchoice" => "icon_firstchoice.png",
            "tescolotus" => "icon_tesco.png",
            "ktc" => "icon_ktc.png",
            "bbl" => "icon_bbl.png"
        )
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
        $label = $this->getAttribute('label');

        //$this->setAttribute('label', 'changed');

        $attrs = $this->getAttributes();

        $bank_show = array();

        if(!empty($attrs['checkout']['shipments']))
        {
            foreach($attrs['checkout']['shipments'] as $s_key => $s_row)
            {
                if(!empty($s_row['items']))
                {
                    foreach($s_row['items'] as $i_key => $i_row)
                    {
                        if(!empty($i_row['bank_installments']))
                        {
                            ### Show installment bank by Union ###
                            foreach($i_row['bank_installments'] as $b_key => $b_row)
                            {
                                // [S] get total price per bank & period
                                foreach($b_row["periods"] as $month){
                                    if(! isset($attrs["installTotalPrice"][$b_row["abbreviation"]][$month])){
                                        $attrs["installTotalPrice"][$b_row["abbreviation"]][$month] = 0;
                                    }
                                    $attrs["installTotalPrice"][$b_row["abbreviation"]][$month] += ((float)$i_row["price"] * (int)$i_row["quantity"]);
                                }
                                // [E] get total price per bank & period

                                /*
                                ### merge bank ###
                                if(!empty($bank_show))
                                {
                                    $has_bank = false;
                                    foreach($bank_show as $ba_key => $ba_row)
                                    {
                                        if($ba_row['id'] == $b_row['id'])
                                        {
                                            $has_bank = true;
                                            ### bank merge periods  ###
                                            if( !empty($ba_row['periods']) && !empty($b_row['periods']) )
                                            {
                                                $tmp_arr = array_unique(array_merge_recursive($ba_row['periods'],$b_row['periods']));
                                                asort($tmp_arr);
                                                $bank_show[$b_row['id']]['periods'] = array_values($tmp_arr);

                                            }
                                        }
                                    }

                                    if($has_bank == false)
                                    {
                                        $bank_show[$b_row['id']] = $b_row;
                                    }

                                }
                                else
                                {
                                    $bank_show[$b_row['id']] = $b_row;
                                }
                                */
                            }
                        }
                    }
                }
            }
        }

        $installment = array(
            'bank_id' => !empty($attrs['checkout']['bank_id'])? $attrs['checkout']['bank_id'] : '',
            'period' => !empty($attrs['checkout']['installment']['period'])? $attrs['checkout']['installment']['period'] : '',
        );

        $bank_show = !empty($attrs['checkout']['bank_show'])? $attrs['checkout']['bank_show'] : array();
        asort($bank_show);
        $attrs['bank_show'] = !empty($bank_show) ? $bank_show : array();
        $attrs['bank_show_json'] = !empty($bank_show)? json_encode($bank_show) : '';
        $attrs['bank_id'] = !empty($attrs['checkout']['bank_id'])? $attrs['checkout']['bank_id'] : '';
        $attrs['periods_val'] = !empty($attrs['checkout']['installment']['period'])? $attrs['checkout']['installment']['period'] : '';
        $attrs['installment'] = $installment;

        $attrs['periods_option'] = array();
        if(!empty($attrs['bank_id']) && !empty($attrs['bank_show']) )
        {
            foreach($attrs['bank_show'] as $bsh_key => $bsh_row)
            {
                if($bsh_row['id'] == $attrs['bank_id'])
                {
                    $attrs["installTotalPriceActive"] = $attrs["installTotalPrice"][$bsh_row["abbreviation"]];
                    //$attrs['periods_option'] = $bsh_row['periods'];
                    $attrs['periods_option'] = $bank_show[$bsh_row['id']]['periods'];
                    $attrs["activeInstallmentBank"] = $bsh_row["abbreviation"];
                    break;
                }
            }
        }

        //installment data
        $attrs['installment_data'] = !empty( $attrs['checkout']['available_payment_methods'][156813837979402]['banks'])? json_encode($attrs['checkout']['available_payment_methods'][156813837979402]['banks']): '';
        //sd($attrs);
        return $attrs;
    }

}
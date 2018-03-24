<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="<?php echo URL::tolang('/'); ?>" title="Shopping Online">
                    <span itemprop="title">Shopping Online</span>
                </a>
            </span> &gt; 
            <a class="map">Payment Manual</a>
        </div>
    </div>
    <div id="wrapper_content">
        <!-- Start Content -->
        <div id="checkout-manual">
            <div class="row">
                <div class="col-sm-12" id="title">
                    <?php echo __("howto-make-payment-manual-title"); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2" id="menu">
                    <ul class="payment-channel list-unstyled">
                        <li class="selected"><a id="menu-atm" href="#atm">Bank ATM<span>&gt;</span></a></li>
                        <li><a id="menu-payment-counter" href="#payment-counter">Payment Counter<span>&gt;</span></a></li>
                        <li><a id="menu-counter-service" href="#counter-service">Counter Service<span>&gt;</span></a></li>
                        <li><a id="menu-ibanking" href="#ibanking">Internet Banking<span>&gt;</span></a></li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <a name="#atm"></a>
                        <div id="atm" class="manual-container active">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs how-to-checkout">
                                    <li class="active"><a href="#kbank">
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-kbank.png" class="icon-bank">
                                            <?php echo __("thankyou-atm-kbank-tab"); ?></a></li>
                                    <li><a href="#scb">
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-scb.jpg" class="icon-bank">
                                            <?php echo __("thankyou-atm-scb-tab"); ?></a></li>
                                    <li><a href="#bangkok">
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-bangkok.png" class="icon-bank">
                                            <?php echo __("thankyou-atm-bbank-tab"); ?></a></li>
                                </ul>
                                <div class="panel panel-body-no-top">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div id="kbank" class="tab-pane active">
                                                <div class="col-sm-12 text-center">
                                                    <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_kbank.jpg">
                                                </div>
                                                <div class="col-sm-12">
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step7"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step8"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div id="scb" class="tab-pane">
                                                <div class="col-sm-12 text-center">
                                                    <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_scb.jpg">
                                                </div>
                                                <div class="col-sm-12">
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-atmscb-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step7"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step8"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step9"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step10"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step11"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step12"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div id="bangkok" class="tab-pane fade">
                                                <div class="col-sm-12 text-center">
                                                    <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_bangkok.jpg">
                                                </div>
                                                <div class="col-sm-12">
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step7"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a name="#payment-counter"></a>
                        <div id="payment-counter" class="manual-container">
                            <ul class="nav nav-tabs how-to-checkout">
                                <li class="active"><a href="javascript:;"><?php echo __("payment-with-bankcounter-tab"); ?></a></li>
                            </ul>
                            <div class="panel panel-body-no-top">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_kbank.jpg">
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_scb.jpg">
                                            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_bangkok.jpg">
                                        </div>
                                        <div class="col-sm-12">
                                            <p>
                                                <strong><?php echo __("payment-with-bankcounter-title"); ?></strong></p>
                                            <p class="text-indent-30"><?php echo __("payment-with-bankcounter-desc"); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a name="#counter-service"></a>
                        <div id="counter-service" class="manual-container">
                            <ul class="nav nav-tabs how-to-checkout">
                                <li class="active"><a href="javascript:;"><?php echo __("payment-with-cs-tab"); ?></a></li>
                            </ul>
                            <div class="panel panel-body-no-top">
                                <div class="panel-body">
                                    <div id="Div1">
                                        <div class="row">
                                            <div class="col-sm-3 text-center">
                                                <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_counter_service.jpg">
                                            </div>
                                            <div class="col-sm-9">
                                                <p>
                                                   <?php echo __("payment-with-cs-desc"); ?>
                                                <p>
                                                    <strong><?php echo __("payment-with-cs-tracking-title"); ?></strong></p>
                                                <p class="text-indent-30">
                                                    <a href="http://www.itruemart.com/member/order_tracking" target="_blank">http://www.itruemart.com/member/order_tracking</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a name="#ibanking"></a>
                        <div id="ibanking" class="manual-container">
                            <ul class="nav nav-tabs how-to-checkout">
                                <li class="active"><a href="#ikbank">
                                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-kbank.png" class="icon-bank">
                                        <?php echo __("thankyou-atm-kbank-tab"); ?></a></li>
                                <li><a href="#iscb">
                                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-scb.jpg" class="icon-bank">
                                        <?php echo __("thankyou-atm-scb-tab"); ?></a></li>
                                <li><a href="#ibangkok">
                                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-bangkok.png" class="icon-bank">
                                        <?php echo __("thankyou-atm-bbank-tab"); ?></a></li>
                            </ul>
                            <div class="panel panel-body-no-top">
                                <div class="panel-body">
                                    <div class="row">
                                        <div id="ikbank" class="tab-pane active">
                                            <div class="col-sm-12 text-center">
                                                <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_kbank.jpg">
                                            </div>
                                            <div class="col-sm-12">
                                                <dl>
                                                    <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                    <dd>
                                                        <ol>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step1"); ?></li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step2"); ?></li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step3"); ?></li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step4"); ?></li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step5"); ?></li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step6"); ?>
                                                                <ol>
                                                                    <li><?php echo __("thankyou-ibankkbank-howto-step6.1"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankkbank-howto-step6.2"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankkbank-howto-step6.3"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankkbank-howto-step6.4"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankkbank-howto-step6.5"); ?></li>
                                                                </ol>
                                                            </li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step7"); ?></li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step8"); ?></li>
                                                            <li><?php echo __("thankyou-ibankkbank-howto-step9"); ?></li>
                                                        </ol>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <div id="iscb" class="tab-pane">
                                            <div class="col-sm-12 text-center">
                                                <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_scb.jpg">
                                            </div>
                                            <div class="col-sm-12">
                                                <dl>
                                                    <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                    <dd>
                                                        <ol>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step1"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step2"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step3"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step4"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step5"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step6"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step7"); ?>
                                                                <p><?php echo __("thankyou-ibankscb-howto-step7-subtitle"); ?></p>
                                                                <ol>
                                                                    <li><?php echo __("thankyou-ibankscb-howto-step7.1"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankscb-howto-step7.2"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankscb-howto-step7.3"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankscb-howto-step7.4"); ?></li>
                                                                </ol>
                                                            </li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step8"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step9"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step10"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step11"); ?></li>
                                                            <li><?php echo __("thankyou-ibankscb-howto-step12"); ?></li>
                                                        </ol>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <div id="ibangkok" class="tab-pane">
                                            <div class="col-sm-12 text-center">
                                                <img src="http://www.itruemart.com/assets/itruemart_new/global/images/logo_bangkok.jpg">
                                            </div>
                                            <div class="col-sm-12">
                                                <dl>
                                                    <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                    <dd>
                                                        <ol>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step1"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step2"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step3"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step4"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step5"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step6"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step7"); ?>
                                                                <ol><p><?php echo __("thankyou-ibankbangkok-howto-step7-subtitle"); ?></p>
                                                                    <li><?php echo __("thankyou-ibankbangkok-howto-step7.1"); ?></li>
                                                                    <li><?php echo __("thankyou-ibankbangkok-howto-step7.2"); ?></li>
                                                                    <li><?php echo __('thankyou-ibankbangkok-howto-step7.3'); ?></li>
                                                                    <li><?php echo __('thankyou-ibankbangkok-howto-step7.4'); ?></li>
                                                                    <li><?php echo __('thankyou-ibankbangkok-howto-step7.5'); ?></li>
                                                                </ol>
                                                            </li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step8"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step9"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step10"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step11"); ?></li>
                                                            <li><?php echo __("thankyou-ibankbangkok-howto-step12"); ?></li>
                                                        </ol>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Content -->
    </div>
</div>
<div class="footer__bg_main-link" <?php echo (Request::is("search2"))? "style='margin-top:0px !important'" : ""; ?>>
    <div class="footer__inner_wrapper">
        <div class="footer__bar_main-link">
            <div class="main-link_service">
                <ul class="service_cs">
                    <li class="title_text"><?php echo $promotions['name'];?></li>
                    <?php foreach($promotions['links'] as $promotion):?>
                        <li><a href="<?php echo $promotion['href'];?>" title="<?php echo $promotion['title'];?>"><?php echo $promotion['html'];?></a></li>
                    <?php endforeach; ?>
                </ul>
                <ul class="service_category">
                    <li class="title_text"><?php echo $services['name'];?></li>
                    <?php foreach($services['links'] as $service):?>
                        <li><a target="_blank" href="<?php echo $service['href'];?>" title="<?php echo $service['title'];?>"><?php echo $service['html'];?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="main-link_payment">
                <?php if (Input::has('debug-payments')) : ?>
                <?php alert($payments, 'red'); ?>
                <?php endif; ?>
                <ul class="payment_channel" style="width: 110%;">
                    <li class="title_text"><?php echo $payments['title']; ?></li>
                    <?php if(!empty($payments['links'])) :?>
                    <?php foreach ( $payments['links'] as $payment ) : ?>
                        <li class="channel_name">
                            <?php if(isset($payment['href']) && isset($payment['image'])): ?>
                                <?php if ( ! empty($payment['href'])) : ?>
                                <a class="channel_link icn" href="<?php echo $payment['href']? : "#"; ?>">
                                    <img src="<?php echo Theme::asset()->usePath()->url('images/icn/' . $payment['image']); ?>?291014" width="37" />
                                </a>
                                <?php else : ?>
                                    <img src="<?php echo Theme::asset()->usePath()->url('images/icn/' . $payment['image']); ?>?291014" width="37" style="display:block; float:left;" />
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ( ! empty($payment['href'])) : ?>
                            <a class="channel_link" href="<?php echo $payment['href']? : "#"; ?>">
                                <?php echo $payment['html']; ?>
                            </a>
                            <?php else : ?>
                                <span style="margin-left:15px; font-size:12px; color:#959595; display:block; float:left;"><?php echo $payment['html']; ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="footer__bg_social">
    <div class="footer__inner_wrapper">
        <div class="footer__bar_social">
            <div class="social_aboutus">
                <div class="title_text">
                    <?php echo __("footer_about_us_more"); ?>
                </div>

                <div class="aboutus_content">
                    <span>
                        <?php echo __("footer_follow_data"); ?>
                    </span>
                    <?php echo $footer_seo_essay['seo_description']; ?>
					<span class="title_text"><a href="<?php echo URL::toLang("contact_us"); ?>"> <?php echo __('here');?></a></span>
                </div>


            </div>
            <div class="social_fb">
                <div class="title_text">
                    <?php echo __("footer_follow_us"); ?>
                </div>
                <div class="social_channel">
                    <?php if ( !empty($footer_socials) ): ?>
                        <ul class="channel_list">
                            <?php foreach ( $footer_socials as $social ) : ?>
                                <?php if ( $social['text'] == "Facebook" ): ?>
                                    <?php $facebook_link = $social['href']; ?>
                                    <li><a target="_blank" href="<?php echo $social['href']; ?>"><img src="<?php echo Theme::asset()->usePath()->url('images/icn/fb_icon.png'); ?>" height="36" width="36"/></a></li>
                                <?php elseif ( $social['text'] == "Twitter" ): ?>
                                    <li><a target="_blank" href="<?php echo $social['href']; ?>"><img src="<?php echo Theme::asset()->usePath()->url('images/icn/twitter_icon.png'); ?>" height="36" width="36"/></a></li>
                                <?php elseif ( $social['text'] == "googleplus" ): ?>
                                    <li><a target="_blank" href="<?php echo $social['href']; ?>"><img src="<?php echo Theme::asset()->usePath()->url('images/icn/google_icon.png'); ?>" height="36" width="36"/></a></li>
                                <?php elseif ( $social['text'] == "youtube" ): ?>
                                    <li><a target="_blank" href="<?php echo $social['href']; ?>"><img src="<?php echo Theme::asset()->usePath()->url('images/icn/Youtube_icon.png'); ?>" height="36" width="36"/></a></li>
                                <?php elseif ( $social['text'] == "Instagram" ): ?>
                                    <li><a target="_blank" href="<?php echo $social['href']; ?>"><img src="<?php echo Theme::asset()->usePath()->url('images/icn/Instagram_icon.png'); ?>" height="36" width="36"/></a></li>
                                <?php elseif ( $social['text'] == "Pinterest" ): ?>
                                    <li><a target="_blank" href="<?php echo $social['href']; ?>"><img src="<?php echo Theme::asset()->usePath()->url('images/icn/Pinterest_icon.png'); ?>" height="36" width="36"/></a></li>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="channel_email">
                        <!--                        <input class="form-control" id="subscribe_news" name="subscribe_news" placeholder="--><?php //echo __("footer_subscribe_placeholder"); ?><!--" />-->
                        <!--                        <button class="btn_send_email btn-subscribe-news">--><?php //echo __("footer_subscribe_btn"); ?><!--</button>-->
                        <!--                        <div id="msg_subscribe" style="display: none;"></div>-->
                    </div>
                </div>
<!--                <div class="title_text">-->
<!--                    --><?php //echo __("footer_follow_us_with"); ?><!-- <a href="--><?php //echo (!empty($facebook_link)) ? $facebook_link : "#" ?><!--" target="_blank">Facebook.com</a>-->
<!--                </div>-->
<!--                <div class="fb_content">-->
<!--                    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fitruemart&amp;width=338&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=523836897731311" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:338px; height:258px;" allowTransparency="true"></iframe>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>
<div class="footer__bg_bottom">
    <div class="footer__inner_wrapper">
        <div class="footer__bar_bottom">
            <div class="bottom_copyright">
                <p class="title_text">&copy;Copyright 2015 iTrueMart Philippines, Ascend eCommerce Philippines Inc. All rights reserved.</p>
                <span>
                    <?php echo __("footer_customer_service_desc"); ?><br/>
                    <?php echo __("footer_neighbor_link_title"); ?><!-- : <a href="--><?php //echo Config::get("endpoints.weloveshipping_url"); ?><!--">weloveshopping.com</a>, <a href="--><?php //echo Config::get("endpoints.truestore_url"); ?><!--">store.truecorp.co.th</a>-->
                </span>
            </div>
            <div class="bottom_secure">
                <a class="secure_by" href="<?php echo Config::get("endpoints.dragonpay_url"); ?>">
                    <img src="<?php echo Theme::asset()->usePath()->url('images/icn/dragonpay-logo.jpg'); ?>" height="75px" width="220px"/>
                </a>
                <!--                <div class="secure_by">
                                    <img src="<?php echo Theme::asset()->usePath()->url('images/icn/dbd.jpg'); ?>"/>
                                </div>-->
                <div id='ajaxDivReg'style="display:inline-block;" class="secure_by">
                    <script type="text/javascript">var port=(window.location.protocol=="https:")?"":":80";var redirect=false;var secureurl=(window.location.protocol=="https:")?"www.trustmarkthai.com":"www.dbdecommerce.com";var ebansite=window.location.protocol+"//"+secureurl+port+"/eban/logo";var sites=[ebansite];function initialScriptReg(){callOtherDomain(sites,1,'0105544006414','www.trustmarkthai.com','ajaxDivReg')}function addLoadEventReg(a){var b=window.onload;if(typeof window.onload!='function'){window.onload=a}else{window.onload=function(){b();a()}}}addLoadEventReg(initialScriptReg);function AJAXInteraction(c,e,f,g,h){var i=document.getElementById(h);var j;var k=navigator.userAgent;if(k.indexOf('MSIE')>0){if('XDomainRequest'in window&&window.XDomainRequest!==null){j=new XDomainRequest();j.open("get",c+'?uid='+f+'&url='+window.location.host+'&pic='+e);j.onload=function(){i.innerHTML=j.responseText};j.onerror=function(){_result=false};j.send()}}else{j=new XMLHttpRequest();j.onreadystatechange=processRequest}var d=new Date;function processRequest(){if(j.readyState==4){var a=new Date;var b=a.getTime()-d.getTime();if(b<18000&&((j.status!=0&&j.status!=502)||j.status==200)){i.innerHTML=j.responseText}else{if(window.location.protocol=="http:"&&!redirect){makeRequest("https://"+g+"/eban/logo");redirect=true}else{if(typeof i.innerHTML != 'undefined'){ i.innerHTML="LOGO Doesn't exist"}}}}this.doGet=function(){j.open("GET",c+'?uid='+f+'&url='+window.location.host+'&pic='+e,true);j.send()}}function makeRequest(a,b,c,d,e){var f=new AJAXInteraction(a,b,c,d,e);f.doGet()}function callOtherDomain(a,b,c,d,e){for(var i=0;i<a.length;i++){makeRequest(a[i],b,c,d,e)}}function dbd_popup_show(a){try{window.open(a,'dbdcer','width=530,height=640,scrollbars=no,location=no,resizable=no')}catch(e){window.showModalDialog(a,'dbdcer','dialogWidth:530px;dialogHeight:640px;')}}}</script>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">var $zoho= $zoho || {salesiq:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/ascendph/float.ls?embedname=embed1.customerloyaltyteam";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script>
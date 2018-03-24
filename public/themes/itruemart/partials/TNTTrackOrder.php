<div id="tnt-tracking-lightbox" class="sub-content-n headline reveal-modal" >
    <div class="box-done">
        <div class="ini-track linedottop">
            <div class="inin-track ">
                <div class="trackhead"><?php echo __("tracking-parcel-title"); ?>
                    <span style="float:right;">
                        <a href="javascript:;" class="close-modal-order-tracking">
                            <img src="<?php echo Theme::asset()->usePath()->url("images/close.png"); ?>" />
                        </a>
                    </span>
                </div>
                <div class="tracking-status">
                    <div class="h-tracking-status">
                        <div class="trk-col-mdy h-trk-col"><?php echo __("tracking-parcel-date-title"); ?></div>
                        <div class="trk-col-time h-trk-col"><?php echo __("tracking-parcel-time-title"); ?></div>
                        <div class="trk-col-location h-trk-col"><?php echo __("tracking-parcel-place-title"); ?></div>
                        <div class="trk-col-status h-trk-col"><?php echo __("tracking-parcel-status-title"); ?></div>
                        <div class="clear"></div>
                    </div>
                    <!---------------- list status------------->
<!--                    <div class="trk-status-row">
                        <div class="trk-row-mdy">วัน/เดือน/ปี</div>
                        <div class="trk-row-time">เวลา</div>
                        <div class="trk-row-location">สถานที่</div>
                        <div class="trk-row-status">สถานะพัสดุ</div>
                        <div class="clear"></div>
                    </div>-->
                    
                    <!----------------End list status------------->
                    <div class="clear"></div>
                </div>
            </div>
            <div class="print-box">
                <div class="print_n"><a href="<?php echo URL::toLang("/"); ?>"><?php echo __("tracking-parcel-back-shipping"); ?></a></div>
                <div class="clear"></div>
            </div>
            <div class="success-box-footer"><?php echo __("tracking-parcel-notice1"); ?></div>
        </div>
        <div class="box-footer"> <br />
            <p class="p-call"><?php echo __("tracking-parcel-notice2"); ?></p>
            <div class="success-box-contact">
                Call Center +66(0)2-900-9999<br/>
                <?php echo __("thankyou-footer-success-contact-time"); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
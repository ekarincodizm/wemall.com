<div class="row header-section">
    <div class="col-xs-6 ui-logo" id="logo">
        <a href="<?php echo URL::toLang("/", array()); ?>">
            <img src="<?php echo Theme::asset()->usePath()->url("img/itruemart_logo.png"); ?>" alt="itruemart">
        </a>
    </div>
    <div id="step-nav" class="col-xs-6 text-right">
        <?php if(Request::segment(2) == "step1"): ?>
            <img src="<?php echo Theme::asset()->usePath()->url("img/step_1.png"); ?>" alt="itruemart checkout" />
        <?php elseif(Request::segment(2) == "step2"): ?>
            <img src="<?php echo Theme::asset()->usePath()->url("img/step_2.png"); ?>" alt="itruemart checkout" />
        <?php elseif(Request::segment(2) == "step3"): ?>
            <img src="<?php echo Theme::asset()->usePath()->url("img/step_3.png"); ?>" alt="itruemart checkout" />
        <?php elseif(Request::segment(2) == "thank-you"): ?>
            <img src="<?php echo Theme::asset()->usePath()->url("img/step_4.png"); ?>" alt="itruemart checkout" />
        <?php endif; ?>
    </div>
</div>
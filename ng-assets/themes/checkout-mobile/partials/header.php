<div class="inc-logo">
    <a href="<?php echo url(); ?>">
        <img src="<?php echo Theme::asset()->usePath()->url('images/logo/itruemart_logo.png?q=102014'); ?>" alt="" />
    </a>
    <?php if (!empty($step)): ?>

        <?php if (!empty($step) && $step != 'step-4'): ?>
            <div id="step-nav">
                <?php
                if (!empty($step) && $step != 'step') {
                    $class_step = $step;
                } else {

                    $class_step = 'step-1';
                }
                ?>
                <ul class="<?php echo $class_step; ?>">
                    <li class="step-icn">1</li>
                    <li class="step-line"></li>
                    <li class="step-icn">2</li>
                    <li class="step-line"></li>
                    <li class="step-icn">3</li>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
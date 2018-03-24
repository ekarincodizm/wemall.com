<div class="content-home sub">
    <div id="wrapper_content">
        <h1><?php echo __('Register via Email'); ?></h1>
        <?php echo Form::open(array('url' => URL::route('users.register', array('type' => 'email')))); ?>
            <p>Email: <?php echo Form::text('email'); ?></p>
            <p>Name: <?php echo Form::text('display_name'); ?></p>
            <p>Password: <?php echo Form::text('password'); ?></p>
            <p>Confirm Password: <?php echo Form::text('password_confirmation'); ?></p>
            <p>Thai ID: <?php echo Form::text('thai_id'); ?></p>
            <p><?php echo Form::submit(); ?>
        <?php echo Form::close(); ?>
        </p>

        <hr />

        <h1><?php echo __('Register via Mobile'); ?></h1>
        <?php echo Form::open(array('url' => URL::route('users.register', array('type' => 'mobile')))); ?>

            <?php if ( ! Session::get('otp-passes')) : ?>
            <div id="register-step-1">
                <p>Mobile: <?php echo Form::text('mobile', null, array('id' => 'mobile')); ?></p>
                <a href="javascript:registerRequestOtp(document.getElementById('mobile'));">Request otp</a>
                <p>OTP: <?php echo Form::text('otp', null, array('id' => 'otp')); ?></p>
                <a href="javascript:registerValidateOtp(document.getElementById('mobile'), document.getElementById('otp'));">Confirm</a>
            </div>
            <?php endif; ?>


            <div id="register-step-2" style="display:<?php echo Session::get('otp-passes') ? 'block' : 'none'; ?>">
                <p>
                    Mobile: <span id="mobile-display"><?php echo Session::get('otp-passes'); ?></span>
                </p>
                <p>
                    Thai ID: <?php echo Form::text('thai_id'); ?></p>
                </p>
                <p>Password: <?php echo Form::text('password'); ?></p>
                <p>
                    <p>Confirm Password: <?php echo Form::text('password_confirmation'); ?></p>
                </p>
                <p><?php echo Form::submit(); ?>
            </div>

        <?php echo Form::close(); ?>
        </p>
    </div>

</div>

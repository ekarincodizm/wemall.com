<style>
    #form-checkout .input-box{max-width:275px;float: left;}
    .form-max {width:470px;}
</style>
<div class="title">
    <h1><?php echo __('ล็อกอิน'); ?></h1>
</div>
<div class="in-form">
    <form action="<?php echo URL::to("checkout/step1"); ?>" method="post" id="form-checkout">
        <div>
            <p class="control-label left">
                <label for="email"><?php echo __('กรอกอีเมล์ของคุณ '); ?>: </label>
            </p>
            <div class=" form-max">
                <input class="input-box" name="email" type="text" placeholder="email@mail.com">
            </div>
        </div>
        <div class="clear"></div>
        <div>
            <div class=" form-max">
                <p>
                    <input id="guest" name="logintype" type="radio" value="" checked="checked">
                    <label for="guest" class="control-desc"><?php echo __('สั่งซื้อทันทีโดยไม่ใช้รหัสผ่าน'); ?></label></p>
            </div>
        </div>
        <div class="clear"></div>
        <div>
            <div class=" form-max">
                <p>
                    <input id="user1" name="logintype" type="radio" value="">
                    <label for="user1" class="control-desc"><?php echo __('ฉันมีบัญชีผู้ใช้อยู่แล้ว'); ?></label></p>
            </div>
        </div>
        <div class="clear"></div>
        <div id="pwd-box" style="display: none;">
            <div>
                <p class="control-label left">
                    <label for="password"><?php echo __('รหัสผ่าน'); ?> : </label>
                </p>
                <div class=" form-max">
                    <input class="input-box" maxlength="15" id="password" name="password" type="password" placeholder="<?php echo __('กรอกรหัสผ่านของคุณที่นี่'); ?>">
                </div>
            </div>
            <div class="clear"></div>
            <div>
                <div class=" form-max">
                    <p><a href="#" class="clr-6"><?php echo __('ลืมรหัสผ่าน'); ?> ?</a></p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div>
            <div class=" form-max" style="color: red;">
                <?php echo $errors->first(); ?>
            </div>
        </div>
        <div class="clear"></div>
        
        <div>
            <div class=" form-max">
                <input class="form-bot" name="" type="submit" value="<?php echo __('ดำเนินการต่อ'); ?>" >
            </div>
        </div>
    </form>
</div>
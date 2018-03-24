<div id="header">
    <?php if (ACL::isLoggedIn() == true) : ?>
    <?php $user = ACL::getUser(); ?>
    <div class="topbar">
        <div style="padding:9px 0 0 10px; float:left;"> 
            <a href="<?php echo url(); ?>" title="iTrueMart">
                <img src="<?php echo Theme::asset()->usePath()->url('images/logo_ph.png?q=102014'); ?>" style="height:50px;" />
            </a>
        </div>
        <div class="on_login">
        </div>
        
    </div>
    <?php else : ?>
    <div class="topbar">
		<div style="padding:9px 0 0 10px; float:left;"> 
			<a title="iTrueMart" href="<?php echo url(); ?>">
				<img width="135" height="26" src="<?php echo Theme::asset()->usePath()->url('images/logo.png?q=102014'); ?>">
			</a>
		</div>
		<!-- <div class="login">
			<?php $server_url = /*$_SERVER['SERVER_NAME'].*/$_SERVER['REQUEST_URI']; #echo $server_url; exit(); ?>
			<?php /*<a href="<?php echo URL::route('auth.login', array('continue' => URL::toLang($server_url, array() ))); ?>">เข้าระบบ</a>*/ ?>
		</div>
		-->
	</div>
    <?php endif; ?>
</div>
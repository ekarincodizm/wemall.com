<?php $lang = App::getLocale();?>
<div id="subscribe">
	<div id="sendmail">
		<span>Subscribe to our email newsletter.</span>
		<input type="hidden" id="c_lang" name="c_lang" value="<?php echo $lang;?>" />
		<input type="text" id="subscribe-box" name="subscribe-box" />
		<input type="submit" value="SUBMIT" id="btn-subscribe" name="btn-subscribe" style="display: inline;" />
		<img src="/ajax-loader.gif" id="loading_email" width="20" style="margin-left: 20px; display:none;" />
		<div id="err_subscribe" name="err_subscribe" style="margin-top: 15px;"></div>
	</div>
	<div id="fb-panel">
		<div id="fb-root">
		</div>
		<script>
			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=116147761878895";
				fjs.parentNode.insertBefore(js, fjs);
			} (document, 'script', 'facebook-jssdk'));
		</script>
		<fb:like href="https://www.facebook.com/itruemart" send="true" width="330" show_faces="true"
			font="arial">
		</fb:like>
	</div>
</div>
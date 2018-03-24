<div id="main_wrapper">
    <div id="content_wrapper">
        <div class="clear"></div>
        <div class="space"></div>
        <div class="space"></div>
        <div class="boxcontent" style="margin-top:50px; height:382px;">
            <div class="center thank3" style="margin-top:50px;">
                Please wait ...<br>
                <span class="thank4">This page will automatically redirect within 3 seconds<br>If it can't redirect please <a href="<?php echo URL::to('/'); ?>" style="color:#999">Click Here</a> for redirect manually.</span>
            </div>
            <div class="space"></div>
            <div class="space"></div>
            <div class="space"></div>
            <div class="space"></div>
            <div class="center">
                <img src="<?php echo Theme::asset()->usePath()->url('images/loading-bar.gif'); ?>">
            </div>
            <div class="space"></div>
        </div>
    </div>

    <div class="space"></div>
    <div class="clear"></div>


</div>

<style>
body {
    padding:0px;
    margin:0px;
    background-color:#eee;
    font-family:Tahoma;
    font-size:12px;

}

html, body, td, div, input, select, textarea {
    font:12px Tahoma;

}

#main_wrapper {
width: 992px;
height: auto;
margin: 0 auto;
padding: 0 0 10px 0;
}

#content_wrapper {
width: 992px;
height: auto;
padding: 0 0 10px 0;
}

.clear {
clear: both;
}

.space {
height: 10px;
}

.boxcontent {
width: 990px;
height: 380px;
border: solid thin;
border-color: #CCC;
background-color: #FFF;
border-radius: 6px;
-moz-border-radius: 6px;
-webkit-border-radius: 6px;
}

.center {
text-align: center;
}

.thank3 {
color: #C1CC23;
font-size: 22px;
line-height: 30px;
margin: 150px 0 0 0;
}

.thank4 {
color: #000;
font-size: 18px;
line-height: 24px;
}


</style>
<script type="text/javascript">
    // It works without the History API, but will clutter up the history
    var history_api = typeof history.pushState !== 'undefined'

    // The previous page asks that it not be returned to
    if ( location.hash == '#no-back' ) {
        // Push "#no-back" onto the history, making it the most recent "page"
        if ( history_api ) history.pushState(null, '', '#stay')
        else location.hash = '#stay'

        // When the back button is pressed, it will harmlessly change the url
        // hash from "#stay" to "#no-back", which triggers this function
        window.onhashchange = function() {
            // User tried to go back; warn user, rinse and repeat
            if ( location.hash == '#no-back' ) {
                alert("You shall not pass!")
                if ( history_api ) history.pushState(null, '', '#stay')
                else location.hash = '#stay'
            }
        }
    }
</script>
<img id="sign_me_up_bar" src="<?php echo URL::to('themes/itruemart/assets/images/sign_me_up_bar.png'); ?>" alt="">

<div id="ads-container">
    <div id="hide_subscribe_box">
        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
    </div>
    <iframe id="floating-ads" frameborder=0 allowtransparency=yes scrolling=no src="<?php echo URL::to('themes/itruemart/views/subscribe_box/subscribe_box.php');?>">
    </iframe>
</div>

<script>
    $( "#sign_me_up_bar" ).click(function() {
        $( "#sign_me_up_bar" ).hide();
        $( "#ads-container").show();
    });

    $("#hide_subscribe_box").click( function() {
        $( "#ads-container").hide();
        $( "#sign_me_up_bar" ).show();
    });
</script>

<!--[if lte IE 10]>
<style>
    #sign_me_up_bar {
    display: none !important;
    }
</style>
<![endif]-->

<style>
    #sign_me_up_bar {
        position: fixed;
        bottom: -10px;
        left: 0;
        z-index: 2247483647 !important;
        cursor: pointer;
    }
    #ads-container {
        background-color: #213063;
        display: none;
    }
    #hide_subscribe_box {
        position: fixed;
        bottom: 365px;
        left: 225px;
        z-index: 1001;
        color: white;
        cursor:pointer;
    }
    #floating-ads {
        z-index: 1000;
        width: 250px;
        height: 390px;
        position: fixed;
        left: 0px;
        bottom: 0px;
        border: 0;
    }
</style>

<?php
header("HTTP/1.1 503 Service Temporarily Unavailable");
header("Status : 503 Service Temporarily Unavailable");
header("Retry-After: 10800");
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width"/>
    <title></title>
    <link rel="stylesheet" href="/themes/whoop/css/main_error.css"/>
</head>
<body>
<div class="error__container">
    <div class="error__head">
        <img class="head__img_logo" src="/themes/whoop/img/main_logo-ed.png" alt=""/>

        <div class="error__msgbox__container">
            <div class="display_text">
                <marquee behavior="scroll" direction="left" scrollamount="3">ขออภัยในความไม่สะดวก
                    เนื่องจากมีผู้ให้ความสนใจโปรโมชั่น ช้อปให้ทัน วันละบาท
                    เป็นจำนวนมาก
                    เรากำลังดำเนินการขยายเซิร์ฟเวอร์เพื่อให้คุณกลับมาช้อปได้อย่างเร่งด่วนที่สุด
                </marquee>
            </div>
        </div>
    </div>
    <div class="error__content">
        <img class="error__main_msg" src="/themes/whoop/img/main_msg-4am.png" alt=""/>
        <img class="error__main_img" src="/themes/whoop/img/main_img.jpg" alt=""/>
    </div>
    <?php
    $pagename = "Maintenance";
    echo '<script type="text/javascript">__th_page="' . $pagename . '";</script>
                <script type="text/javascript" src="http://hits.truehits.in.th/data/t0030923.js"> </script>
                <noscript>
                <a target="_blank" href="http://truehits.net/stat.php?id=t0030923">
                <img src="http://hits.truehits.in.th/noscript.php?id=t0030923" alt="Thailand Web Stat" border="0" width="14" height="17" />
                </a>
                <a target="_blank" href="http://truehits.net/">Truehits.net</a>
                </noscript>';
    ?><!-- End Save for Web Slices -->
</div>
</body>
</html>
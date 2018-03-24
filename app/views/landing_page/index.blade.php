<html>
<head>
    <title>iTruemart</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript">
        function MM_swapImgRestore() { //v3.0
            var i, x, a = document.MM_sr;
            for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
        }
        function MM_preloadImages() { //v3.0
            var d = document;
            if (d.images) {
                if (!d.MM_p) d.MM_p = new Array();
                var i, j = d.MM_p.length, a = MM_preloadImages.arguments;
                for (i = 0; i < a.length; i++)
                    if (a[i].indexOf("#") != 0) {
                        d.MM_p[j] = new Image;
                        d.MM_p[j++].src = a[i];
                    }
            }
        }

        function MM_findObj(n, d) { //v4.01
            var p, i, x;
            if (!d) d = document;
            if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
                d = parent.frames[n.substring(p + 1)].document;
                n = n.substring(0, p);
            }
            if (!(x = d[n]) && d.all) x = d.all[n];
            for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
            for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
            if (!x && d.getElementById) x = d.getElementById(n);
            return x;
        }

        function MM_swapImage() { //v3.0
            var i, j = 0, x, a = MM_swapImage.arguments;
            document.MM_sr = new Array;
            for (i = 0; i < (a.length - 2); i += 3)
                if ((x = MM_findObj(a[i])) != null) {
                    document.MM_sr[j++] = x;
                    if (!x.oSrc) x.oSrc = x.src;
                    x.src = a[i + 2];
                }
        }
    </script>
    <style type="text/css">
        body {
            background-color: #fff;
        }

        body, td, th {
            font-size: 12px;
            font-family: Arial, Tahoma;
        }
    </style>
</head>
<body onLoad="MM_preloadImages('/assets/events/mom/btn-mainpage-hover.png')">
<div style="width:980px; margin:0 auto;">
    <div style="width:980px; margin-bottom:20px;">
        <img src="/assets/events/mom/coverpage.jpg"
             alt="ซื้อของออนไลน์ ช้อปปิ้งออนไลน์ มือถือ แท๊บเล็ต สมาร์ทโฟน gadget หูฟัง เครื่องใช้ไฟฟ้า เครื่องออกกำลังกาย โปรโมชั่นพิเศษ iphone samsung"
             border="0"></div>


    <div style="clear:both;"></div>
    <div style="width:980px; height:auto; text-align:center; margin:0;"><a href="<?php echo URL::to('/'); ?>"
                                                                           onMouseOut="MM_swapImgRestore()"
                                                                           onMouseOver="MM_swapImage('Image2','','/assets/events/mom/btn-mainpage-hover.png',1)"><img
                    src="/assets/events/mom/btn-mainpage.png" width="250" height="45" id="Image2" style="border:0"></a>
    </div>

    <h1><!-- End Save for Web Slices --></h1>
</div>
</body>
</html>
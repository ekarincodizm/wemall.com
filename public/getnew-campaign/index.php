<!DOCTYPE html>
<html lang="th">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ร่วมสนุก ถ่ายรูปคุณกับเครื่องใช้ไฟฟ้า หรืออุปกรณ์อิเลคทรอนิกส์ ที่คุณอยากเปลี่ยนใหม่ พร้อมใส่ #getnewitruemart แล้วแชร์ผ่าน Facebook หรือ Instagram รูปไหนโดน! ลุ้นรับของรางวัลแบรนด์แท้ ฟรี!...ทุกสัปดาห์">
    <meta name="author" content="iTruemart">
    
    <meta property="og:title" content="iTrueMart.com - ถ่ายเล่น แชร์จริง ลุ้นฟรี!!!" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="http://www.itruemart.com/bestvalue-video/images/facebook-link.jpg" />
    <meta property="og:url" content="http://www.itruemart.com/bestvalue-video/" />
    <meta property="og:description" content="ร่วมสนุก ถ่ายรูปคุณกับเครื่องใช้ไฟฟ้า หรืออุปกรณ์อิเลคทรอนิกส์ ที่คุณอยากเปลี่ยนใหม่ พร้อมใส่ #getnewitruemart แล้วแชร์ผ่าน Facebook หรือ Instagram รูปไหนโดน! ลุ้นรับของรางวัลแบรนด์แท้ ฟรี!...ทุกสัปดาห" />

    <title>iTrueMart.com - ถ่ายเล่น แชร์จริง ลุ้นฟรี!!!</title>

    <title>iTrueMart.com - แบรนด์แท้ ราคาโดน</title>
	<link rel="stylesheet" href="stylesheets/foundation.min.css">
	<link rel="stylesheet" href="stylesheets/main.css">
	<link rel="stylesheet" href="stylesheets/app.css">
	<script src="javascripts/modernizr.foundation.js"></script>
	<script src="javascripts/jquery.js"></script> 
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link href="css/main.css" rel="stylesheet">
    <script type="text/javascript">
    
    var total_pages     =   1;    
    var current_page    =   1;
    var loading         =   false;
    var oldscroll       =   0;

    $(document).ready(function(){
	
		$('#loading').hide();

        if( ! loading ){
          loading = true;
          $('#spinner').show();  
          $.ajax({ 
              type: "GET",
              'url':'http://support.itruemart.com/hashtag/read_data.php',
              data: 'p='+current_page,
              success:function(data){ 
                  $(data).hide().appendTo('#container').fadeIn(2000);
                  current_page++;
                  total_pages = $('#total_pages').val();  
                  $('#spinner').hide();
                  loading = false;
              }
          });  
        }
        
     
        $(window).scroll(function() {
            if( $(window).scrollTop() > oldscroll ){ //if we are scrolling down
              if( ($(window).scrollTop() + $(window).height() >= ($(document).height()/6)*5) && (current_page <= total_pages) && current_page!=1) {
                       if( ! loading ){
                            loading = true;
                            $('#loading').show();  
                            $.ajax({
                                'url':'http://support.itruemart.com/hashtag/read_data.php',
                                'type':'get',
                                'data': 'p='+current_page,
                                success:function(data){
                                     
                                    $(data).hide().appendTo('#container').fadeIn(2000);
                                    current_page++; 
                                    $('#loading').hide();
                                    loading = false;
                                }
                            });
                       }
                }
            }
        });
     
		var resize = function() {
			var $epicContainer = $('#epic').find('.container'),
			$epicContainerWidth = $epicContainer.removeAttr('style').width(),
			itemWidth = 232, nWidth;
			
			if(($epicContainerWidth + 30) % itemWidth > 0){
				nWidth = (Math.floor($epicContainerWidth / itemWidth)) * itemWidth;
				$epicContainer.width(nWidth)
				.find('#container').width(nWidth);
			}
		}
		
		$(document).ajaxComplete(function(){
		setTimeout(function(){
		resize();
		}, 50);
		});
		$(window).on('resize', resize);
    });
  

    </script>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    

  <!--Google Analytics-->
  <!--
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-41231050-5', 'auto');
      ga('require', 'displayfeatures');
      ga('require', 'linkid', 'linkid.js');
      ga('send', 'pageview');

  </script>
  -->

  
 

  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <!--
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54dc17ef3be63658" async="async"></script>
  -->

  </head>

  <body>

  

  <!--TopNav-->
  
  <div class="container-fluid no-padding" id="top-nav">
    <!--
    <div class="container">
      <a href="http://www.itruemart.com/" target="_blank">
        <div class="itm-logo">
          <img src="images/itruemart-logo.png" class="img-responsive">
        </div>
      </a>
      <a href="http://www.itruemart.com/" target="_blank">
        <div class="subtitle">ศูนย์รวมเครื่องใช้ไฟฟ้าและอุปกรณ์อิเล็กทรอนิกส์</div>
      </a>
    </div>
  -->
  </div>
  

  <!--Banner-->
  <div class="container-fluid no-padding centered" id="campaign-banner">
    <!--
    <img src="images/campaign-header.png" class="desktop-only" style=" margin:auto;"> 
    <img src="images/getnew-logo.png" class="mobile-only img-responsive" style="padding:20px; margin:auto;">    
    <h2><span class="red">ร่วมสนุก</span> ถ่ายรูปคุณกับเครื่องใช้ไฟฟ้า หรืออุปกรณ์อิเลคทรอนิกส์ ที่คุณอยากเปลี่ยนใหม่</h2>
    <div class="desktop-only">
      <p>พร้อมใส่ <span class="red">#getnewitruemart</span> แล้วแชร์ผ่าน <span class="red">Facebook</span> หรือ <span class="red">Instagram</span></p>
      <h4>รูปไหนโดน! <span class="red">ลุ้นรับของรางวัลแบรนด์แท้ ฟรี!</span>...ทุกสัปดาห์</h4>
    </div>
    -->
    <div class="container desktop-only">
      <img src="images/campaign-banner.png" class="img-responsive"  style="margin:auto;">
    </div>
    <div class="container mobile-only">
      <img src="images/campaign-banner-mobile.png" class="img-responsive" style="margin:auto;">
    </div>
  </div>
  

    
  <div class="container-fluid centered" id="campaign-btn">
    
    <a href="#"  data-toggle="modal"  data-target="#modal-howto">
      <div>
        วิธีการร่วมสนุก
      </div>
    </a>
    <span>|</span>
    <a href="#"  data-toggle="modal"  data-target="#modal-prize">
      <div>
        ของรางวัล
      </div>
    </a>
    <span>|</span>
    <a href="#"  data-toggle="modal"  data-target="#modal-winner">
      <div>
        ประกาศผล
      </div>
    </a>
  </div>
  

  <!--Epic-->
  <div class="container-fluid" id="epic">
    <div class="container">
		<div id="container">

		</div>
	  <div class="sk-spinner sk-spinner-three-bounce" id="spinner" style="padding:100px 0 100px 0">
      <div class="sk-bounce1"></div>
      <div class="sk-bounce2"></div>
      <div class="sk-bounce3"></div>
    </div>
    </div>
  </div>


  <!--iTrueMart Intro-->
    <div class="container-fluid centered" id="intro-zone2">
    <div class="panel centered">
      <a href="http://www.itruemart.com/">
        <div class="itm-logo">
          <img src="images/itruemart-logo.png" class="img-responsive">
        </div>
      </a>
      <h3>
        ศูนย์รวมสินค้าเครื่องใช้ไฟฟ้า และอุปกรณ์อิเล็กทรอนิกส์ แบรนด์แท้ ราคาโดน
        <br>
        ให้คุณเลือกช้อปได้อย่างมั่นใจ
      </h3>
    </div>
   </div> 
  












  <!--Footer-->
  <footer class="container-fluid centered">
    <div class="container">
      <a href="#campaign-banner">
          <div class="above">
            <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
          </div>
      </a>
    <a href="http://www.itruemart.com">©Copyright 2015 www.itruemart.com - All right reserved</a>
    </div>
  </footer>


  <!-- How-to Modal -->
    <div class="modal fade" id="modal-howto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
          </div>
          <div class="modal-body">   
          
          
          <h4>วิธีการร่วมสนุก</h4>
            <div class="desktop-only">
              <div class="media">
                <div class="media-left media-middle">
                  <img class="media-object" src="images/howto1.png">
                </div>
                <div class="media-body">
                  ถ่ายรูปอุปกรณ์เครื่องใช้ไฟฟ้าของคุณให้ตรงตามโจทย์ของแต่ละสัปดาห์ พร้อมถ่ายในรูปแบบที่สร้างสรรค์
                </div>
              </div>

              <div class="media">
                <div class="media-left media-middle">
                  <img class="media-object" src="images/howto2.png">
                </div>
                <div class="media-body">
                  แชร์ภาพนั้นออกไปพร้อมใส่ #getnewitruemart
                </div>
              </div>

              <div class="media">
                <div class="media-left media-middle">
                  <img class="media-object" src="images/howto3.png">
                </div>
                <div class="media-body">
                  รับรางวัลในสัปดาห์นั้นๆ
                </div>
              </div>
            </div>

            <div class="mobile-only">
              <ol>
                <li>ถ่ายรูปอุปกรณ์เครื่องใช้ไฟฟ้าของคุณให้ตรงตามโจทย์ของแต่ละสัปดาห์ พร้อมถ่ายในรูปแบบที่สร้างสรรค์
</li>
                <li>แชร์ภาพนั้นออกไปพร้อมใส่ #getnewitruemart</li>
                <li>รับรางวัลในสัปดาห์นั้นๆ</li>
              </ol> 
            </div>


            <hr>


            <h4 class="modal-title">โจทย์ภาพถ่ายแต่ละสัปดาห์</h4>
            <div class="desktop-only">
              <span class="red">สัปดาห์ที่ 1</span> : ถ่ายภาพเครื่องใช้ไฟฟ้าภายในครัว<br>
              <span class="red">สัปดาห์ที่ 2</span> : ถ่ายภาพเครื่องใช้ไฟฟ้าภายในห้องนั่งเล่น<br>
              <span class="red">สัปดาห์ที่ 3</span> : ถ่ายภาพมือถือ และแกดเจ็ต<br>
              <span class="red">สัปดาห์ที่ 4</span> : ถ่ายภาพอุปกรณ์อิเลคทรอนิกส์ต่างๆ
            </div>
            <div class="mobile-only">
              <span class="red">สัปดาห์ที่ 1</span><br>ถ่ายภาพเครื่องใช้ไฟฟ้าภายในครัว<br><br>
              <span class="red">สัปดาห์ที่ 2</span><br>ถ่ายภาพเครื่องใช้ไฟฟ้าภายในห้องนั่งเล่น<br><br>
              <span class="red">สัปดาห์ที่ 3</span><br>ถ่ายภาพมือถือ และแกดเจ็ต<br><br>
              <span class="red">สัปดาห์ที่ 4</span><br>ถ่ายภาพอุปกรณ์อิเลคทรอนิกส์ต่างๆ
            </div>

          </div>

          <hr>
          <div class="centered">
            <a href="
https://www.facebook.com/notes/itruemart/get-new-%E0%B8%A5%E0%B8%B8%E0%B9%89%E0%B8%99%E0%B8%A3%E0%B8%B1%E0%B8%9A%E0%B8%84%E0%B8%A7%E0%B8%B2%E0%B8%A1%E0%B8%AA%E0%B8%B8%E0%B8%82%E0%B8%88%E0%B8%B2%E0%B8%81-itruemartcom/996593137031132
">
                <span class="red">เงื่อนไขกิจกรรม</span>
            </a>
          </div>
          <br>

          
          
        </div>
      </div>
    </div>


    
    <!-- Prize Modal -->
    <div class="modal fade" id="modal-prize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
          </div>
          <div class="modal-body centered">   
          
          
          <h5>ของรางวัลประจำสัปดาห์</h5>

            <div id="prize-week1">
              <h5>
                <span class="red">สัปดาห์ที่ 1 : 11-17 พ.ค. 58</span>
              </h5>
              <h2>Mobile & Camera</h2>
              <div class="row centered">
                <div class="col-md-4">
                  <img src="images/W4_P1.png" class="img-responsive">
                  iPhone 6
                </div>
                <div class="col-md-4">
                  <img src="images/W4_P2.png" class="img-responsive">
                  FujiFilm Instax Mini 8 Pink
                </div>
                <div class="col-md-4">
                  <img src="images/W4_P3.png" class="img-responsive">
                  เครื่องฟอกอากาศ Air Picnic รุ่น AIR 168
                </div>
              </div>           
            </div>

            <div id="prize-week2" class="hide">
              <h5>
                <span class="red">สัปดาห์ที่ 2 : 18-24 พ.ค. 58</span>
              </h5>
              <h2>Home Appliance</h2>
              <div class="row centered">
                <div class="col-md-4">
                  <img src="images/W3_P1.png" class="img-responsive">
                  360 องศา ลู่วิ่งไฟฟ้า MTH SERIES MTH 4.0L
                </div>
                <div class="col-md-4">
                  <img src="images/W3_P2.png" class="img-responsive">
                  AUTOBOT ROBOT VACUUM รุ่น MINI T270RC PLASTEL SERIES-BLUE
                </div>
                <div class="col-md-4">
                  <img src="images/W3_P3.png" class="img-responsive">
                  เครื่องฟอกอากาศ Air Picnic รุ่น AIR 168
                </div>
              </div>
            </div>

      
            <div id="prize-week3" class="hide">
              <h5>
                <span class="red">สัปดาห์ที่ 3 : 25-31 พ.ค. 58</span>
              </h5>
              <h2>Kitchen</h2>
              <div class="row centered">
                <div class="col-md-4">
                  <img src="images/W2_P1.png" class="img-responsive">
                  ELETROLUX ตู้เย็น 9Q รุ่น ETB2600PE
                </div>
                <div class="col-md-4">
                  <img src="images/W2_P2.png" class="img-responsive">
                  STIEBEL เครื่องกรองน้ำ Rain II
                </div>
                <div class="col-md-4">
                  <img src="images/W2_P3.png" class="img-responsive">
                  MY HOME หม้อทอดไฟฟ้า 3 ลิตร 1200 วัตต์ AF301
                </div>
              </div>
            </div>


            <div id="prize-week4" class="hide">
              <h5>
                <span class="red">สัปดาห์ที่ 4 : 1-7 มิ.ย. 58</span>
              </h5>
              <h2>Electronics</h2>

              <div class="row centered">
                <div class="col-md-4">
                  <img src="images/W1_P1.png" class="img-responsive">
                  Panasonic DTV แอลอีดี ทีวี 42 นิ้ว รุ่น TH-42A410T
                </div>
                <div class="col-md-4">
                  <img src="images/W1_P2.png" class="img-responsive">
                  Sherman เครื่องเล่นดีวีดี Dolby Digital รุ่น DV-7
                </div>
                <div class="col-md-4">
                  <img src="images/W1_P3.png" class="img-responsive">
                  Polk Audio SurroundBar Blutooth รุ่น 5000
                </div>
              </div>
            </div>
          
        </div>
      </div>
    </div>
  </div>


    <!-- Winner Modal -->
    <div class="modal fade" id="modal-winner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
          </div>
          <div class="modal-body centered">   
          
          
          <h4>ประกาศผล</h4>
            
            รายชื่อผู้โชคดีสามารถติดตามได้ที่ <a href="https://www.facebook.com/itruemart"><span class="red">iTrueMart Facebook page</span></a>
           

          </div>
          
        </div>
      </div>
    </div>
      
    

    





    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>




    <script type="text/javascript">
   
    $(document).ready(function() { 
       $("#btn-movie1").click(function(){
        $("#movie2").hide();
        $("#movie1").show();

        $("#btn-movie2").addClass( "inactive" );
        $("#btn-movie1").removeClass( "inactive" );
      });

      $("#btn-movie2").click(function(){
        $("#movie1").hide();
        $("#movie2").show();

        $("#btn-movie1").addClass( "inactive" );
        $("#btn-movie2").removeClass( "inactive" );
      });
    });

    //Vertical Center Modal
    function centerModal() {
      $(this).css('display', 'block');
      var $dialog = $(this).find(".modal-dialog");
      var offset = ($(window).height() - $dialog.height()) / 2;
      offset = offset - 30;
      if(offset < 10) offset = 10;
      // Center modal vertically in window
      $dialog.css("margin-top", offset);
    }

    $('.modal').on('show.bs.modal', centerModal);
    $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
    });


    //Smooth Scroll
    $(function() {
      $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });

  </script>
  <script src="javascripts/foundation.min.js"></script> 
  <script src="javascripts/app.js"></script>​
  <script src="javascripts/masonry.js"></script>
  <script>
  $(function () {
      var $container = $('#container');
      $container.imagesLoaded(function () {
          $container.masonry({
              itemSelector: '.box',
              isFitWidth: true,
              isAnimated: true
          });
      });
  });
  </script> 
       <!-- Google Tag Manager -->
            <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PNLTZQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <script>
                (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
                    new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
                    "//www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,"script","dataLayer","GTM-PNLTZQ");
            </script>
                    <!-- End Google Tag Manager -->
  </body>
</html>

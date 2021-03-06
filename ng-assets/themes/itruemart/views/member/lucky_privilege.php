<script type="text/javascript">
	$(document).ready(function() {
		$('#fancybox').fancybox();
	});
</script>
<div class="content-home sub">
    <div id="wrapper_content">
        <div id="container">
            <!--Start container-->
            <div id="block_checkout">
                <div id="checkout_main">
                    <div id="checkout_center">
                        <!--[S] memberProfileMenus-->
                        <?php $card = isset($card) ? $card : null; ?>
                        <?php echo Theme::partial('memberProfileMenus', array('user'=>$user, 'lastlogin'=>$lastlogin, 'card'=>$card)); ?>
                        <!-- [E] memberProfileMenus -->
                        <div id="checkout_detail">
                            <div class="benefit-inprofile headline" >
								<div class="box-benefit-profile" style="margin-top:15px;">
									<div class="hgreyline">รายการสิทธิ์พิเศษ <span class="t-blackgrey">ที่คุณได้จากแคมเปญ "ช้อปสุดฟิน บินไกลถึง Korea"</span></div>
									<div class="in-benefit-profile">
										<div class="t-m-benefit">คุณได้รับสิทธิ์ <span class="t-green">จำนวน <b><?php echo $privilege['total']?></b> สิทธิ์ </span></div>
										<div class="d-benefit">
											<div class="h-d-benefit">iTrueMart ให้ลุ้น กินเที่ยวช้อป ฟรีที่เกาหลี : </div>
											<div>เพียงซื้อสินค้าในหมวดใดก็ได้ ที่ iTrueMart.com ทุกๆ 5,000 บาท รับ 1 สิทธิ์ ในการลุ้นแพ็กเก็จทัวร์เกาหลี ให้คุณกินฟรี เที่ยวฟรี 
												จำนวนทั้งสิ้น 2 รางวัลๆ ละ 2 ที่นั่ง รวมมูลค่ากว่า 70,000 บาท  ยิ่งช้อปมาก ยิ่งมีสิทธิ์มาก! เริ่มวันนี้ ถึง 30 กันยายน 2557 </div>
											</div>
											<div class="benefit">
												<div class="benefit-01">
													<div class="h-benefit-profile">
														<div class="h-benefit-h-01-profile"><div class="t-h-benefit-h-profile">พิเศษที่ <b>1</b></div></div>
														<p>ลุ้นรับแพ็กเกจทัวร์เกาหลี จำนวน <b>2</b> ที่นั่ง รางวัลละ <b>15,900</b> บาท</p>
														<p class="note">(อ่านรายละเอียดเพิ่มเติม <a href="http://www.itruemart.com/news/detail/itruemart-ให้ลุ้น-กินเที่ยว-ช้อป-ฟรีที่เกาหลี-178.html">คลิกที่นี่</a>)</p>
													</div>
													<div class="detail-benefit-profile">
														<div class="h-detail-benefit">คุณได้รับสิทธิ์ลุ้นรับแพ็คเก็จทัวร์เกาหลี 2 ที่นั่ง : <span class="t-bred">จำนวน <b><?php echo $privilege['total']?></b> สิทธิ์</span></div>
													</div>
													<div class="clear"></div>
												</div>
												<div class="benefit-02">
													<div class="h-benefit-profile">
														<div class="h-benefit-h-02-profile"><div class="t-h-benefit-h-profile">พิเศษที่ <b>2</b></div></div>
														<p>รับคูปองส่วนลด <b>100</b> บาท ทันที สามารถรับส่วนลดสูงสุดได้ <b>600</b> บาท</p>
														<p class="note"></p>
													</div>
													<div class="detail-benefit-profile">
														<div class="h-detail-benefit">สิทธิ์คูปองส่วนลด : <span class="t-bred">คงเหลือ <?php echo $coupon_use_count?> สิทธิ์</span></div>
														<div class="in-areacoupon-profile">
														<ul class="in-row-coupon">
														<?php 
															if (isset($privilege['code']))
															{
																for ($i=0;$i<=5;$i++)
																{
																	if ($i == 0 or $i == 3)
																	{
																		echo '<li>';
																		echo '<ul class="in-col-coupon-profile">';
																	}
																	
																	if (isset($privilege['code'][$i]))
																	{
																		$coupon = $privilege['code'][$i];
																		if ($coupon['used'] == 'Y')
																		{
																			$css_active = ' noactive';
																			$css_active2 = ' used';
																			$text1 = 'ใช้สิทธิ์คูปองส่วนลดแล้ว';
																		}
																		else
																		{
																			$css_active = '';
																			$css_active2 = ' active';
																			$text1 = 'ใช้สิทธิ์คูปองส่วนลดได้ถึง<br />6 ตุลาคม 57 เวลา 23.59 น.';
																		}
																		echo '<li><div class="coupon"><div class="my-coupon"><div class="info-my-coupon'.$css_active.'"></div>';
																		echo '<div class="benefit-code'.$css_active.'"><div>รหัสคูปองส่วนลดของคุณคือ</div>';
																		echo '<div class="t-code'.$css_active.'">'.$coupon['code'].'</div>';
																		echo '</div></div></div>';
																		echo '<div class="coupon-status'.$css_active2.'">'.$text1.'</div>';
																		echo '<div class="clear"></div>';
																		echo '</li>';
																	}
																	else
																	{
																		echo '<li>';
																		echo '<div class="coupon">';
																		echo '<div class="my-coupon"><span class="num-coupon">'.($i+1).'</span></div>';
																		echo '</div>';
																		echo '<div class="coupon-status">ยังซื้อสินค้าไม่ครบตามเงื่อนไข</div>';
																		echo '</li>';
																	}
																	
																	if ($i == 2 or $i == 5)
																	{
																		echo '</ul>';
																		echo '</li>';
																	}
																}
															}
														?>
													  </ul>
													  <div class="clear"></div>
													</div>
													<div class="clear"></div>
												  </div>
												</div>
											  </div>
											</div>
											<div class="check-purchase-profile">ดูรายละเอียดรายการสั่งซื้อ <a href="#inline1" id="fancybox">คลิกที่นี่</a></div>
											<!-- <div class="promote-campaign"><img src="assets/images/banner.png" width="690" height="100" /></div> -->
						<!--- Container --->
							<div class="clear"></div>
						</div>
                </div>                  

            </div>
            <div class="clear"></div>
        </div>

        <!--end checkout_main -->
        <div class="clear"></div>
        <div style="margin-top:10px;"></div>
    </div>


</div>

<div id="profile-dialog" class="reveal-modal">
    <div class="font2 msg-header">ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้</div>
    <div id="popup_content">
        <div id="popup_message">
            <dl class="detail-cart">
                <dt>สินค้า</dt>
            </dl>
            <div class="clearfix"></div>
        </div>
        <div id="popup_panel">
            <input type="button" class="popup_ok btn cart-installment-button cart-installment-button_cancel" value="ยกเลิก">
        </div>
    </div>
</div>

<div id="alert-dialog" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="ตกลง">
    </div>
</div>
<div id="inline1" style="width:820px;display: none;">
	<div class="box-purchase">
    <div class="hgreenline">รายการสั่งซื้อ <span class="t-blackgrey">ภายใต้เงื่อนไขของ Campaign "ช้อปสุดฟิน บินไกลถึง Korea"</span></div>
    <div class="h-title-field">
      <div class="field-day">วันที่สั่งซื้อ</div>
      <div class="field-orderid">เลขที่สั่งซื้อ</div>
      <div class="field-price">ยอดสุทธิ (บาท)</div>
      <div class="clear"></div>
    </div>
    <div class="order-date">รายการสั่งซื้อระหว่างวันที่ 18/08/57 – 30/09/57</div>
    <div class="row-field">
	<?php
		$total_price = 0;
		if (!empty($orders))
		{
			foreach ($orders as $item)
			{
				echo '<div class="d-field">';
				echo '<div class="d-field-day">'.date('d-m-Y', strtotime($item['created_at'])).'</div>';
				echo '<div class="d-field-orderid">'.$item['order_ref'].'('.$item['ref3'].')</div>';
				echo '<div class="d-field-price">'.number_format($item['sub_total'], 2).'</div>';
				echo '<div class="clear"></div>';
				echo '</div>';
				$total_price = $total_price+$item['sub_total'];
			}
		}
	?>
    </div>
    <div class="total-sum">
      <div class="h-field-sum">ยอดรวมสุทธิ (บาท) :</div>
      <div class="d-field-sum"><?php echo number_format($total_price, 2)?></div>
      <div class="clear"></div>
    </div>
  </div>
</div>

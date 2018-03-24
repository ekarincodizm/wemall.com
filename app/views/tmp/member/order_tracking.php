<div class="content-home sub">
	<div id="wrapper_content">
		<div id="container">
            <!--Start container-->
            <div id="block_checkout">
                <div id="checkout_main">
					<!--start checkout_main-->
					<div id="checkout_center">
					
						<div id="checkout_menu">
							<!--start checkout_menu-->
							<div class="bigheadline"><b>ข้อมูลส่วนตัว</b></div>
							<div class="bottom_line"></div>
							<div class="g_info"><div class="headline"></div></div>
							<div class="welcome"><b>ยินดีต้อนรับ คุณ</b><br>
								<?php $user = ACL::getUser(); echo $user['display_name']; ?>
							</div>
							<div id="cardtype">
								<?php if (isset($card)) : ?>
								<img src="<?php echo Theme::asset()->url('images/true'.$card.'card.jpg'); ?>" class="middle img_card_type">
								Red Card Previlage
								<?php endif; ?>
							</div>
							<div class="topic headline">เข้าใช้งานล่าสุด : </div>
							<div><?php // echo $dataUser['login_at']; ?></div>

							<div class="liststep">
								<!--start liststep-->
								<div class="bottom_line"></div>
								<div id="ic_checkout_here">
									<div class="headline_light">
										<a href="<?php echo URL::to('member/profile'); ?>" title="ข้อมูลส่วนตัว">ข้อมูลส่วนตัว</a>
									</div>
								</div>

								<div class="bottom_line"></div>
								<div id="ic_checkout_here">
									<div class="headline_light">
										<a href="<?php echo URL::to('checkout'); ?>" title="Checkotu Order">สินค้ารอการชำระเงิน</a>
									</div>
								</div>
								
								<div class="bottom_line"></div>
								<div id="ic_ordertrack_current">
									<div class="headline">
										<a href="<?php echo URL::to('member/orders'); ?>" title="ตรวจสอบสถานะการจัดส่ง">ตรวจสอบสถานะการชำระเงิน และการจัดส่ง</a>
									</div>
								</div>
								
								<div class="bottom_line"></div>
							</div>
							<!--end checkout_menu-->

						</div>

						<div id="checkout_detail">
							<div class="headline_maincheckout" style="width:320px;"><b>ตรวจสอบสถานะการจัดส่ง</b></div>
							<div class="clear"></div>
							<div class="line_mainbar_checkout"></div>
							<ul id="profile-hd-list" class="hd-brd-btm order-tracking">
								<li><a href="<?php echo URL::to('member/orders'); ?>">ช่องทางชำระเงินทั่วไป</a></li>
							</ul>
							
							<?php if(!empty($order)): ?>
							<div id="OT_topic">
								<div id="OT_date" class="headline">วันที่สั่งซื้อ</div>
								<div id="OT_id" class="headline">เลขที่สั่งซื้อ</div>
								<div id="OT_total" class="headline">total(<strong>₱</strong>)</div>
								<div id="OT_status" class="headline">สถานะการชำระเงิน</div>
								<div id="OT_statusdeli" class="headline">สถานะการจัดส่ง</div>
								<div id="OT_viewdetail" class="headline">รายละเอียด</div>
								<div class="clear"></div>
							</div>
							
							<?php foreach($order as $data): ?>
							<div id="total_cart">
								<!--Start total_cart-->
								<div id="OT_detail">
									<!--Start OT_detail-->
									<div id="OT_date" class="red "><?php echo date('d-m-Y',strtotime($data['created_at'])); ?></div>
									<div id="OT_id" class="black "><?php echo $data['order_ref'].'('.$data['id'].')'; ?></div>
									<div id="OT_total" class=" "><?php echo number_format($data['sub_total'],2,'.',','); ?></div>
									<div id="OT_status" class="black  ">
										<span style="color:#CCCCCC;">
											<?php if(!empty($data['payment_status'])) : echo $data['payment_status']; else: echo '-' ; endif; ?>
										</span>							
									</div>
									<div id="OT_statusdeli" class="black  ">																
										<?php if(!empty($data['shipments'][0]['shipment_status'])) : echo $data['shipments'][0]['shipment_status']; else: echo '-' ; endif; ?>
									</div>
									<div id="OT_viewdetail">
										<div id="button_down">										
											<a href="#" class="toggle_item"><img src="http://www.itruemart.com/assets/itruemart_new/2012/images/button_right.png" alt="" width="20" height="19"></a>
										</div>
									</div>
									<div class="clear"></div>
									<!--End OT_detail-->
								</div>   
								<!--End total_cart-->
							</div>
							<div class="slide_list">			
								<div id="block_conclusion">
									<!--start block_conclusion-->
									<div id="order_detail">
										<!--start order_detail-->
										<div class="OD_topic">
											<div>
												<span class="mediumheadline"><strong>วันที่สั่งซื้อ</strong></span>
											</div>
											<div class="start_detail"><strong>รูปแบบการจัดส่ง:</strong></div>
										</div>
										<div class="OD_detail">
											<div>
												<span class="mediumheadline"><strong><?php if(!empty( $data['customer_info_modified_at'] ) ){ echo $data['customer_info_modified_at']; } ?></strong></span>
												<!--(Lastest)-->
											</div>
											<div class="start_detail graylight"></div>
											<div class="black">ที่อยู่:</div>
											<div class="graylight">
												<?php echo $data['customer_name']; ?><br>
												<?php echo htmlentities($data['customer_address']); ?>
												<?php echo $data['customer_province']; ?>				
												<?php echo $data['customer_postcode']; ?>				
											</div>
											<div class="black">เบอร์ติดต่อ:</div>
											<div class="graylight"><?php echo $data['customer_tel']; ?></div>
										</div>
										<div class="clear"></div>
										<!--end order_detail-->
									</div>
									<div id="order_boxcart">
										<!--start order_boxcart-->
										<div id="no_id">
											<div class="headline left">No:</div>
											<div class="mediumheadline right"><strong><?php echo $data['id']; ?></strong></div>
											<div class="clear"></div>
										</div>
										<div id="conclusion">
											<div style="line-height:0em;">
												<img src="http://www.itruemart.com/assets/itruemart_new/2012/images/bg_conclusion_box_top.png" width="204" height="7" alt="">
											</div>
											<div id="conclution_center_gray">
												<div class="cl_txt">รวมราคาสินค้า:</div>
												<div class="cl_num"><strong>₱ </strong><?php echo number_format($data['sub_total'],2,'.',','); ?></div><div class="clear"></div>
												<div class="cl_txt">ค่าจัดส่ง:</div>
												<div class="cl_num"><strong>₱ </strong><?php echo number_format($data['total_shipping_fee'],2,'.',','); ?></div><div class="clear"></div>
												<div class="clear"></div>
											</div>
											<div id="conclution_center_red">
												<div class="netprice">รวมยอดชำระ<br>
													<h2>
														<strong>₱ <?php echo number_format($data['total_price'],2,'.',','); ?></strong>
													</h2>
												</div>
											</div>
											<div style="line-height:0em;">
												<img src="http://www.itruemart.com/assets/itruemart_new/2012/images/bg_conclusion_box_bottom.png" width="204" height="7" alt="">
											</div>
											<!--end conclusion-->
										</div>
										<div class="clear"></div>
										<div>
											<div id="more-detail">
												<a href="<?php echo URL::to('checkout/thank-you').'?order_id='.$data['id']; ?>" target="_blank" title="More detail">More detail</a>
											</div>
											<div id="print">
												<a href="#" onclick="window.print()">Print</a>
											</div>
										</div>
										<div class="clear"></div>
										<!--end order_boxcart-->
									</div>
									<div class="clear"></div>
									<!--End block_conclusion-->
								</div>
								
							<?php if(!empty($data['shipments'][0]['shipment_items'])): ?>
								<div id="block_productlist">
									<div id="prolist_box_top">
										<div class="prolist_topic pronum">No.</div>
										<div class="prolist_topic proitem">รายการสินค้า</div>
										<div class="prolist_topic proimg">&nbsp;</div>
										<div class="prolist_topic proprice">ราคาต่อชิ้น (<strong>₱</strong>)</div>
										<div class="prolist_topic proqty">จำนวนชิ้น</div>
										<div class="prolist_topic prototal">ราคารวม (<strong>₱</strong>)</div>
										<div class="prolist_topic prorate"></div>
										<div class="clear"></div>
									</div>
									<div id="prolist_box_headline">
										<div class="prolist_box_headline_detail">
											<p>
											</p>
										</div>
									</div>
									
									<?php foreach($data['shipments'][0]['shipment_items'] as $item): ?>
										<div>
											<div class="prolist pronum"><?php echo $item['id']; ?></div>
											<div class="prolist proitem"><?php echo $item['name']; ?></div>
											<div class="proimg"><img src="http://www.itruemart.com/assets/itruemart_new/images/no_image.png" alt="" width="105" height="105"></div>
											<div class="prolist proprice"><?php echo $item['price']; ?></div>
											<div class="prolist proqty"><?php echo $item['quantity']; ?></div>
											<div class="prolist prototal"><?php echo $item['total_price']; ?></div>
											<div class="prolist prorate"></div>
											<div class="clear"></div>
										</div>
									<?php endforeach; ?>
									
									<div class="clear"></div>
								</div>
							<?php endif; ?>
							
								<div style="margin-top:10px;"></div>					
							</div>
							<?php endforeach; ?>
							
							<?php 
							#$order['total_page'] = 2;
							if(!empty($order['total_page'])): if($order['total_page'] > 1) : ?>
							
							<div id="block_button">
								<div id="list_number">
									<?php if($page != 1): ?>
									<p class="left" id="button_back"> 
										<a href="<?php echo URL::to('member/orders').'?page='.($page-1); ?>">Prev</a>
									</p>
									<?php endif; ?>
									<?php for($i=1 ; $i<=$order['total_page'] ; $i++){ ?>
											<?php if($i != $page) : ?>
											<a href="<?php echo URL::to('member/orders').'?page='.$i; ?>">
											<?php endif; ?>
												<span <?php if($i == $page): echo "class='current'"; endif; ?> ><?php echo $i; ?></span>
											<?php if($i != $page) : ?>
											</a>
											<?php endif; ?>
									<?php } ?>
									<?php if($page != $order['total_page']): ?>
									<p class="right" title="next" id="button_next">
										<a href="<?php echo URL::to('member/orders').'?page='.($page+1); ?>">Next</a>
									</p>
									<?php endif; ?>
								</div>				
								<div class="clear"></div>
							</div>
							<?php endif; endif; ?>
							
							<?php else: ?>
								<div id="msg-box" style="margin:30px auto;">
									<h2>There is no Order</h2>
									<p><a href="<?php echo URL::to(''); ?>" title="shopping" class="link_red12">backto_shopping</a></p>
								</div>							
							<?php endif; ?>
								
						</div>                  
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
				<!--end checkout_main -->
			<div class="clear"></div>
			<div style="margin-top:10px;"></div>
		</div>
		<div class="container_line"></div>
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
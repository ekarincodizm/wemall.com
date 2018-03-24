<div class="main_checkout" style="background-color:#f2f2f2;">
	<!-----------  alltotal ------------>
    <div class="alltotal">
		<div class="result">
			<div>
				<img src="<?php echo Theme::asset()->url('images/done.png'); ?>" width="21"/>
				<span class="complete">
					<h8>
						<?php echo trans('checkout.thankyou.Your transaction is '); ?>
						<span class="redfont"><?php echo trans('checkout.thankyou.completed'); ?></span>
					</h8>
				</span>
			</div>
			<h9><?php echo trans('checkout.thankyou.Thank you');?> iTrueMart.com</h9>
		</div>
		<div class="payment">
			<h3><?php echo trans('checkout.thankyou.Your payment is '); ?></h3>
		</div>
		
		<?php if(array_get($data,'data.payment_method_code') === 'atm'): ?>
		<div class="select_payment">
			<div class="paymentico"><img src="<?php echo Theme::asset()->url('images/atm.jpg'); ?>" width="72" /></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (Bank ATM) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>			   
		</div>
		<?php elseif(array_get($data,'data.payment_method_code') === 'cod'): ?>    	
		<div class="select_payment">
			<div class="paymentico"><i>COD</i></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (Cash on delivery) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>			   
		</div>
		<?php elseif(array_get($data,'data.payment_method_code') === 'banktrans'): ?>
		<div class="select_payment">
			<div class="paymentico"><img src="<?php echo Theme::asset()->url('images/counter.jpg'); ?>" width="93" /></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (Payment Counter) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>			   
		</div>
		<?php elseif(array_get($data,'data.payment_method_code') === 'cs'): ?>
		<div class="select_payment">
			<div class="paymentico"><img src="<?php echo Theme::asset()->url('images/counterservice.jpg'); ?>" width="55px" /></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (Counter Service) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>			   
		</div>		
		<?php elseif(array_get($data,'data.payment_method_code') === 'ibank'): ?>
		<div class="select_payment">
			<div class="paymentico"><img src="<?php echo Theme::asset()->url('images/icon-ibanking.jpg'); ?> " /></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (Internet Banking) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>		
		<?php elseif(array_get($data,'data.payment_method_code') === 'ccinstm'): ?>
		<div class="select_payment">
			<div class="paymentico"><img src="<?php echo Theme::asset()->url('images/icon-kbank.png'); ?>" /></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (Instalment) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>		
		<?php elseif(array_get($data,'data.payment_method_code') === 'ccw'): ?>
		<div class="select_payment">
			<div class="paymentico"><img src="<?php echo Theme::asset()->url('images/icon-credit-card.png'); ?>" /></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (Credit Card) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>			
		<?php elseif(array_get($data,'data.payment_method_code') === 'ew'): ?>
		<div class="select_payment">
			<div class="paymentico"><img src="<?php echo Theme::asset()->url('images/icon-ewallet.jpg'); ?>" width="55px" /></div>
			<div  class="paymentlabel">
				<div class="plabel"><?php echo array_get($data, 'data.payment_method_name'); ?></div>
				<div class="greyfont_s"> (E-Wallet) </div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>					
		<?php endif; ?>
		
		<!----------- Price ------------>
		<div style="position:relative;">
			<div style="position:absolute; right:25%; top:-5px;"><img src="<?php echo Theme::asset()->url('images/arrowup.png'); ?>" width="18" height="6" /></div>
			<div class="priceall">
				<div class="price_left"><h6><?php echo trans('checkout.thankyou.Total Amount'); ?> </h6></div>
				<div class="price_right"><h1><?php echo price_format(array_get($data, 'data.sub_total'),'PHP'); ?></h1></div>
				<div class="clear"></div>
			</div>
		</div> 
      	<!-----------  End Price ------------>  
		
	</div> 
	<!------------ End alltotal------------>
	
	<div class="boxspace">
		<div class="whitebox">
			<div class="detail_confirm" style="padding:15px 0px 15px 0px;">
				<h8><?php echo trans('checkout.thankyou.order-detail');?></h8>
				<div class="detail_order">
					<ul class="detail_order_inner">
						<li>
							<div class="titlelist">No. Oder : </div>
							<div class="valuelist"><?php echo array_get($data,'data.payment_order_id'); ?>(<?php echo array_get($data,'data.order_id'); ?>)</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="titlelist"><?php echo trans('checkout.thankyou.date'); ?> :</div>
							<div class="valuelist">
								<?php echo date("d",strtotime(array_get($data, 'data.ordered_date.date'))).' '.
								trans('checkout.thankyou.'.date("M",strtotime(array_get($data, 'data.ordered_date.date')))).' '.
								(date("Y",strtotime(array_get($data, 'data.ordered_date.date')))+543); ?>
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="titlelist"><?php echo trans('checkout.thankyou.name'); ?> : </div>
							<div class="valuelist">คุณ <?php echo array_get($data,'data.customer_name'); ?></div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="titlelist redfont">Ref No.1 : </div>
							<div class="valuelist"><?php echo array_get($data,'data.ref1'); ?></div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="titlelist redfont">Ref No.2 : </div>
							<div class="valuelist"><?php echo array_get($data,'data.ref2'); ?></div>
							<div class="clear"></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
   </div>
   
	<div class="boxspace">
		<div class="whitebox">
			<div class="detail_confirm" style="padding:15px 0px 15px 0px;">
				<h8><?php echo trans('checkout.thankyou.Shipping address');?> :</h8>
				<div>
					<div class="detail"><?php echo array_get($data,'data.customer_name');?></div>
					<div class="detail"><?php echo array_get($data,'data.customer_address');?> <?php echo array_get($data,'data.customer_province');?> <?php echo array_get($data,'data.customer_postcode');?></div>
					<div class="detail"><?php echo trans('checkout.thankyou.tel'); ?>. <?php echo array_get($data,'data.customer_tel');?></div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- ATM -->
	<?php if(array_get($data,'data.payment_method_code') === 'atm'): ?>  
	<div class="boxspace"> 
		<div class="whitebox">
			<div class="detail_confirm">
				<h8>หมายเหตุสำหรับท่านที่ชำระเงินทาง ATM</h8>
				<div>
					<div class="detail_s">
						<p>ลูกค้าต้องชำระเงินภายในวันที่ <?php echo date("d/m/Y",strtotime(array_get($data, 'data.order_expired.date'))); ?> เวลา <?php echo date("H:i:s",strtotime(array_get($data, 'data.order_expired.date'))); ?> น. มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ</p>
						<ul class="pm-rm-notice">
							<li>
								การชำระเงินผ่านตู้ ATM ในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท 
								<span style="color: red">*</span>
							</li>
							<li>
								การชำระเงินผ่านตู้ ATM ต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท 
								<span style="color: red">*</span></li>
							<li><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</li>
						</ul>
					</div>
				</div>
			</div>
		</div> 
	</div>
	<?php elseif(array_get($data,'data.payment_method_code') === 'cod'): ?>
	<div class="boxspace"> 
		<div class="whitebox">
			<div class="detail_confirm">
				<h8>หมายเหตุสำหรับท่านที่ชำระเงินทาง COD</h8>
				<div>
					<div class="detail_s">
						<ul class="pm-rm-notice">
							<li>พนักงานจัดส่งสินค้า จะทำการโทรนัดหมายวันเวลา พร้อมแจ้งยอดชำระสินค้าให้ท่านทราบ ก่อนทำการจัดส่งสินค้า</li>
							<li>กรุณาเตรียมเงินสดให้พอดีกับค่าสินค้า และชำระกับพนักงานจัดส่งสินค้า เมื่อท่านได้รับสินค้าเรียบร้อยแล้ว</li>
						</ul>
						<p><span class="text-red-1">หมายเหตุ</span> ระยะเวลาในการจัดส่งสินค้าจะใช้เวลาจัดส่ง 1-3 วัน</p>
					</div>
				</div>
			</div>
		</div> 
	</div>	
	<?php elseif(array_get($data,'data.payment_method_code') === 'banktrans'): ?>
	<div class="boxspace"> 
		<div class="whitebox">
			<div class="detail_confirm">
				<h8>หมายเหตุสำหรับท่านที่ชำระเงินทางเคาร์เตอร์ธนาคาร (Payment Counter)</h8>
				<div >
					<div class="detail_s">
						<p>
							ลูกค้าต้องชำระเงินภายในวันที่ <?php echo date("d/m/Y",strtotime(array_get($data, 'data.order_expired.date'))); ?> เวลา <?php echo date("H:i:s",strtotime(array_get($data, 'data.order_expired.date'))); ?>น. มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ
						</p>
						<ul class="pm-rm-notice">
							<li>การโอนเงินในกรุงเทพฯและปริมณทล จะเสียค่าธรรมเนียมประมาณ 20-25 บาท<span style="color: red">*</span></li>
							<li>การโอนเงินต่างจังหวัด จะเสียค่าธรรมเนีมประมาณ 35-40 บาท <span style="color: red">
									*</span></li>
							<li><span style="color: red">*</span>อัตราค่าธรรมเนียมขึ้นอยู่กับธนาคารที่รับชำระ</li>
						</ul>
					</div>
				</div>
			</div>
		</div> 
	</div>	
	<?php elseif(array_get($data,'data.payment_method_code') === 'cs'): ?>
	<div class="boxspace"> 
		<div class="whitebox">
			<div class="detail_confirm">
				<h8>หมายเหตุสำหรับท่านที่ชำระเงินเคาร์เตอร์เซอร์วิส (Counter Service)</h8>
				<div >
					<div class="detail_s">
						<p>ลูกค้าต้องชำระเงินภายในวันที่ <?php echo date("d/m/Y",strtotime(array_get($data, 'data.order_expired.date'))); ?> เวลา <?php echo date("H:i:s",strtotime(array_get($data, 'data.order_expired.date'))); ?>น. มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ</p>
						<ul class="pm-rm-notice">
							<li>การชำระสินค้าผ่าน เคาน์เตอร์เซอร์วิส ใบชำระเงินมีอายุ 4 วัน นับจากเวลาที่ทำรายการและควรชำระภายในวัน เวลาดังกล่าว ไม่เช่นนั้น รายการของท่านจะโดนยกเลิกโดยอัตโนมัติ<span style="color: red">*</span></li>
							<li>
								<span style="color: red">*</span>การชำระเงินผ่านเคาน์เตอร์เซอร์วิส มีค่าธรรมเนียมการชำระเงิน15 บาท
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div> 
	</div>	
	<?php elseif(array_get($data,'data.payment_method_code') === 'ibank'): ?>
	<div class="boxspace"> 
		<div class="whitebox">
			<div class="detail_confirm">
				<h8>หมายเหตุสำหรับท่านที่ชำระเงินทาง iBanking</h8>
				<div >
					<div class="detail_s">
						<p>
							ลูกค้าต้องชำระเงินภายในวันที่ <?php echo date("d/m/Y",strtotime(array_get($data, 'data.order_expired.date'))); ?> เวลา <?php echo date("H:i:s",strtotime(array_get($data, 'data.order_expired.date'))); ?> น. มิฉะนั้นลูกค้าอาจไม่ได้รับสินค้าตามการสั่งซื้อ
						</p>
						<ul class="pm-rm-notice">
							<li>สามารถตรวจสอบวิธีการชำระผ่าน iBanking service ของธนาคารกสิกรไทย,ธนาคารไทยพาณิชย์
								และธนาคารกรุงเทพ ได้จากหน้ายืนยันการสั่งซื้อและชำระเงิน</li>
						</ul>
					</div>
				</div>
			</div>
		</div> 
	</div>	
	<?php elseif(array_get($data,'data.payment_method_code') === 'ccinstm'):?>
	<div class="boxspace"> 
		<div class="whitebox">
			<div class="detail_confirm">
				<h8>หมายเหตุสำหรับท่านที่ชำระเงินทางผ่อนชำระ</h8>
				<div >
					<div class="detail_s">
						<ul class="pm-rm-notice">
							<li>การผ่อนชำระ จะได้กับบัตรเครดิตที่เป็นธนาคารกสิกรไทยเท่านั้น</li>
							<li>ค่าธรรมเนียม (Fee) และดอกเบี้ย (interest) จากการผ่อนชำระสินค้าทาง iTrueMart.com จะเป็นผู้รับผิดชอบค่าใช้จ่ายในส่วนนี้ให้กับท่าน</li>
						</ul>
					</div>
				</div>
			</div>
		</div> 
	</div>	
	<?php endif; ?>
   
	<?php if(array_get($data,'data.payment_method_code') === 'atm') : ?>   
	
	<div class="space"> 
		<div class="menu-bank">
			<ul>
				<li class="active-right">
					<div><a href="#kbank">ธนาคารกสิกร</a></div>
				</li>
				<li>
					<div><a href="#scb">ธนาคารไทยพาณิชย์</a></div>
				</li>
				<li>
					<div><a href="#bangkokbank">ธนาคารกรุงเทพ</a></div>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="howto_atm active" id="kbank">
			<div class="logo_bank"><img src="<?php echo Theme::asset()->url('images/kbank.jpg'); ?>" width="154" /></div>
			<div class="clear"></div>
			<ul class="howto_list">
				<li>สอดบัตร ATM ของธนาคารกสิกรไทยที่ตู้ ATM ธนาคารกสิกรไทย</li>
				<li>ใส่รหัสบัตร ATM 4 หลัก</li>
				<li>กดปุ่ม "ซื้อและชำระเงิน"</li>
				<li>กดปุ่ม "อื่นๆ/ระบุรหัสบริษัท"</li>
				<li>กดปุ่มเลือกชำระเงินจาก บัญชีออมทรัพย์ หรือ กระแสรายวัน</li>
				<li>ใส่รหัสบริษัท 5 หลัก หมายเลข "35002" แล้วกดปุ่ม "รหัสบริษัทถูกต้อง"</li>
				<li>กด หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลัก ตามที่ปรากฏในใบสรุปการสั่งซื่อ แล้วกดปุ่ม "หมายเลขถูกต้อง"</li>
				<li>กด หมายเลขอ้างอิง 2 (Ref No.2 ) จำนวน 12 หลักตามที่ปรากฏในใบสรุปการสั่งซื่อ แล้วกดปุ่ม "หมายเลขถูกต้อง"</li>
			</ul>
		</div>
		<div class="howto_atm" id="scb">
			<div class="logo_bank"><img src="<?php echo Theme::asset()->url('images/scb.jpg'); ?>" width="154" /></div>
			<div class="clear"></div>
			<ul class="howto_list">
				<li>สอดบัตร ATM ของธนาคารไทยพาณิชย์ที่ตู้ ATM ธนาคารไทยพาณิชย์</li>
				<li>ใส่รหัสบัตร ATM 4 หลัก</li>
				<li>กดปุ่ม " อื่นๆ "</li>
				<li>เลือก "ชำระค่าสินค้า/บริการ"</li>
				<li>เลือก "ชำระเงินเข้าบริษัทอื่นๆ"</li>
				<li>เลือกชำระเงินจากบัญชีออมทรัพย์</li>
				<li>ใส่รหัสบริษัท (Comp Code) หมายเลข "0546" แล้วกดปุ่ม "ถูกต้อง"</li>
				<li>กดจำนวนเงินที่ต้องการชำระ</li>
				<li>กด หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลักตามที่ปรากฏในใบสรุปการสั่งซื้อ</li>
				<li>กด หมายเลขอ้างอิง 2 (Reference No.) จำนวน 12 หลักตามที่ปรากฏในใบสรุปการสั่งซื้อ</li>
				<li>ตรวจสอบความถูกต้องว่าเป็นบัญชีเป็นชื่อ บริษัท TRUE MONEY แล้วเลือก "ยืนยัน" เพื่อชำระค่า</li>
			</ul>
		</div>
		<div class="howto_atm" id="bangkokbank">
			<div class="logo_bank"><img src="<?php echo Theme::asset()->url('images/bangkokbank.jpg'); ?>" width="154" /></div>
			<div class="clear"></div>
			<ul class="howto_list" id="bangkokbank">
				<li>สอดบัตร ATM ของธนาคารกรุงเทพที่ตู้ ATM ธนาคารธนาคารกรุงเทพ พร้อมใส่รหัสบัตร 4 หลัก</li>
				<li>เลือก อื่นๆ &gt; ชำระเงินด้วย Comp Code &gt; บัญชีสะสมทรัพย์</li>
				<li>ใส่รหัสบริษัท (Comp Code) หมายเลข "60000" แล้วกดปุ่มถูกต้อง</li>
				<li>ใส่หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลัก และ หมายเลขอ้างอิง 2 (Reference
					No.) จำนวน 12 หลักตามที่ปรากฎในใบสรุปการสั่งซื้อ</li>
				<li>กดจำนวนเงินที่ต้องการชำระ</li>
				<li>ตรวจสอบความถูกต้องว่าเป็นบัญชีชื่อบริษัท TRUE MONEY แล้วกด "ยืนยัน" เพื่อชำระค่าสินค้า</li>
				<li>รอรับสลิปไว้เป็นหลักฐาน</li>
			</ul>
		</div>
	</div>
	<?php elseif(array_get($data,'data.payment_method_code') === 'banktrans'): ?>
	<div class="space"> 
		<div class="menu-bank payment_counter">
			<ul>
				<li class="active-right"><div><a href="#kbank">การชำระผ่านเคาร์เตอร์ธนาคาร</a></div></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="howto_atm active">
			<div class="logo_bank"><img src="<?php echo Theme::asset()->url('images/counter.jpg'); ?>" width="154" /></div>
			<div class="clear"></div>
			<p>
				<strong>ขั้นตอนการจ่ายเงินผ่านเคาร์เตอร์ของธนาคาร</strong>
			</p>
			<p class="text-indent-30">
				ท่านสามารถทำการชำระเงินค่าสินค้าด้วยการดาวน์โหลด และพิมพ์แบบฟอร์มตามที่ปรากฏในหน้าสรุปรายการสั่งซื้อ
				แล้วนำไปชำระเงินผ่าน <strong>ธนาคารไทยพาณิชย์, ธนาคารกสิกรไทย, ธนาคารกรุงเทพ</strong>
				(ทุกสาขาทั่วประเทศ ธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงินตรงจากท่าน)</p>
			<p class="hidden-xs">
				ดาวน์โหลด และพิมพ์แบบฟอร์มสำหรับชำระเงิน <a href="<?php echo URL::to('checkout/print'); ?>?order_id=<?php echo array_get($data,'data.order_id'); ?>">&gt;&gt; คลิกที่นี่ &lt;&lt;</a></p>
		</div>
	</div>
	<?php elseif(array_get($data,'data.payment_method_code') === 'cs'): ?>
	<div class="space"> 
		<div class="menu-bank payment_counter">
			<ul>
				<li class="active-right"><div><a href="#">การชำระผ่านเคาร์เตอร์เซอร์วิส</a></div></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="howto_atm active">
			<div id="counter-service">
				<div class="row">
					<div style="text-align: center">
						<img src="<?php echo Theme::asset()->url('images/counterservice.jpg'); ?>"/>
					</div>
					<div class="col-sm-9">
						<p>
							<strong>ท่านสามารถชำระเงินผ่านทางเคาร์เตอร์เซอร์วิส ได้อย่างสะดวกตามขั้นตอนต่อไปนี้</strong>
						</p>
						<ol>
							<li>พิมพ์หน้าชำระเงินที่มีรายการสรุปสินค้า ราคา และแถบบาร์โค้ด</li>
							<li>นำหน้าชำระเงินเสร์จสมบูร์ที่มีแถบบาร์โค้ดทางด้านล่าง ไปชำระเงินได้ที่เคาร์เตอร์เซอร์วิสทุกสาขา</li>
						</ol>
						<p>
							<strong>ท่านสามารถตรวจสอบสถานะสินค้าได้ที่</strong>
						</p>
						<p class="text-indent-30">
							<a href="<?php echo URL::route('member.profile'); ?>" target="_blank"><?php echo URL::route('member.profile'); ?></a>
						</p>
					</div>
				</div>
				<div class="row">
					<div style="text-align: center">
						<img src="<?php echo Theme::asset()->url('images/logo_7eleven.jpg'); ?>"> 
						<img src="<?php echo Theme::asset()->url('images/logo_counter_service.jpg'); ?>"/>
							<p>ชำระเงินที่ Counter Service ในร้าน 7-eleven ทุกสาขาทั่วประเทศ (ไม่ต้องแจ้งผลการชำระเงิน)</p>
						<?php if ( array_get($data,'data.barcode') != null) : ?>
							<img src="<?php echo array_get($data,'data.barcode');?>">
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php elseif(array_get($data,'data.payment_method_code') === 'ibank'): ?>
	<div class="space"> 
		<div class="menu-bank">
			<ul>
				<li class="active-right"><div><a href="#kbank">ธนาคารกสิกร</a></div></li>
				<li><div><a href="#scb">ธนาคารไทยพาณิชย์</a></div></li>
				<li><div><a href="#bangkokbank">ธนาคารกรุงเทพ</a></div></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="howto_atm active" id="kbank">
			<div class="logo_bank"><img src="<?php echo Theme::asset()->url('images/kbank.jpg'); ?>" width="154" /></div>
			<div class="clear"></div>
			<ul class="howto_list">
				<li>เข้าไปที่เว็บไซต์ www.kasikornbank.com</li>
				<li>เลือกบริการออนไลน์ที่ต้องการเป็น "K Cyber-Banking"</li>
				<li>Login เข้าสู่ระบบโดยใช้ username และ password ที่ได้รับจากทางธนาคาร</li>
				<li>เลือก "ชำระค่าสินค้าและบริการ" แล้วเลือก "แบบฟอร์มการชำระเงิน"</li>
				<li>กดปุ่ม "สร้างแบบฟอร์มการชำระเงิน"</li>
				<li>ในขั้นตอนที่ 1 เลือกประเภทบริการเป็น "อินเทอร์เน็ต"</li>
				<li>ในช่อง "บริษัท " เลือกชื่อบริษัท เป็น "ทีเพย์ - weloveshopping"</li>
				<li>เลือก "จากบัญชี เป็นเลขที่บัญชีที่สมัครกับทางธนาคาร</li>
				<li>ใส่ "เลขที่อ้างอิง1 (Ref No.1)" และ"เลขที่อ้างอิง 2 (Ref No.2)" ตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อ
					และใส่ ยอดเงินค่าสินค้าลงใน ช่อง "จำนวนเงิน(บาท)"</li>
				<li>กดปุ่ม "ชำระเงิน" (ด้านล่าง)</li>
				<li>ตรวจสอบรายการที่ชำระอีกครั้ง พร้อมกด "ยืนยัน"</li>
				<li>กดปุ่ม "พิมพ์ เพื่อพิมพ์ฐานการชำระเงิน เก็บเอาไว้เป็นหลักฐาน</li>
			</ul>
		</div>
		<div class="howto_atm" id="scb">
			<div class="logo_bank"><img src="<?php echo Theme::asset()->url('images/scb.jpg'); ?>" width="154" /></div>
			<div class="clear"></div>
			<ul class="howto_list">
				<li>เข้าไปที่เว็บไซต์ www.scbeasy.com</li>
				<li>Login เข้าสู่ระบบโดยใช้ Username และ Password ที่ได้รับจากทางธนาคาร</li>
				<li>กดปุ่ม "My Page" เพื่อทำรายการต่อ</li>
				<li>เลือก "ชำระเงิน และ e-Bill"</li>
				<li>กดปุ่ม "สร้างแบบฟอร์มการชำระเงิน"</li>
				<li>เลือก บัญชีผู้ให้บริการ (Biller) เป็น "บริษัททรูมันนี่จำกัด :หมายเลข comp code 0546"
					<p>
						กรณีที่ไม่มีบัญชี "บริษัทรูมันนี่จำกัด :หมายเลข comp code 0546" อยู่ในรายชื่อ</p>
					<ol>
						<li>เลือก "เพิ่มรายชื่อผู้รับชำระ" แล้วกดปุ่ม "Add from Bill Group"</li>
						<li>เลือก Billing Group เป็น "ค่าบริการอินเตอร์เน็ต" แล้วกด "Search"</li>
						<li>กดปุ่มเครื่องหมาย "+" ตรง บริษัททรูมันนี่จำกัด Comp Code 0546</li>
						<li>กดปุ่ม "Add" เพื่อยืนยันการเพิ่มชื่อผู้ให้บริการ</li>
					</ol>
				</li>
				<li>กรอกข้อมูลลูกค้า "ชื่อ-นามสกุล" และใส่ "เลขที่อ้างอิง 1 (Ref No.1)" และ "เลขที่อ้างอิง
					2 (Ref No.2)" ตามที่ปรากฏในหน้าสรุปรายการสั่งซื้อ และใส่ยอดเงินค่่าสินค้าลงในช่อง
					"จำนวนเงิน"</li>
				<li>กดปุ่ม "Next"</li>
				<li>ตรวจสอบรายการที่ชำระอีกครั้ง พร้อมกด "Confirm"</li>
				<li>กดปุ่ม "พิมพ์" เพื่อพิมพ์หลักฐานการชำระเงิน เก็บเอาไว้เป็นหลักฐาน</li>
				<li>ตรวจสอบความถูกต้องว่าเป็นบัญชีเป็นชื่อ บริษัท TRUE MONEY แล้วเลือก "ยืนยัน" เพื่อชำระค่า</li>
			</ul>
		</div>
		<div class="howto_atm" id="bangkokbank">
			<div class="logo_bank"><img src="<?php echo Theme::asset()->url('images/bangkokbank.jpg'); ?>" width="154" /></div>
			<div class="clear"></div>
			<ul class="howto_list" id="bangkokbank">
				<li>เข้าไปที่เว็บไซต์ www.bangkokbank.com เลือกบริการ Bualuang iBaning แล้วกดเข้าสู่ระบบ</li>
				<li>Login เข้าสู่ระบบโดยใช้ Username และ Password ที่ได้รับจากทางธนาคาร</li>
				<li>เลือก Payments &gt; new bill payment</li>
				<li>ในช่อง Pay to เลือก TMNWLS กรณีที่ยังไม่มี TMNWLS อยู่ในรายชื่อ
					<ul>
						<li>เลือก เพิ่มรายชื่อผู้รับชำระ &gt; Add Payee &gt; type of business เป็น "Goods/Services"</li>
						<li>เลือก TMNWLS * True Money Company Limited</li>
						<li>ตั้งชื่อ Payee Nickname และกรอกเบอร์โทรศัพท์มือถือในช่อง Customer No. (Ref 1) แล้วกด
							OK</li>
					</ul>
				</li>
				<li>เลือกบัญชีธนาคารของท่านที่ต้องการจะชำระเงินในช่อง From</li>
				<li>ใส่เลขที่อ้างอิง 1 (Ref No.1) และเลขที่อ้างอิง 2 (Ref No.2) ตามที่ปรากฏในหน้าสรุปรายการสั่งซื้อ
					และใส่ยอดเงินค่าสินค้าลงในช่องจำนวนเงิน กดปุ่ม Next</li>
				<li>ตรวจสอบรายการที่ต้องการชำระอีกครั้ง พร้อมกด Confirm กดปุ่ม "พิมพ์" เพื่อพิมพ์หลักฐานการชำระงิน
					เก็บเอาไว้เป็นหลักฐาน</li>
			</ul>
		</div>
	</div>  
	<?php endif; ?>
	
	<div style=" padding:20px 0px 10px 0px;">
		<div style="width:100%; float:left;">
			<div style="padding:0px 10px 10px 10px;">
				<button onclick="location.href='<?php echo URL::Route('home'); ?>'" class="btn-blue-l" style="width:100%; margin:0; padding:0; float:none;"><?php echo trans('checkout.thankyou.backhome'); ?></button>
			</div>
		</div>
		<div class="clear"></div>
	</div>


 </div>
<?php if (App::environment('production') && strtoupper(array_get($data, 'data.analytics_status')) === 'N'): ?>
<?php
	$tracking = '';
	$tracking = '
	<script type="text/javascript">
    var _gaq = _gaq || [];
        _gaq.push(["_setAccount", "UA-38234774-1"]);
        _gaq.push(["_trackPageview"]);
    
    // transaction details
    _gaq.push(["_addTrans",
       "'.array_get($ecommerce,'data.order.order_id').'", // transaction ID - required
       "'.array_get($ecommerce,'data.order.shop_name').'", // affiliation or store name
       "'.array_get($ecommerce,'data.order.sub_total').'",          // total - required
       "0",           // tax
       "'.array_get($ecommerce,'data.order.shipping_fee').'",          // shipping
       "'.array_get($ecommerce,'data.order.customer_city').'",       // city
       "'.array_get($ecommerce,'data.order.customer_province').'",     // state or province
       "'.array_get($ecommerce,'data.order.country').'"             // country
    ]);  
	';
	
	if ( ! empty($ecommerce['data'])){
		if(! empty($ecommerce['data']['order_item'])){
			for($i = 0; $i < count($ecommerce['data']['order_item']); $i++){
				$tracking .= '_gaq.push(["_addItem",
				   "'.$ecommerce['data']['order_item'][$i]['order_id'].'",           // transaction ID - necessary to associate item with transaction
				   "'.$ecommerce['data']['order_item'][$i]['sku_code'].'",           // SKU/code - required
				   "'.$ecommerce['data']['order_item'][$i]['name'].'",        // product name
				   "'.$ecommerce['data']['order_item'][$i]['category'].'",   // category or variation
				   "'.$ecommerce['data']['order_item'][$i]['price_per_unit'].'",          // unit price - required
				   "'.$ecommerce['data']['order_item'][$i]['quantity'].'"            // quantity - required
				]);';
			}
		}
	}
	
	$tracking .= '// End Loop
	// track transaction
	_gaq.push(["_trackTrans"]);

	(function() { 
			var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true; 
			ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js"; 
			var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s); 
	})(); 
		
	</script>';
?>

<?php Theme::asset()->writeContent('analytic-goal', $tracking ); ?>
<?php Theme::asset()->container('embed')->writeContent('Remarketing', '
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
' ); ?>
<?php endif; ?>
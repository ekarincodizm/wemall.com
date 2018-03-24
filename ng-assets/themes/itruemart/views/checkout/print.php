  <div id="imgprint" style="width: 640px; text-align: right; display: block;">
        <img src="<?php echo Theme::asset()->usePath()->url('images/payment/btn_print.gif') ?>" border="0" onclick="myPrint();" style="cursor:hand;"></div>

    <table width="640" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td height="100%" valign="top">
                    <div class="containerL5R5T5B5">
                        <table width="640" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td height="80" align="left">
                                        <img src="<?php echo Theme::asset()->usePath()->url('images/payment/logo_01.jpg') ?>" height="66"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="99%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="vline01">
                                            <img src="<?php echo Theme::asset()->usePath()->url('images/payment/spacer.gif') ?>" width="1" height="1"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="99%" height="95" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div align="center" class="style7">
                                            แบบฟอร์มนี้ใช้สำหรับการชำระค่าสินค้าและบริการด้วยเงินสด
                                            <br>
                                            <span class="style8">กรณีสั่งซื้อสินค้าผ่านทาง Internet เท่านั้น</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="99%" height="30" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td width="49%" valign="bottom"> <strong class="txthbigheader">แบบฟอร์มการชำระเงิน</strong>
                                    </td>
                                    <td width="51%" valign="bottom">
                                        <div align="right" class="txtnormal">ส่วนของลูกค้า</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="99%" height="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
                            <tbody>
                                <tr>
                                    <td align="center">
                                        <table width="98%" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td width="25%" height="25" class="txtheader style4">สำหรับเจ้าหน้าที่ธนาคาร</td>
                                                    <td width="26%" height="25">&nbsp;</td>
                                                    <td width="19%" height="25">&nbsp;</td>
                                                    <td width="30%" height="25">&nbsp;</td>
                                                </tr>
                                                <tr class="txtnormal">
                                                    <td height="25">
                                                        <span class="style5">รวมยอดที่ต้องชำระ :</span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5"><?php echo number_format(array_get($data, 'data.sub_total'),2); ?> บาท</span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5">ผู้รับเงิน / ธนาคาร :</span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5">…………………………</span>
                                                    </td>
                                                </tr>
                                                <tr class="txtnormal">
                                                    <td height="25">
                                                        <span class="style5">เลขที่อ้างอิง1 (Ref.No.1) :</span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5"><?php echo array_get($data, 'data.ref1'); ?></span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5">สาขา :</span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5">…………………………</span>
                                                    </td>
                                                </tr>
                                                <tr class="txtnormal">
                                                    <td height="25">
                                                        <span class="style5">เลขที่อ้างอิง2 (Ref.No.2) :</span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5"><?php echo array_get($data, 'data.ref2'); ?></span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5">วันที่ชำระเงิน :</span>
                                                    </td>
                                                    <td height="25">
                                                        <span class="style5">…………………………</span>
                                                    </td>
                                                </tr>
                                                <tr class="txtnormal">
                                                    <td height="25"></td>
                                                    <td height="25">
                                                        <span class="style5"></span>
                                                    </td>
                                                    <td height="25">&nbsp;</td>
                                                    <td height="25">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <span class="style5" style="color:red;">
                                            **ลูกค้าต้องชำระเงินภายในวันที่ <?php echo array_get($data, 'data.order_expired.date'); ?> น. มิเช่นนั้นลูกค้าอาจไม่ได้รับสินค้าตามที่ได้ทำการสั่งซื้อ**
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table width="99%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td align="center" valign="bottom" class="txtfooter">
                                        กรุณาอย่าตัด และโปรดนำทั้งใบไปใช้ในการชำระเงิน เจ้าหน้าที่ธนาคารจะคืนส่วนของลูกค้าให้ท่าน
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        ---------------------------------------------------------------------------------------------------------
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table width="99%" height="30" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td width="49%" height="60" valign="bottom">&nbsp;</td>
                                    <td width="51%" valign="bottom">
                                        <div align="right" class="txtnormal">
                                            ส่วนของธนาคาร
                                            <br>
                                            โปรดเรียกเก็บค่าธรรมเนียมจากผู้ชำระเงิน
                                            <br></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
                            <tbody>
                                <tr>
                                    <td colspan="2" align="center">
                                        <table width="99%" height="35" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td width="25%" height="25" class="txtheader style4">ใบแจ้งการชำระเงินเพื่อนำเข้าบัญชีบริษัท ทรู มันนี่ จำกัด</td>
                                                    <td width="26%" height="25" class="txtheader">
                                                        <div align="right" class="style4">เลขประจำตัวผู้เสียภาษี 30312-12756</div>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr align="center" valign="top">
                                    <td height="120" colspan="2">
                                        <table width="98%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td width="57%" valign="top">
                                                        <table width="97%" border="0" cellspacing="0" cellpadding="2">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="6%" height="20" class="txtnormal">[ ] บมจ. ธ.กสิกรไทย 049-11-3341-4</td>
                                                                </tr>

                                                                <tr>
                                                                    <td height="20" class="txtnormal">
                                                                        [ ] บมจ. ธ.ไทยพาณิชย์ COMP CODE : 0546 (ถนนรัชดาภิเษก 3) (10/10)
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20" class="txtnormal">
                                                                        [ ] บมจ. ธ.กรุงเทพ (Br.No. 0185) (Comp Code:60000)
                                                                        <br>
                                                                        &nbsp;&nbsp;&nbsp;
                                                                            (Service Code: TMNWLS) (10/25)
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td width="43%" valign="top">
                                                        <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" class="txtnormal">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="46%" height="20" class="txtnormal">วันที่ชำระ</td>
                                                                    <td width="54%" class="txtnormal">......./....../......</td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20" class="txtnormal">ชื่อลูกค้า</td>
                                                                    <td align="left" class="txtnormal"><?php echo array_get($data, 'data.customer_name'); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20" class="txtnormal">
                                                                        เลขที่อ้างอิง1
                                                                        <span class="txtfooter">(Ref.No.1)</span>
                                                                    </td>
                                                                    <td align="left" class="txtnormal"><?php echo array_get($data, 'data.ref1');?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20" class="txtnormal">
                                                                        เลขที่อ้างอิง2
                                                                        <span class="txtfooter">(Ref.No.2)</span>
                                                                    </td>
                                                                    <td align="left" class="txtnormal"><?php echo array_get($data, 'data.ref2'); ?></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" valign="top">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td height="30">
                                        <div align="center" class="txtNormalRed"> <strong>ชำระเป็นเงินสดเท่านั้น</strong>
                                        </div>
                                    </td>
                                    <td height="25" class="txtnormal">
                                        <div align="center">
                                            <strong>จำนวน</strong>
                                        </div>

                                        <tr>
                                            <td width="82%" height="35" class="txtnormal style4">&nbsp;จำนวนเงินเป็นตัวอักษร (<?php echo thaiBahtConversion(array_get($data, 'data.sub_total'));?>)</td>
                                            <td width="18%" height="25" class="txtheader">
                                                <div align="center">
                                                    <span class="style5"><?php echo number_format(array_get($data, 'data.sub_total'),2); ?></span>
                                                    บาท
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="txtfooter">
                                    หมายเหตุ : กรณีชำระเงินที่ธนาคาร กรุณานำแบบฟอร์มนี้ไปด้วยพร้อมชำระค่าธรรมเนียม ณ จุดบริการ
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กรณีนิติบุคคล ผู้มีหน้าที่ต้องหักภาษี ณ ที่จ่าย ตามประมวลรัษฎากรไม่สามารถชำระค่าบริการได้ด้วยวิธีนี้ กรุณาติดต่อ 02-900-9999 กด 3
                                </p>
                                <table width="99%" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                                    <tbody>
                                        <tr>
                                            <td width="54%" height="13">
                                                ผู้รับฝาก <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> 
                                                <u>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</u>
                                                <u>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;</u>
                                                โทร
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> 
                                            </td>
                                            <td width="46%" align="left">
                                                ผู้รับเงิน
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u></u>
                                                <u>&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                วันที่
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                                                <u>&nbsp;&nbsp;</u>
                                                <u>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </u>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <table width="99%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div align="center">
                                                    <span class="txtnormal style4"></span>
                                                </div>
                                                <div align="center">
                                                    <span class="txtnormal style4">
                                                        บริษัท ทรู มันนี่ จำกัด 18 อาคารทรูทาวเวอร์ ถนนรัชดาภิเษก แขวงห้วงขวาง เขตห้วยขวาง กรุงเทพฯ 10310
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </td>
                    </tr>
                    <tr></tr>
                </tbody>
            </table>
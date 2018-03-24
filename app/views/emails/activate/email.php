
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Tahoma,'Microsoft Sans Serif',sans-serif;font-size:12px;color:#000">
            <tbody>
                <tr>
                    <td valign="top" style="padding:0 0 10px 0"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>

                                    <td><img src="https://ci3.googleusercontent.com/proxy/KxYZus3JKVmxTfEcPx7KAmdBf3INti5vDZg6G39C85bdMOhXcebIeJLu4SYEEtRgXG4E3kNbRZ3V7RI3jJ5u8r1uGrI_uLhHJpqo_ulRmRLCN2XD-_j0uKSoaAHTaA=s0-d-e1-ft#https://<?php echo Request::server ("SERVER_NAME"); ?>/assets/itruemart_new/global/images/logo_01.jpg" alt="itruemart"></td>


                                    <td width="506" valign="top" style="padding:15px 0 0 15px;background-repeat:no-repeat">
                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td width="15%" align="right" valign="top"><strong style="font-size:12px">จาก :</strong></td>
                                                    <td valign="top" style="color:#666;font-size:12px"><a href="mailto:<?php echo $from ?>" target="_blank"><?php echo $from ?></a></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" valign="top"><strong style="font-size:12px">โดย :</strong></td>            
                                                    <td valign="top" style="color:#666;font-size:12px"><?php echo $sender ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" valign="top"><strong style="font-size:12px">เรื่อง :</strong></td>
                                                    <td valign="top" style="color:#666;font-size:12px">ยืนยันการลงทะเบียนด้วยอีเมล์ (Verify email)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>

                                </tr>
                            </tbody>
                        </table></td>
                </tr>
                <tr>
                    <td>
                        <div style="padding:0 0 10px 0"></div>
                        <div style="line-height:0"><img src="https://ci5.googleusercontent.com/proxy/GNar8uBAHXLXmMp3e4SkkzcmhNGnzNajxyIcN1IeY507j8C4ROf8LOhTEDqk-uvaGvX0sEl-wJ1WwnCpBEXDzmZGWJgV0D8upHayXryOEJeJm4JviBqLOPczPFIhubkFlu21cMEwUVG9-ByuS8okdg=s0-d-e1-ft#http://app.weloveshopping.com/member/assets/templates/wls2012/images/email/top-details.gif" alt="" width="700" height="15"></div>
                        <div style="width:684px;border-left:1px solid #ccc;border-right:1px solid #ccc;padding:5px 7px; background-color: #fcfefc;">
                            <div style="padding:10 0 10px 0">

                                <div style="padding:0 0 10px 0">
                                    <br><br>
                                    <p>ไอดีของคุณ : <a href="mailto:<?php echo $email ?>" target="_blank"><?php echo $email ?></a></p>
                                    <br><br>
                                    <p>คุณสามารถยืนยันการลงทะเบียน โดยการกดที่ลิ้งค์ด้านล่างนี้ค่ะ</p>
                                    <p><a href="<?php echo $activateUrl ?>" target="_blank"><?php echo $activateUrl ?></a></p>
                                    <br><br>
                                </div>
                                <p style="margin-top:20px">ขอบคุณค่ะ<br/><?php echo $sender ?> </p>

                            </div>
                        </div>
                        <div style="padding:0 0 10px 0;line-height:0"><img src="http://app.weloveshopping.com/member/assets/templates/wls2012/images/email/bttm-details.gif" alt="" width="700" height="15"></div></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>

<style type="text/css">
div { position: absolute; background: transparent; text-align: left; color: #000000; font-family: Arial; font-size: 9pt; }
.center { text-align: center; }
.wide { width: 100%; }
.bfull { border: 1px #000000 solid; }
.smallf { font-size: 6pt; }
.field { border: none; border-bottom: 1px #000000 solid; font-style: italic; font-size: 8.5pt; }
</style>

<div class="bfull" style="left: 20px; top: 20px; width: 705px; height: 574px;">
<div class="bfull" style="left: 0px; top: 0px; width: 191px; height: 287px;">
<div class="wide center" style="top: 13px;">Извещение</div>
<div class="wide center" style="top: 206px;">Кассир</div>
</div>
<div class="bfull" style="left: 191px; top: 0px; width: 514px; height: 287px;">
<div class="smallf" style="left: 452px; top: 10px;">Форма №ПД-4</div>

<div class="field" style="top: 24px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][5]['value']; ?>, ИНН/КПП <?php echo $payment_data["PaymentMethodValue"][4]['value']; ?>/<?php echo $payment_data["PaymentMethodValue"][6]['value']; ?></div>
<div class="smallf center" style="top: 40px; left: 7px; width: 500px;">получатель платежа</div>
<div class="field" style="top: 54px; left: 7px; width: 350px;"><?php echo $payment_data["PaymentMethodValue"][0]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 7px; width: 350px;">Наименование банка</div>
<div class="field" style="top: 54px; left: 364px; width: 143px;"><?php echo $payment_data["PaymentMethodValue"][1]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 364px; width: 143px;">Расчетный счет</div>
<div class="field" style="top: 84px; left: 7px; width: 500px;">К/с <?php echo $payment_data["PaymentMethodValue"][3]['value']; ?>, БИК <?php echo $payment_data["PaymentMethodValue"][2]['value']; ?></div>
<div class="smallf center" style="top: 100px; left: 7px; width: 500px;">другие банковские реквизиты</div>
<div class="field" style="top: 114px; left: 7px; width: 500px; height:14px; overflow:hidden;"><?php echo $data['Order']['bill_name']; ?>&nbsp;<?php echo $data['Order']['phone']; ?></div>

<div class="smallf center" style="top: 130px; left: 7px; width: 500px;">ФИО плательщика</div>
<div class="field" style="top: 144px; left: 7px; width: 500px;"><?php echo $data['Order']['bill_city']; ?>&nbsp;<?php echo $data['Order']['bill_line_1']; ?></div>
<div class="smallf center" style="top: 160px; left: 7px; width: 500px;">Адрес плательщика</div>
<div class="field" style="top: 174px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][7]['value']; ?>&nbsp;<?php echo $_SESSION['Customer']['order_id']; ?></div>
<div class="smallf center" style="top: 190px; left: 7px; width: 500px;">Назначение платежа</div>
<div style="top: 204px; left: 7px; width: 76px;">Сумма</div>
<div class="field" style="top: 204px; left: 90px; width: 190px;"><?php echo $data['Order']['total']; ?> руб. </div>
<div style="top: 246px; left: 7px; width: 200px;">Подпись плательщика</div>
</div>

<div class="bfull" style="left: 0px; top: 287px; width: 191px; height: 287px;">
<div class="wide center" style="top: 13px;">Квитанция</div>
<div class="wide center" style="top: 206px;">Кассир</div>
</div>
<div class="bfull" style="left: 191px; top: 287px; width: 514px; height: 287px;">
<div class="smallf" style="left: 452px; top: 10px;">Форма №ПД-4</div>
<div class="field" style="top: 24px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][5]['value']; ?>, ИНН/КПП <?php echo $payment_data["PaymentMethodValue"][4]['value']; ?>/<?php echo $payment_data["PaymentMethodValue"][6]['value']; ?></div>
<div class="smallf center" style="top: 40px; left: 7px; width: 500px;">получатель платежа</div>
<div class="field" style="top: 54px; left: 7px; width: 350px;"><?php echo $payment_data["PaymentMethodValue"][0]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 7px; width: 350px;">Наименование банка</div>
<div class="field" style="top: 54px; left: 364px; width: 143px;"><?php echo $payment_data["PaymentMethodValue"][1]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 364px; width: 143px;">Расчетный счет</div>
<div class="field" style="top: 84px; left: 7px; width: 500px;">К/с <?php echo $payment_data["PaymentMethodValue"][3]['value']; ?>, БИК <?php echo $payment_data["PaymentMethodValue"][2]['value']; ?></div>
<div class="smallf center" style="top: 100px; left: 7px; width: 500px;">другие банковские реквизиты</div>
<div class="field" style="top: 114px; left: 7px; width: 500px; height:14px; overflow:hidden;"><?php echo $data['Order']['bill_name']; ?>&nbsp;<?php echo $data['Order']['phone']; ?></div>
<div class="smallf center" style="top: 130px; left: 7px; width: 500px;">ФИО плательщика</div>
<div class="field" style="top: 144px; left: 7px; width: 500px;"><?php echo $data['Order']['bill_city']; ?>&nbsp;<?php echo $data['Order']['bill_line_1']; ?></div>
<div class="smallf center" style="top: 160px; left: 7px; width: 500px;">Адрес плательщика</div>
<div class="field" style="top: 174px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][7]['value']; ?>&nbsp;<?php echo $_SESSION['Customer']['order_id']; ?></div>
<div class="smallf center" style="top: 190px; left: 7px; width: 500px;">Назначение платежа</div>
<div style="top: 204px; left: 7px; width: 76px;">Сумма</div>
<div class="field" style="top: 204px; left: 90px; width: 190px;"><?php echo $data['Order']['total']; ?> руб. </div>
<div style="top: 246px; left: 7px; width: 200px;">Подпись плательщика</div>
</div>
</div>
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
<div class="wide center" style="top: 13px;"><?php echo __('Notice'); ?></div>
<div class="wide center" style="top: 206px;"><?php echo __('Teller'); ?></div>
</div>
<div class="bfull" style="left: 191px; top: 0px; width: 514px; height: 287px;">
<div class="smallf" style="left: 452px; top: 10px;"><?php echo __('Form #PD-4'); ?></div>

<div class="field" style="top: 24px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][5]['value']; ?>, <?php echo __('INN'); ?>/<?php echo __('KPP'); ?> <?php echo $payment_data["PaymentMethodValue"][4]['value']; ?>/<?php echo $payment_data["PaymentMethodValue"][6]['value']; ?></div>
<div class="smallf center" style="top: 40px; left: 7px; width: 500px;"><?php echo __('recipient'); ?></div>
<div class="field" style="top: 54px; left: 7px; width: 350px;"><?php echo $payment_data["PaymentMethodValue"][0]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 7px; width: 350px;"><?php echo __('Bank Name'); ?></div>
<div class="field" style="top: 54px; left: 364px; width: 143px;"><?php echo $payment_data["PaymentMethodValue"][1]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 364px; width: 143px;"><?php echo __('Account Number 1'); ?></div>
<div class="field" style="top: 84px; left: 7px; width: 500px;"><?php echo __('Account Number 2'); ?> <?php echo $payment_data["PaymentMethodValue"][3]['value']; ?>, <?php echo __('BIK'); ?> <?php echo $payment_data["PaymentMethodValue"][2]['value']; ?></div>
<div class="smallf center" style="top: 100px; left: 7px; width: 500px;"><?php echo __('bank info'); ?></div>
<div class="field" style="top: 114px; left: 7px; width: 500px; height:14px; overflow:hidden;"><?php echo $data['Order']['bill_name']; ?>&nbsp;<?php echo $data['Order']['phone']; ?></div>

<div class="smallf center" style="top: 130px; left: 7px; width: 500px;"><?php echo __('Payeer Name'); ?></div>
<div class="field" style="top: 144px; left: 7px; width: 500px;"><?php echo $data['Order']['bill_city']; ?>&nbsp;<?php echo $data['Order']['bill_line_1']; ?></div>
<div class="smallf center" style="top: 160px; left: 7px; width: 500px;"><?php echo __('Payeer Address'); ?></div>
<div class="field" style="top: 174px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][7]['value']; ?>&nbsp;<?php echo $_SESSION['Customer']['order_id']; ?></div>
<div class="smallf center" style="top: 190px; left: 7px; width: 500px;"><?php echo __('Payment Text'); ?></div>
<div style="top: 204px; left: 7px; width: 76px;"><?php echo __('Total'); ?></div>
<div class="field" style="top: 204px; left: 90px; width: 190px;"><?php echo $data['Order']['total']; ?> <?php echo __('rub.'); ?> </div>
<div style="top: 246px; left: 7px; width: 200px;"><?php echo __('Signature'); ?></div>
</div>

<div class="bfull" style="left: 0px; top: 287px; width: 191px; height: 287px;">
<div class="wide center" style="top: 13px;"><?php echo __('Receipt'); ?></div>
<div class="wide center" style="top: 206px;"><?php echo __('Teller'); ?></div>
</div>
<div class="bfull" style="left: 191px; top: 287px; width: 514px; height: 287px;">
<div class="smallf" style="left: 452px; top: 10px;"><?php echo __('Form #PD-4'); ?></div>
<div class="field" style="top: 24px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][5]['value']; ?>, <?php echo __('INN'); ?>/<?php echo __('KPP'); ?> <?php echo $payment_data["PaymentMethodValue"][4]['value']; ?>/<?php echo $payment_data["PaymentMethodValue"][6]['value']; ?></div>
<div class="smallf center" style="top: 40px; left: 7px; width: 500px;"><?php echo __('recipient'); ?></div>
<div class="field" style="top: 54px; left: 7px; width: 350px;"><?php echo $payment_data["PaymentMethodValue"][0]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 7px; width: 350px;"><?php echo __('Bank Name'); ?></div>
<div class="field" style="top: 54px; left: 364px; width: 143px;"><?php echo $payment_data["PaymentMethodValue"][1]['value']; ?></div>
<div class="smallf center" style="top: 70px; left: 364px; width: 143px;"><?php echo __('Account Number 1'); ?></div>
<div class="field" style="top: 84px; left: 7px; width: 500px;"><?php echo __('Account Number 2'); ?> <?php echo $payment_data["PaymentMethodValue"][3]['value']; ?>, <?php echo __('BIK'); ?> <?php echo $payment_data["PaymentMethodValue"][2]['value']; ?></div>
<div class="smallf center" style="top: 100px; left: 7px; width: 500px;"><?php echo __('bank info'); ?></div>
<div class="field" style="top: 114px; left: 7px; width: 500px; height:14px; overflow:hidden;"><?php echo $data['Order']['bill_name']; ?>&nbsp;<?php echo $data['Order']['phone']; ?></div>
<div class="smallf center" style="top: 130px; left: 7px; width: 500px;"><?php echo __('Payeer Name'); ?></div>
<div class="field" style="top: 144px; left: 7px; width: 500px;"><?php echo $data['Order']['bill_city']; ?>&nbsp;<?php echo $data['Order']['bill_line_1']; ?></div>
<div class="smallf center" style="top: 160px; left: 7px; width: 500px;"><?php echo __('Payeer Address'); ?></div>
<div class="field" style="top: 174px; left: 7px; width: 500px;"><?php echo $payment_data["PaymentMethodValue"][7]['value']; ?>&nbsp;<?php echo $_SESSION['Customer']['order_id']; ?></div>
<div class="smallf center" style="top: 190px; left: 7px; width: 500px;"><?php echo __('Payment Text'); ?></div>
<div style="top: 204px; left: 7px; width: 76px;"><?php echo __('Total'); ?></div>
<div class="field" style="top: 204px; left: 90px; width: 190px;"><?php echo $data['Order']['total']; ?> <?php echo __('rub.'); ?> </div>
<div style="top: 246px; left: 7px; width: 200px;"><?php echo __('Signature'); ?></div>
</div>
</div>
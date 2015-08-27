<p>
<?php if (isset($payment_data["PaymentMethodValue"][5]['value']) && $payment_data["PaymentMethodValue"][5]['value'] != '') { ?>
<b><?php echo __('Supplier'); ?></b> <?php echo $payment_data["PaymentMethodValue"][5]['value']; ?><br />
<?php } ?>
<?php if (isset($payment_data["PaymentMethodValue"][8]['value']) && $payment_data["PaymentMethodValue"][8]['value'] != '') { ?>
<b><?php echo __('Company Address'); ?></b> <?php echo $payment_data["PaymentMethodValue"][8]['value']; ?><br />
<?php } ?>
<?php if (isset($payment_data["PaymentMethodValue"][9]['value']) && $payment_data["PaymentMethodValue"][9]['value'] !== '') { ?>
<b><?php echo __('Company Phone'); ?></b>&nbsp;<?php echo $payment_data["PaymentMethodValue"][9]['value']; ?><br />
<?php } ?>
<?php if (isset($payment_data["PaymentMethodValue"][1]['value']) && $payment_data["PaymentMethodValue"][1]['value'] !== '') { ?>
<b><?php echo __('Account Number 1'); ?></b> 
<?php echo $payment_data["PaymentMethodValue"][1]['value']; ?><?php } ?> <?php if (isset($payment_data["PaymentMethodValue"][0]['value']) && $payment_data["PaymentMethodValue"][0]['value'] !== '') { ?><b><?php echo __('in bank'); ?></b> <?php echo $payment_data["PaymentMethodValue"][0]['value']; ?><br />
<?php } ?>
<?php if (isset($payment_data["PaymentMethodValue"][3]['value']) && $payment_data["PaymentMethodValue"][3]['value'] !== '') { ?>
<b><?php echo __('Account Number 2'); ?></b> 
<?php echo $payment_data["PaymentMethodValue"][3]['value']; ?><?php } ?> <?php if (isset($payment_data["PaymentMethodValue"][2]['value']) && $payment_data["PaymentMethodValue"][2]['value'] !== '') { ?><b><?php echo __('BIK'); ?></b> <?php echo $payment_data["PaymentMethodValue"][2]['value']; ?><br />
<?php } ?>
<?php if (isset($payment_data["PaymentMethodValue"][4]['value']) && $payment_data["PaymentMethodValue"][4]['value'] !== '') { ?>
<b><?php echo __('INN'); ?></b> <?php echo $payment_data["PaymentMethodValue"][4]['value']; ?><?php } ?><?php if (isset($payment_data["PaymentMethodValue"][6]['value']) && $payment_data["PaymentMethodValue"][6]['value'] !== '') { ?>&nbsp; <b><?php echo __('KPP'); ?></b> <?php echo $payment_data["PaymentMethodValue"][6]['value']; ?><?php } ?>&nbsp; <?php if (isset($payment_data["PaymentMethodValue"][10]['value'])  && $payment_data["PaymentMethodValue"][10]['value'] !== '') { ?><b><?php echo __('OGRN'); ?></b> <?php echo $payment_data["PaymentMethodValue"][10]['value']; ?><?php } ?> <?php if (isset($payment_data["PaymentMethodValue"][11]['value']) && $payment_data["PaymentMethodValue"][11]['value'] !== '') { ?><b><?php echo __('OKPO'); ?></b> <?php echo $payment_data["PaymentMethodValue"][11]['value']; ?><br />
<?php } ?>
</p>

<?php if ($data['Order']['company_name'] != '') { ?>
<p><b><?php echo __('Customer'); ?></b> <?php echo $data['Order']['company_name']; ?></p>
<?php } else { ?>
<p><b><?php echo __('Customer'); ?></b> <?php echo $data['Order']['bill_name']; ?></p>
<?php } ?>
<?php if ($data['Order']['company_info'] != '') { ?>
<p>
<?php echo $data['Order']['company_info']; ?>
</p>
<?php } ?>
<?php if ($data['Order']['bill_line_1'] != '') { ?>
<p>
<b><?php echo __('Company Address'); ?></b> <?php echo $data['Order']['bill_line_1']; ?><br />
<?php } ?>
<?php if ($data['Order']['phone'] != '') { ?>
<p><b><?php echo __('Phone'); ?></b> <?php echo $data['Order']['phone']; ?></p>
<?php } ?>
<?php if ($data['Order']['email'] != '') { ?>
<p><b><?php echo __('Email'); ?></b> <?php echo $data['Order']['email']; ?></p>
<?php } ?>
<hr>
<p><b><font size="5"><?php echo __('Packing Slip #'); ?> <?php echo $data['Order']['id']; ?> <?php echo __('on'); ?> <?php echo $data['Order']['created']; ?></font></b></p>
<p>&nbsp;</p>
<table border="0" width="92%" id="table1" cellspacing="0">
	<tr>
		<td width="5%" style="border-style: solid; border-width: 1px" align="center"><b><?php echo __('#'); ?></b></td>
		<td width="17%" style="border-style: solid; border-width: 1px" align="center"><b><?php echo __('Model'); ?></b></td>
		<td width="48%" style="border-style: solid; border-width: 1px" align="center"><b><?php echo __('Product Name'); ?></b></td>
		<td width="12%" style="border-style: solid; border-width: 1px" align="center"><b><?php echo __('Quantity'); ?></b></td>
		<td style="border-style: solid; border-width: 1px" width="6%" align="center"><b><?php echo __('Price'); ?></b></td>
		<td width="9%" style="border-style: solid; border-width: 1px" align="center"><b><?php echo __('Total'); ?></b></td>
	</tr>
	
<?php foreach($data['OrderProduct'] AS $product) { ?> 
<?php $counter ++; ?>
        <tr> 
		<td width="5%" style="border-style: solid; border-width: 1px"><?php echo $counter; ?>.</td>
		<td width="17%" style="border-style: solid; border-width: 1px"><?php echo $product['model']; ?></td>
		<td width="48%" style="border-style: solid; border-width: 1px"><?php echo $product['name']; ?></td>
		<td width="12%" style="border-style: solid; border-width: 1px"><?php echo $product['quantity']; ?></td>
		<td style="border-style: solid; border-width: 1px" width="6%"><?php echo $product['price']; ?></td>
		<td width="9%" style="border-style: solid; border-width: 1px"><?php echo $product['price']*$product['quantity']; ?></td>
        </tr>
<?php } ?>
        <tr> 
		<td width="5%" style="border-style: solid; border-width: 1px">&nbsp;</td>
		<td width="17%" style="border-style: solid; border-width: 1px">&nbsp;</td>
		<td width="48%" style="border-style: solid; border-width: 1px"><?php echo __($data['ShippingMethod']['name']); ?></td>
		<td width="12%" style="border-style: solid; border-width: 1px">1</td>
		<td style="border-style: solid; border-width: 1px" width="6%"><?php echo $data['Order']['shipping']; ?></td>
		<td width="9%" style="border-style: solid; border-width: 1px"><?php echo $data['Order']['shipping']; ?></td>
        </tr>
<?php if ($data['Order']['tax'] > 0) { ?> 
	<tr>
		<td colspan="5" style="border-style: solid; border-width: 1px">
		<p align="right"><b><?php echo __("Tax"); ?></b></td>
		<td width="9%" style="border-style: solid; border-width: 1px"><?php echo $data['Order']['tax']; ?></td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="5" style="border-style: solid; border-width: 1px">
		<p align="right"><b><?php echo __('Order Total'); ?></b></td>
		<td width="9%" style="border-style: solid; border-width: 1px"><?php echo $data['Order']['total']; ?></td>
	</tr>

</table>
<p><b><?php echo __('Summa:'); ?> <?php echo $this->Summa->get($data['Order']['total']); ?>. <?php echo __('without tax.'); ?></b></p>
<p>&nbsp;</p>
<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<?php echo __('Packed by'); ?> _____________________________ /<?php echo __('Last Name'); ?>/</b></p>
<p><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('MP'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<?php echo __('Checked by'); ?> _________________________/<?php echo __('Last Name'); ?>/</b></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
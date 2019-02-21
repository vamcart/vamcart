<?php
echo $this->Form->input('paykeeper.form_url', array(
    'label' => __('Адрес формы оплаты PayKeeper'),
    'type'  => 'text',
    'value' => $data['PaymentMethodValue'][0]['value']
    ));

echo $this->Form->input('paykeeper.secret_seed', array(
    'label' => __('Секретное слово'),
    'type'  => 'text',
    'value' => $data['PaymentMethodValue'][1]['value']
    ));
?>

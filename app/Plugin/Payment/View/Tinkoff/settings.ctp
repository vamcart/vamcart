<?php

echo $this->Form->input('tinkoff.terminal_key', array(
    'label' => __('Terminal Key'),
    'type'  => 'text',
    'value' => $data['PaymentMethodValue'][0]['value']
));

echo $this->Form->input('tinkoff.password', array(
    'label' => __('Password:'),
    'type'  => 'text',
    'value' => $data['PaymentMethodValue'][1]['value']
));

echo $this->Form->input('tinkoff.payment_enabled', array(
    'label'     => __('Enabled Taxation'),
    'type'      => 'select',
    'options'   => array(
        'yes' => __('Да'),
        'on'  => __('Нет'),
    ),
    'legend'    => false,
    'value'     => $data['PaymentMethodValue'][2]['value']
));

echo $this->Form->input('tinkoff.email_company', array(
    'label' => __('Email Company'),
    'type'  => 'email',
    'value' => $data['PaymentMethodValue'][3]['value']
));

echo $this->Form->input('tinkoff.payment_taxation', array(
    'label'     => __('Taxation'),
    'type'      => 'select',
    'options'   => array(
        'osn'                => __('Общая СН (General system of taxation)'),
        'usn_income'         => __('Упрощенная СН (доходы)'),
        'usn_income_outcome' => __('Упрощенная СН (доходы минус расходы)'),
        'envd'               => __('Единый налог на вмененный доход'),
        'esn'                => __('Единый сельскохозяйственный налог'),
        'patent'             => __('Патентная СН'),
    ),
    'legend'    => false,
    'value'     => $data['PaymentMethodValue'][4]['value']
));

echo $this->Form->input('tinkoff.payment_method', array(
    'label'     => __('Payment Method'),
    'type'      => 'select',
    'options'   => array(
        'full_prepayment' => __('предоплата 100%'),
        'prepayment'      => __('предоплата'),
        'advance'         => __('аванс'),
        'full_payment'    => __('полный расчет'),
        'partial_payment' => __('частичный расчет и кредит'),
        'credit'          => __('передача в кредит'),
        'credit_payment'  => __('оплата кредита'),
    ),
    'legend'    => false,
    'value'     => $data['PaymentMethodValue'][5]['value']
));

echo $this->Form->input('tinkoff.payment_object', array(
    'label'     => __('Payment Object'),
    'type'      => 'select',
    'options'   => array(
        'commodity'             => __('товар'),
        'excise'                => __('подакцизныйтовар'),
        'job'                   => __('работа'),
        'service'               => __('услуга'),
        'gambling_bet'          => __('ставка азартной игры'),
        'gambling_prize'        => __('выигрыш азартной игры'),
        'lottery'               => __('лотерейный билет'),
        'lottery_prize'         => __('выигрыш лотереи'),
        'intellectual_activity' => __('предоставление результатов интеллектуальной деятельности'),
        'payment'               => __('платеж'),
        'agent_commission'      => __('агентское вознаграждение'),
        'composite'             => __('составной предмет расчета'),
        'another'               => __('иной предмет расчета'),
    ),
    'legend'    => false,
    'value'     => $data['PaymentMethodValue'][6]['value']
));

echo $this->Form->input('tinkoff.payment_shipping', array(
    'label'     => __('The tax rate of delivery'),
    'type'      => 'select',
    'options'   => array(
        'none'    => __('none'),
        'vat0'    => __('0%'),
        'vat10'   => __('10%'),
        'vat20'   => __('20%'),
    ),
    'legend'    => false,
    'value'     => $data['PaymentMethodValue'][7]['value']
));

echo $this->Form->input('tinkoff.payment_tax', array(
    'label'     => __('The tax rate of product'),
    'type'      => 'select',
    'options'   => array(
        'none'    => __('none'),
        'vat0'    => __('0%'),
        'vat10'   => __('10%'),
        'vat20'   => __('20%'),
    ),
    'legend'    => false,
    'value'     => $data['PaymentMethodValue'][8]['value']
));


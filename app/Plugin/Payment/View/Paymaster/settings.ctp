<?php
$i = 0;

echo $this->Form->input('paymaster.merchant_id', array(
    'label' => __('Идентификатор продавца'),
    'type' => 'text',
    'value' => $data['PaymentMethodValue'][$i]['value']
));
$i++;

echo $this->Form->input('paymaster.secret_key', array(
    'label' => __('Секретный ключ'),
    'type' => 'text',
    'value' => $data['PaymentMethodValue'][$i]['value']
));
$i++;

echo $this->Form->input('paymaster.sign_method', array(
    'label' => __('Метод шифрования'),
    'type' => 'select',
    'options' => array('md5' => 'md5', 'sha256' => 'sha256', 'sha1' => 'sha1'),
    'selected' => isset($data['PaymentMethodValue'][$i]['value']) ? $data['PaymentMethodValue'][$i]['value'] : "",
));
$i++;

echo $this->Form->input('paymaster.vat_delivery', array(
    'label' => __('Ставка НДС для доставки'),
    'type' => 'select',
    'options' => array(
        'vat18' => 'НДС 18%',
        'vat10' => 'НДС 10%',
        'vat118' => 'НДС по формуле 18/118',
        'vat110' => 'НДС по формуле 10/110',
        'vat0' => 'НДС 0%',
        'no_vat' => 'Без НДС',
    ),
    'selected' => isset($data['PaymentMethodValue'][$i]['value']) ? $data['PaymentMethodValue'][$i]['value'] : "",
));
$i++;


// Здесь делаем экспорт категорий товаров (каталога) в форму
App::import('Model', 'Content');
$this->Content = new Content();

$this->Content->unbindAll();

$this->Content->bindModel(array('hasOne' => array(
        'ContentDescription' => array(
            'className' => 'ContentDescription',
            'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
        )
    )
    )
);

$categories = $this->Content->find('threaded', array('conditions' => array('Content.content_type_id' => 1)));

$return = array();

foreach ($categories as $category) {
    $return[] = array('id' => $category['Content']['id'], 'name' => $category['ContentDescription']['name']);
}

$categories = $return;
//--- Конец ----

//Выводим в форму
foreach ($categories as $category) {
    echo $this->Form->input('paymaster.vat_category_'.$category['id'], array(
        'label' => __('Ставка НДС для товаров группы '.$category['name']),
        'type' => 'select',
        'options' => array(
            'vat18' => 'НДС 18%',
            'vat10' => 'НДС 10%',
            'vat118' => 'НДС по формуле 18/118',
            'vat110' => 'НДС по формуле 10/110',
            'vat0' => 'НДС 0%',
            'no_vat' => 'Без НДС',
        ),
        'selected' => isset($data['PaymentMethodValue'][$i]['value']) ? $data['PaymentMethodValue'][$i]['value'] : "",
    ));
    $i++;
}

?>
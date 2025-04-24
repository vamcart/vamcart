<?php
App::uses('PaymentAppController', 'Payment.Controller');

class PaymasterController extends PaymentAppController
{
    public $uses = array('PaymentMethod', 'Order');
    public $module_name = 'Paymaster';
    public $icon = 'paymaster.png';

    /**
     * Сеттер
     */
    public function settings()
    {
        $this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
    }

    /**
     * Инсталятор
     */
    public function install()
    {
        $new_module = array();
        $new_module['PaymentMethod']['active'] = '1';
        $new_module['PaymentMethod']['default'] = '0';
        $new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
        $new_module['PaymentMethod']['icon'] = $this->icon;
        $new_module['PaymentMethod']['alias'] = $this->module_name;

        $i = 0;

        $new_module['PaymentMethodValue'][$i]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][$i]['key'] = 'merchant_id';
        $new_module['PaymentMethodValue'][$i]['value'] = '';
        $i++;

        $new_module['PaymentMethodValue'][$i]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][$i]['key'] = 'secret_key';
        $new_module['PaymentMethodValue'][$i]['value'] = '';
        $i++;

        $new_module['PaymentMethodValue'][$i]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][$i]['key'] = 'sign_method';
        $new_module['PaymentMethodValue'][$i]['value'] = 'md5';
        $i++;

        $new_module['PaymentMethodValue'][$i]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][$i]['key'] = 'vat_delivery';
        $new_module['PaymentMethodValue'][$i]['value'] = '';
        $i++;

        $categories = $this->getAllCategories();

        foreach ($categories as $category) {
            $new_module['PaymentMethodValue'][$i]['payment_method_id'] = $this->PaymentMethod->id;
            $new_module['PaymentMethodValue'][$i]['key'] = 'vat_category_' . $category['id'];
            $new_module['PaymentMethodValue'][$i]['value'] = '';
            $i++;
        }

        $this->PaymentMethod->saveAll($new_module);

        $this->Session->setFlash(__('Module Installed'));
        $this->redirect('/payment_methods/admin/');
    }

    /**
     * Деисталятор
     */
    public function uninstall()
    {
        $module_id = $this->PaymentMethod->findByAlias($this->module_name);

        $this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);

        $this->Session->setFlash(__('Module Uninstalled'));
        $this->redirect('/payment_methods/admin/');
    }

    /**
     * Формируем форму
     * @return string
     */
    public function before_process()
    {
        $order = $this->Order->read(null, $_SESSION['Customer']['order_id']);
        $payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

        $merchant_id_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'merchant_id')));
        $merchant_id = $merchant_id_settings['PaymentMethodValue']['value'];

        $paymaster_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
        $secret_key = $paymaster_data['PaymentMethodValue']['value'];

        $sign_method_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'sign_method')));
        $sign_method = $sign_method_settings['PaymentMethodValue']['value'];

        $fields = array(
            'LMI_PAYMENT_AMOUNT' => $order['Order']['total'],
            'LMI_PAYMENT_DESC' => "Оплата счета N " . $order['Order']['id'],
            'LMI_PAYMENT_NO' => $order['Order']['id'],
            'LMI_MERCHANT_ID' => $merchant_id,
            'LMI_CURRENCY' => $_SESSION['Customer']['currency_code'],
            'LMI_PAYMENT_NOTIFICATION_URL' => (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE . '/payment/paymaster/result/',
            'LMI_SUCCESS_URL' => (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE . '/orders/place_order/',
            'LMI_FAILURE_URL' => (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . BASE . '/orders/place_order/',
            'SIGN' => base64_encode(hash($sign_method, $order['Order']['total'] . $order['Order']['id'] . $secret_key, TRUE)),
        );

        App::import('Model', 'Content');
        $this->Content = new Content();

        //Добавляем продукты в форму
        foreach ($order['OrderProduct'] as $key => $product) {
            $fields["LMI_SHOPPINGCART.ITEM[{$key}].NAME"] = $product['name'];
            $fields["LMI_SHOPPINGCART.ITEM[{$key}].QTY"] = $product['quantity'];
            $fields["LMI_SHOPPINGCART.ITEM[{$key}].PRICE"] = number_format($product['price'], 2, '.', '');

            $category_id = $this->Content->find('first', array('conditions' => array('Content.id' => $product['content_id'])))['Content']['parent_id'];

            $vat_category_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'vat_category_' . $category_id)));
            $vat_category = $vat_category_settings['PaymentMethodValue']['value'];

            $fields["LMI_SHOPPINGCART.ITEM[{$key}].TAX"] = $vat_category;
        }

        //Добавляем доставку в форму
        $key++;
        if ($order['Order']['shipping'] > 0) {
            $fields["LMI_SHOPPINGCART.ITEM[{$key}].NAME"] = 'Доставка заказа №' . $order['Order']['id'];
            $fields["LMI_SHOPPINGCART.ITEM[{$key}].QTY"] = 1;
            $fields["LMI_SHOPPINGCART.ITEM[{$key}].PRICE"] = number_format($order['Order']['shipping'], 2, '.', '');
            $vat_delivery_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'vat_delivery')));
            $vat_delivery = $vat_delivery_settings['PaymentMethodValue']['value'];
            $fields["LMI_SHOPPINGCART.ITEM[{$key}].TAX"] = $vat_delivery;
        }


        $form = '
    <form method="POST" action="https://paymaster.ru/Payment/Init">' . PHP_EOL;
        foreach ($fields as $key => $value) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . $value . '">' . PHP_EOL;
        }
        $form .= '<button class="btn btn-default" type="submit" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</button></form>';

        foreach ($_POST AS $key => $value)
            $order['Order'][$key] = $value;

        $default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
        $order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

        $this->Order->save($order);

        return $form;
    }


    /**
     * Пустая функция, но оставлено как hook
     */
    public function after_process()
    {
    }

    /**
     * Проверка результата оплаты
     */
    public function result()
    {
        $this->layout = false;

        $paymaster_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
        $secret_key = $paymaster_data['PaymentMethodValue']['value'];

        $sign_method_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'sign_method')));
        $sign_method = $sign_method_settings['PaymentMethodValue']['value'];


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["LMI_PREREQUEST"] == "1" || $_POST["LMI_PREREQUEST"] == "2") {
                echo "YES";
                die;
            } else {
                $hash = base64_encode(hash($sign_method, $_POST["LMI_MERCHANT_ID"] . ";" . $_POST["LMI_PAYMENT_NO"] . ";" . $_POST["LMI_SYS_PAYMENT_ID"] . ";" . $_POST["LMI_SYS_PAYMENT_DATE"] . ";" . $_POST["LMI_PAYMENT_AMOUNT"] . ";" . $_POST["LMI_CURRENCY"] . ";" . $_POST["LMI_PAID_AMOUNT"] . ";" . $_POST["LMI_PAID_CURRENCY"] . ";" . $_POST["LMI_PAYMENT_SYSTEM"] . ";" . $_POST["LMI_SIM_MODE"] . ";" . $secret_key, TRUE));

                if ($_POST["LMI_HASH"] == $hash && $_POST["SIGN"] == base64_encode(hash($sign_method, $_POST["LMI_PAYMENT_AMOUNT"] . $_POST['LMI_PAYMENT_NO'] . $secret_key, TRUE))) {
                    $payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
                    $order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['LMI_PAYMENT_NO'])));
                    $order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];

                    $this->Order->save($order_data);
                }
            }
        }
    }

    /**
     * Получение всех категорий каталога
     * @return array
     */
    public function getAllCategories()
    {

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

        return $return;

    }

}


?>
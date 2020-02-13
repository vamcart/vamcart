<?php

require_once 'TinkoffMerchantAPI.php';

App::uses('PaymentAppController', 'Payment.Controller');

class TinkoffController extends PaymentAppController
{
    public $uses = ['PaymentMethod', 'Order'];
    public $module_name = 'Tinkoff';
    public $icon = 'tinkoff.png';

    public function settings()
    {
        $this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
    }

    public function install()
    {
        $new_module = array();
        $new_module['PaymentMethod']['active'] = '1';
        $new_module['PaymentMethod']['default'] = '0';
        $new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
        $new_module['PaymentMethod']['icon'] = $this->icon;
        $new_module['PaymentMethod']['alias'] = $this->module_name;

        $new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][0]['key'] = 'terminal_key';
        $new_module['PaymentMethodValue'][0]['value'] = '';

        $new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][1]['key'] = 'password';
        $new_module['PaymentMethodValue'][1]['value'] = '';

        $new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][2]['key'] = 'payment_enabled';
        $new_module['PaymentMethodValue'][2]['value'] = '';

        $new_module['PaymentMethodValue'][3]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][3]['key'] = 'email_company';
        $new_module['PaymentMethodValue'][3]['value'] = '';

        $new_module['PaymentMethodValue'][4]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][4]['key'] = 'payment_taxation';
        $new_module['PaymentMethodValue'][4]['value'] = '';

        $new_module['PaymentMethodValue'][5]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][5]['key'] = 'payment_method';
        $new_module['PaymentMethodValue'][5]['value'] = '';

        $new_module['PaymentMethodValue'][6]['payment_method_id'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][6]['key'] = 'payment_object';
        $new_module['PaymentMethodValue'][6]['value'] = '';

        $new_module['PaymentMethodValue'][7]['payment_shipping'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][7]['key'] = 'payment_shipping';
        $new_module['PaymentMethodValue'][7]['value'] = '';

        $new_module['PaymentMethodValue'][8]['payment_tax'] = $this->PaymentMethod->id;
        $new_module['PaymentMethodValue'][8]['key'] = 'payment_tax';
        $new_module['PaymentMethodValue'][8]['value'] = '';

        $this->PaymentMethod->saveAll($new_module);

        $this->Session->setFlash(__('Module Installed'));
        $this->redirect('/payment_methods/admin/');
    }

    public function uninstall()
    {

        $module_id = $this->PaymentMethod->findByAlias($this->module_name);

        $this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);

        $this->Session->setFlash(__('Module Uninstalled'));
        $this->redirect('/payment_methods/admin/');
    }

    public function before_process()
    {

        global $config;

        $order = $this->Order->read(null, $_SESSION['Customer']['order_id']);

        $payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

        $terminalKeyQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'terminal_key')));
        $terminalKey = $terminalKeyQuery['PaymentMethodValue']['value'];

        $passwordQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'password')));
        $password = $passwordQuery['PaymentMethodValue']['value'];

        $paymentEnabledQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_enabled')));
        $paymentEnabled = $paymentEnabledQuery['PaymentMethodValue']['value'];

        $emailCompanyQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'email_company')));
        $emailCompany = $emailCompanyQuery['PaymentMethodValue']['value'];

        $paymentTaxationQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_taxation')));
        $taxation = $paymentTaxationQuery['PaymentMethodValue']['value'];

        $paymentMethodQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_method')));
        $paymentMethod = $paymentMethodQuery['PaymentMethodValue']['value'];

        $paymentObjectQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_object')));
        $paymentObject = $paymentMethodQuery['PaymentMethodValue']['value'];

        $taxShippingQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_shipping')));
        $taxShipping = $taxShippingQuery['PaymentMethodValue']['value'];

        $taxProducQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_tax')));
        $taxProduct = $taxProducQuery['PaymentMethodValue']['value'];

        $orderId = $order['Order']['id'];
        $orderEmail = $order['Order']['email'];
        $items = [];
        $orderAmount = 0;
        foreach ($order['OrderProduct'] as $product) {
            $quantity = $product['quantity'];
            $tax = round($product['tax']);
            $taxItem = $tax * 100;
            $price = round($product['price'] * 100) + $taxItem;
            $amount = $price * $quantity;

            $item = [
                'Name'          => mb_substr($product['name'], 0, 64),
                'Price'         => $price,
                'Quantity'      => $product['quantity'],
                'Amount'        => $amount,
                'PaymentMethod' => trim($paymentMethod),
                'PaymentObject' => trim($paymentObject),
                'Tax'           => $taxProduct,
            ];
            $orderAmount += $amount;
            array_push($items, $item);
        }

        if ($order['Order']['shipping'] > 0) {
            $price = round($order['Order']['shipping']) * 100;
            $item = [
                'Name'          => mb_substr('Доставка - ' . __($order['ShippingMethod']['name']), 0, 64),
                'Price'         => $price,
                'Quantity'      => 1,
                'Amount'        => $price,
                'PaymentMethod' => trim($paymentMethod),
                'PaymentObject' => 'service',
                'Tax'           => $taxShipping,
            ];
            $orderAmount += $price;
            $isShipping = true;
            array_push($items, $item);
        }

        $emailCompany = mb_substr($emailCompany, 0, 64);
        if (!$emailCompany) {
            $emailCompany = null;
        }

        $arrFields = [
            'EmailCompany' => $emailCompany,
            'Email'        => $order['Order']['email'],
            'Taxation'     => $taxation,
            'Items'        => $items,
        ];

        if ($paymentEnabled == 'yes') {
            $requestParams = [
                'TerminalKey' => $terminalKey,
                'Amount'      => $orderAmount,
                'OrderId'     => $orderId,
                'DATA'        => ['Email' => $orderEmail, 'Connection_type' => 'VamShop 2.x'],
                'Receipt'     => $arrFields,
            ];
        } else {
            $requestParams = [
                'TerminalKey' => $terminalKey,
                'Amount'      => $orderAmount,
                'OrderId'     => $orderId,
                'DATA'        => ['Email' => $orderEmail, 'Connection_type' => 'VamShop 2.x'],
            ];
        }

        $requestParams['Receipt'] = $arrFields;
        $tinkoffModel = new TinkoffMerchantAPI($terminalKey, $password);
        $request = $tinkoffModel->buildQuery('Init', $requestParams);
        $this->logs($requestParams, $request);
        $result = json_decode($request);

        if ($result->ErrorCode == 8) {
            die($result->Details);
        }
        $content = '<form action="' . $result->PaymentURL . '" method="get">';
        $content .= '
			<button class="btn btn-default" type="submit" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</button>
			</form>';

        // Save the order

        foreach ($_POST AS $key => $value)
            $order['Order'][$key] = $value;

        // Get the default order status
        $defaultStatus = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
        $order['Order']['order_status_id'] = $defaultStatus['OrderStatus']['id'];

        // Save the order
        $this->Order->save($order);

        return $content;
    }

    public function after_process()
    {
    }

    public function payment_after($order_id = 0)
    {
        global $config;

        if (empty($order_id))
            return;

        $order = $this->Order->read(null, $order_id);

        $payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

        $terminalKeyQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'terminal_key')));
        $terminalKey = $terminalKeyQuery['PaymentMethodValue']['value'];

        $passwordQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'password')));
        $password = $passwordQuery['PaymentMethodValue']['value'];

        $paymentEnabledQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_enabled')));
        $paymentEnabled = $paymentEnabledQuery['PaymentMethodValue']['value'];

        $emailCompanyQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'email_company')));
        $emailCompany = $emailCompanyQuery['PaymentMethodValue']['value'];

        $paymentTaxationQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_taxation')));
        $taxation = $paymentTaxationQuery['PaymentMethodValue']['value'];

        $paymentMethodQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_method')));
        $paymentMethod = $paymentMethodQuery['PaymentMethodValue']['value'];

        $paymentObjectQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_object')));
        $paymentObject = $paymentMethodQuery['PaymentMethodValue']['value'];

        $taxShippingQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_shipping')));
        $taxShipping = $taxShippingQuery['PaymentMethodValue']['value'];

        $taxProducQuery = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_tax')));
        $taxProduct = $taxProducQuery['PaymentMethodValue']['value'];

        $orderAmount = round($order['Order']['total']) * 100;
        $orderId = $order['Order']['id'];
        $orderEmail = $order['Order']['email'];

        $items = [];

        foreach ($order['OrderProduct'] as $product) {
            $quantity = $product['quantity'];
            $tax = round($product['tax']);
            $taxItem = $tax * 100;
            $price = round($product['price'] * 100) + $taxItem;
            $amount = $price * $quantity;
            $item = [
                'Name'          => mb_substr($product['name'], 0, 64),
                'Price'         => $price,
                'Quantity'      => $product['quantity'],
                'Amount'        => $amount,
                'PaymentMethod' => trim($paymentMethod),
                'PaymentObject' => trim($paymentObject),
                'Tax'           => $taxProduct,
            ];
            array_push($items, $item);
        }

        if ($order['Order']['shipping'] > 0) {
            $price = round($order['Order']['shipping'] * 100);
            $item = [
                'Name'          => mb_substr('Доставка - ' . __($order['ShippingMethod']['name']), 0, 64),
                'Price'         => $price,
                'Quantity'      => 1,
                'Amount'        => $price,
                'PaymentMethod' => trim($paymentMethod),
                'PaymentObject' => 'service',
                'Tax'           => $taxShipping,
            ];
            array_push($items, $item);
        }
        $emailCompany = mb_substr($emailCompany, 0, 64);
        if (!$emailCompany) {
            $emailCompany = null;
        }

        $arrFields = [
            'EmailCompany' => $emailCompany,
            'Email'        => $order['Order']['email'],
            'Taxation'     => $taxation,
            'Items'        => $items,
        ];

        if ($paymentEnabled == 'yes') {
            $requestParams = [
                'TerminalKey' => $terminalKey,
                'Amount'      => $orderAmount,
                'OrderId'     => $orderId,
                'DATA'        => ['Email' => $orderEmail, 'Connection_type' => 'VamShop 2.x'],
                'Receipt'     => $arrFields,
            ];
        } else {
            $requestParams = [
                'TerminalKey' => $terminalKey,
                'Amount'      => $orderAmount,
                'OrderId'     => $orderId,
                'DATA'        => ['Email' => $orderEmail, 'Connection_type' => 'VamShop 2.x'],
            ];
        }

        $requestParams['Receipt'] = $arrFields;
        $tinkoffModel = new TinkoffMerchantAPI($terminalKey, $password);
        $request = $tinkoffModel->buildQuery('Init', $requestParams);
        $this->logs($requestParams, $request);
        $result = json_decode($request);

        if ($result->ErrorCode == 8) {
            die($result->Details);
        }
        $content = '<form action="' . $result->PaymentURL . '" method="get">';
        $content .= '
			<button class="btn btn-default" type="submit" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</button>
			</form>';

        return $content;
    }

    public function result()
    {
        $flow = json_decode(file_get_contents("php://input"));
        $flow->Success = $flow->Success ? 'true' : 'false';
        foreach ($flow as $key => $item) {
            $request[$key] = $item;
        }

        $tinkoff_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'password')));
        $tinkoffSecretKey = $tinkoff_data['PaymentMethodValue']['value'];

        $orderId = intval($request['OrderId']);
        $order = $this->Order->read(null, $orderId);
        $merchantSumm = $request['Amount'];
        $orderSumm = round($order['Order']['total']);

        if (!$order) {
            exit('NOTOK');
        }

        if ($this->get_tinkoff_token($request, $tinkoffSecretKey) == $request['Token']) {
            $paymentMethod = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
            $orderData = $this->Order->find('first', array('conditions' => array('Order.id' => $orderId)));
            $orderData['Order']['order_status_id'] = $paymentMethod['PaymentMethod']['order_status_id'];

            if ($request['Status'] == 'CONFIRMED') {
                $orderData['Order']['order_status_id'] = 2;
            }

            if ($request['Status'] == 'REFUNDED') {
                $orderData['Order']['order_status_id'] = 5;
            }

            if ($request['Status'] == 'REJECTED') {
                $orderData['Order']['order_status_id'] = 6;
            }
            $this->Order->save($orderData);
            exit('OK');
        } else {
            exit('NOTOK');
        }
    }

    private function logs($requestParams, $request)
    {
        // log send
        $log = '[' . date('D M d H:i:s Y', time()) . '] ';
        $log .= json_encode($requestParams, JSON_UNESCAPED_UNICODE);
        $log .= "\n";
        file_put_contents(dirname(__FILE__) . "/tinkoff.log", $log, FILE_APPEND);

        $log = '[' . date('D M d H:i:s Y', time()) . '] ';
        $log .= $request;
        $log .= "\n";
        file_put_contents(dirname(__FILE__) . "/tinkoff.log", $log, FILE_APPEND);
    }

    public function get_tinkoff_token($request, $tinkoffSecretKey)
    {
        $request['Password'] = $tinkoffSecretKey;
        ksort($request);
        unset($request['Token']);
        $values = implode('', array_values($request));
        return hash('sha256', $values);
    }
}

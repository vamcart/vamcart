<?php

App::uses('PaymentAppController', 'Payment.Controller');

class WebbankirController extends PaymentAppController
{
    /**
     * @var array
     */
    public $uses = [
        'PaymentMethod',
        'Module',
        'Order',
        'OrderProduct',
        'OrderStatusDescription',
        'ModuleWebbankirSetting',
    ];

    /**
     * @var string
     */
    public $module_name = 'Webbankir';

    /**
     * @var string
     */
    public $alias = 'webbankir';

    /**
     * @var array
     */
    private $settings;

    /**
     * @param $request
     * @param $response
     */
    public function __construct($request = null, $response = null)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Plugin/ModuleWebbankir/settings.php';

        try {
            foreach ($this->ModuleWebbankirSetting->find('all') as $moduleWebbankirSetting) {
                $setting = $moduleWebbankirSetting['ModuleWebbankirSetting'];
                $this->settings[$setting['code']] = $setting['value'];
            }
        } catch (MissingTableException $exception) {
            // Пропуск загрузки настроек модуля при установке
        }

        parent::__construct($request, $response);
    }

    /**
     * @return void
     */
    public function settings()
    {
        $this->redirect('/module_webbankir/admin/admin_index');
    }

    /**
     * @return void
     */
    public function install()
    {
        $oldDefault = $this->PaymentMethod->find('first', ['conditions' => ['default' => '1']]);
        $oldDefault['PaymentMethod']['default'] = '0';
        $this->PaymentMethod->save($oldDefault);

        $newModule = $this->PaymentMethod->create([
            'active' => '1',
            'default' => '1',
            'name' => Inflector::humanize($this->module_name),
            'icon' => 'webbankir.png',
            'alias' => $this->module_name,
        ]);
        $this->PaymentMethod->save($newModule);

        $newPlagin = $this->Module->create([
            'name' => __d(WEBBANKIR_MODULE, 'WEBBANKIR'),
            'alias' => $this->alias,
            'version' => MODULE_VERSION_SETTING,
            'nav_level' => '5'
        ]);

        $this->Module->save($newPlagin);

        $this->PaymentMethod->query('DROP TABLE IF EXISTS `module_webbankir_settings`');
        $this->PaymentMethod->query('CREATE TABLE `module_webbankir_settings` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(100) NOT NULL,
          `code` VARCHAR(20) NOT NULL,
          `type` VARCHAR(20) NOT NULL,
          `value` TEXT,
          PRIMARY KEY (`id`))'
        );

        $this->PaymentMethod->query("INSERT INTO `module_webbankir_settings`
		  (`name`, `code`, `type`)
		  VALUES
          ('WEBBANKIR_MERCHANT_ID', 'merchantId', 'text'),
          ('WEBBANKIR_SHOP_ID', 'shopId', 'text'),
          ('WEBBANKIR_SHOP_PASS', 'shopPass', 'text'),
          ('WEBBANKIR_SUCCESS_ORDER_STATUS', 'successStatus', 'select')"
        );

        Cache::clear();
        $this->Session->setFlash(__('Module Installed'));

        $this->redirect('/payment_methods/admin/');
    }

    /**
     * @return void
     */
    public function uninstall()
    {
        $paymentMethod = $this->PaymentMethod->findByAlias($this->module_name);
        $module = $this->Module->find('first', ['conditions' => ['alias' => $this->alias]]);

        $this->PaymentMethod->delete($paymentMethod['PaymentMethod']['id'], true);
        $this->Module->delete($module['Module']['id'], true);

        $this->PaymentMethod->query('DROP TABLE IF EXISTS `module_webbankir_settings`');

        $this->Session->setFlash(__('Module Uninstalled'));

        $this->redirect('/payment_methods/admin/');
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function before_process()
    {
        $order = $this->Order->read(null, $_SESSION['Customer']['order_id']);
        $goods = '';
        $i = 0;
        $sum = 0;

        foreach ($order['OrderProduct'] as $item) {
            $price = $item['price'];
            $sum += $price;

            for ($j = 0; $item['quantity'] > $j; $j++) {
                $goods .= '<input type="hidden" name="goods[' . $i . '][name]" value="' . $item['name'] . '">';
                $goods .= '<input type="hidden" name="goods[' . $i . '][cost]" value="' . $price . '">';
                $goods .= '<input type="hidden" name="goods[' . $i++ . '][is_returnable]" value="1">';
            }
        }

        if (0 != $order['Order']['shipping']) {
            $deliveryPrice = $order['Order']['shipping'];
            $sum += $deliveryPrice;
            $goods .= '<input type="hidden" name="goods[' . $i . '][name]" value="' . __d(WEBBANKIR_MODULE, 'WEBBANKIR_DELIVERY') . '">';
            $goods .= '<input type="hidden" name="goods[' . $i . '][cost]" value="' . $deliveryPrice . '">';
            $goods .= '<input type="hidden" name="goods[' . $i . '][is_returnable]" value="0">';
        }

        ob_end_clean();

        return '
        <form action="' . WEBBANKIR_API_URL_SETTING . '" method="POST">
            <input type="hidden" name="merchantId" value="' . $this->settings['merchantId'] . '">
            <input type="hidden" name="shopId" value="' . $this->settings['shopId'] . '">
            <input type="hidden" name="orderId" value="' . $_SESSION['Customer']['order_id'] . '">
            <input type="hidden" name="shopPass" value="' . $this->settings['shopPass'] . '">
            <input type="hidden" name="returnUrl" value="' . $this->settings['successUrl'] . '">
            <input type="hidden" name="sum" value="' . $sum . '">
            <input type="hidden" name="ownFunds" value="0">
            <input type="hidden" name="webbankirFunds" value="' . $sum . '">
            ' . $goods . '
            <button class="btn btn-default" id="submit-button" type="submit">
            ' . __d(WEBBANKIR_MODULE, 'WEBBANKIR_PAY_BUTTON') . '
            </button>
        </form>
        ';
    }

    /**
     * @return void
     *
     * @disabled
     */
    public function payment_after()
    {
        // "абстрактный" метод, не используется
    }

    /**
     * @return void
     *
     * @disabled
     */
    public function after_process()
    {
        // "абстрактный" метод, не используется
    }

    /**
     * @return void
     */
    public function result()
    {
        $callback = json_decode(file_get_contents('php://input'), true);
        $invoice = $this->Order->read(null, $callback['order_id']);

        $invoice['Order']['order_status_id'] = $this->getStatusId($this->settings['successStatus']);
        $this->Order->save($invoice);

        exit;
    }

    /**
     * @param string $statusName
     *
     * @return string
     */
    private function getStatusId($statusName)
    {
        $status = $this->OrderStatusDescription->find('first', [
            'conditions' => [
                'OrderStatusDescription.name' => $statusName,
            ],
        ]);

        return $status['OrderStatusDescription']['order_status_id'];
    }
}
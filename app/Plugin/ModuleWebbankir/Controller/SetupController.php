<?php

class SetupController extends ModuleWebbankirAppController
{
    /**
     * @var string
     */
    private $moduleName = 'Webbankir';

    /**
     * @var string
     */
    private $alias = 'webbankir';

    /**
     * @param CakeRequest | null  $request
     * @param CakeResponse | null $response
     */
    public function __construct($request = null, $response = null)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Plugin/ModuleWebbankir/settings.php';

        parent::__construct($request, $response);
    }

    /**
     * @return void
     */
    public function install()
    {
        $oldDefault = $this->PaymentMethod->find('first', array('conditions' => array('default' => '1')));
        $oldDefault['PaymentMethod']['default'] = '0';
        $this->PaymentMethod->save($oldDefault);

        $newModule = $this->PaymentMethod->create(array(
            'active' => '1',
            'default' => '1',
            'name' => Inflector::humanize($this->moduleName),
            'icon' => 'webbankir.png',
            'alias' => $this->moduleName,
        ));

        $this->PaymentMethod->save($newModule);

        $newPlugin = $this->Module->create(array(
            'name' => __d(WEBBANKIR_MODULE, 'WEBBANKIR'),
            'alias' => $this->alias,
            'version' => MODULE_VERSION_SETTING,
            'nav_level' => '5'
        ));

        $this->Module->save($newPlugin);

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
          ('WEBBANKIR_SUCCESS_URL', 'successUrl', 'text'),
          ('WEBBANKIR_SUCCESS_ORDER_STATUS', 'successStatus', 'select')"
        );

        Cache::clear();
        $this->Session->setFlash(__('Module Installed'));

        $this->redirect('/modules/admin/');
    }

    /**
     * @return void
     */
    public function uninstall()
    {
        $paymentMethod = $this->PaymentMethod->findByAlias($this->moduleName);
        $module = $this->Module->find('first', array('conditions' => array('alias' => $this->alias)));

        $this->PaymentMethod->delete($paymentMethod['PaymentMethod']['id'], true);
        $this->Module->delete($module['Module']['id'], true);

        $this->PaymentMethod->query('DROP TABLE IF EXISTS `module_rbkmoney_settings`');

        $this->Session->setFlash(__('Module Uninstalled'));

        $this->redirect('/modules/admin/');
    }
}

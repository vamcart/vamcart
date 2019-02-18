<?php

App::uses('AppController', 'Controller');

class ModuleWebbankirAppController extends AppController
{
    /**
     * @var array 
     */
    public $uses = array(
        'ModuleWebbankirSetting',
        'OrderStatusDescription',
        'PaymentMethod',
        'Module',
        'Language',
    );

    /**
     * @var array
     */
    public $components = array('ModuleBase');
}

<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class ToolsController extends AppController {
    public $name = 'Tools';
    public $uses = null;

    /**
    * Sypex Dumper database backup/restore tool.
    *
    */
    public function admin_backup($ajax_request = false)
    {
        $this->set('current_crumb', __('Database Manager', true));
        $this->set('title_for_layout', __('Database Backup', true));
        $l = $this->Session->read('Config.language');
        if (NULL == $l) {
            $l = $this->Session->read('Customer.language');
        }
        $this->set('lang', $l);
    }

}

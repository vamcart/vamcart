<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
class ToolsController extends AppController {
    var $name = 'Tools';
    var $uses = null;

    /**
    * Sypex Dumper database backup/restore tool.
    *
    */
    function admin_backup($ajax_request = false)
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

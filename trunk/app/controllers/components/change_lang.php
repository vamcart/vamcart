<?php 
class ChangeLangComponent extends Object {
    var $components = array('Session', 'Cookie');

    function startup() {
        if (!$this->Session->check('Config.language')) {
            $this->change(($this->Cookie->read('lang') ? $this->Cookie->read('lang') : Configure::read('Config.language')));
        }
    }

    function change($lang = null) {
        if (!empty($lang)) {
            $this->Session->write('Config.language', $lang);
            $this->Cookie->write('lang', $lang, null, '+350 day'); 
        }
    }
}
?> 
<?php 
class ChangeLangController extends AppController {
    var $name = 'ChangeLang';
    var $uses = null;
    var $components = array('ChangeLang');

    function change($lang = null) {
        $this->ChangeLang->change($lang);

        $this->redirect($this->referer(null, true));
    }

    function shuntRequest() {
        $this->ChangeLang->change($this->params['lang']);

        $args = func_get_args();
        $this->redirect("/" . implode("/", $args));
    }
}
?> 
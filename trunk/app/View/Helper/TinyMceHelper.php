<?php
/***********************************************************************
 *
 * Quick TinyMCE Helper for CakePHP
 * Author: C.James Callaway (http://www.cybergod.net) - 08/04/2008
 */
 App::uses('AppHelper', 'View');
class TinyMceHelper extends Helper {
	public $helpers=array('Html', 'Session');
	
	public function beforeRender(){
	}
	public function init($options=false){
	$code = '';
	$code .= $this->Html->script('tinymce/tinymce.min.js', false);
	if($options){
	$code .= $this->Html->scriptBlock('
		tinyMCE.init(
		'.json_encode($options).'
		);    
	', array('allowCache'=> false,'safe'=> false,'inline'=> false));
		} else {
	$code .= $this->Html->scriptBlock('
				tinymce.init({
					selector: "textarea.pagesmalltextarea",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen",
						"insertdatetime media table contextmenu paste"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
					autosave_ask_before_unload: false,
					max_height: 200,
					min_height: 160,
					height : 180,
					'.('ru' == $this->Session->read('Customer.language') ? 'language : "ru"' : '').'
				});
 	
		function toggleHTMLEditor(id) {
			if (!tinyMCE.get(id))
				tinymce.execCommand("mceAddControl", false, id);
			else
				tinymce.execCommand("mceRemoveControl", false, id);
		}    	
	
	', array('allowCache'=> false,'safe'=> false,'inline'=> false));
	}    
    
	return $code;
	}
	public function toggleEditor($options){
	//$code = '<a href="javascript:toggleHTMLEditor(\''.$options.'\');">' . __('Show/Hide editor') . '</a>'; 
	return $code;
	}
}
?>
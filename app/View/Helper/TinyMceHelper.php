<?php
/***********************************************************************
 *
 * Quick TinyMCE Helper for CakePHP
 * Author: C.James Callaway (http://www.cybergod.net) - 08/04/2008
 */
 App::uses('AppHelper', 'View');
class TinyMceHelper extends Helper {
	public $helpers=array('Html', 'Session');
	
	public function beforeRender($viewFile = ''){
	}
	public function init($options=false){
	$code = '';
	$code .= $this->Html->script('tinymce/tinymce.min.js', false);
	if($options){
	$code .= $this->Html->scriptBlock('
		tinymce.init(
		'.json_encode($options).'
		);    
	', array('allowCache'=> false,'safe'=> false,'inline'=> false));
		} else {
	$code .= $this->Html->scriptBlock('
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.BASE.'/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.BASE.'/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-responsive", value: "img-responsive"}
  ],		  
  '.('ru' == $this->Session->read('Customer.language') ? 'language : "ru"' : '').',
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});
 	
		function toggleHTMLEditor(id) {
			if (!tinymce.get(id))
				tinymce.execCommand("mceAddEditor", false, id);
			else
				tinymce.execCommand("mceRemoveEditor", false, id);
		}    	
	
	', array('allowCache'=> false,'safe'=> false,'inline'=> false));
	}    
    
	return $code;
	}
	public function toggleEditor($options){
	$code = '';
	//$code = '<a href="javascript:toggleHTMLEditor(\''.$options.'\');">' . __('Show/Hide editor') . '</a>'; 
	return $code;
	}
}
?>
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
					selector: "textarea.pagesmalltextarea",
					plugins: [
					    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
					    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media responsivefilemanager nonbreaking",
					    "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
					  ],
					toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
					toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
					toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",
					menubar: false,
					toolbar_items_size: "small",    
					image_advtab: true ,
					external_filemanager_path: "'.BASE.'/filemanager/",
					filemanager_title:"VamShop" ,
					filemanager_access_key:"'. session_name() .'" ,
					external_plugins: { "filemanager" : "'.BASE.'/filemanager/plugin.min.js"},
					autosave_ask_before_unload: false,
					max_height: 200,
					forced_root_block : false,
					min_height: 160,
					height : 180,
					convert_urls : false,
					'.('ru' == $this->Session->read('Customer.language') ? 'language : "ru"' : '').'
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
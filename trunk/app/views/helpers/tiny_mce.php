<?php
/***********************************************************************
 *
 * Quick TinyMCE Helper for CakePHP
 * Author: C.James Callaway (http://www.cybergod.net) - 08/04/2008
 */
class TinyMceHelper extends Helper {
	var $helpers=array('Javascript', 'Session');
	
	function beforeRender(){
	}
	function init($options=false){
	$code = '';
	$code .= $this->Javascript->link('tiny_mce/tiny_mce', false);
	$code .= $this->Javascript->link('tiny_mce/plugins/tinybrowser/tb_tinymce.js.php', false);
	if($options){
	$code .= $this->Javascript->codeBlock('
		tinyMCE.init(
		'.json_encode($options).'
		);    
	', array('allowCache'=> false,'safe'=> false,'inline'=> false));
		} else {
	$code .= $this->Javascript->codeBlock('

		tinyMCE.init({
			mode : "none",
			editor_deselector : "notinymce",
			theme : "advanced",
			language : "'.$this->Session->read('Customer.language').'",
			paste_create_paragraphs : false,
			paste_create_linebreaks : false,
			paste_use_dialog : true,
			convert_urls : false,
		
			plugins : "safari,typograf,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
		
			file_browser_callback : "tinyBrowser",
		
			spellchecker_languages : "+Russian=ru,English=en",
			spellchecker_rpc_url : "'.BASE.'/js/tiny_mce/plugins/spellchecker/rpc_proxy.php",
		
			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,typograf,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true
		
		});
	
		function toggleHTMLEditor(id) {
			if (!tinyMCE.get(id))
				tinyMCE.execCommand("mceAddControl", false, id);
			else
				tinyMCE.execCommand("mceRemoveControl", false, id);
		}    
	
	', array('allowCache'=> false,'safe'=> false,'inline'=> false));
	}    
    
	return $code;
	}
	function toggleEditor($options){
	$code = '<a href="javascript:toggleHTMLEditor(\''.$options.'\');">' . __('Show/Hide editor', true) . '</a>'; 
	return $code;
	}
}
?>
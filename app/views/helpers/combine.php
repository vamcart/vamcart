<?php
//app/views/helpers/combine.php
class CombineHelper extends AppHelper
{
	public $helpers = array('Html', 'Javascript');

	private $_pattern = '../combine.php?type=:type&files=:files';

	public function js($files)
	{
		echo $this->Javascript->link($this->_format($files));
	}

	public function css($files)
	{
		echo $this->Html->css($this->_format($files, 'css'));
	}

	private function _format($files = array(), $type = 'javascript')
	{
		return String::insert($this->_pattern, array('type' => $type, 'files' => implode(',', $files)));
	}
}

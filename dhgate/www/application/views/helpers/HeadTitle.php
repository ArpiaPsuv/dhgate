<?php
class Zend_View_Helper_HeadTitle {
	public $view;
	public function headTitle() {
		$settings  = new Settings(); 
		return $settings->getField('title');
	}
	
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

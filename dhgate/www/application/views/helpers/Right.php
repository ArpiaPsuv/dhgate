<?php

class Zend_View_Helper_Right {
	public $view;
	public function right() {
		$settings = new Settings;
		return $settings->getField('payment');
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

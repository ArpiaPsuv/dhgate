<?php
class Zend_View_Helper_Left {
	public function left() {
		$settings = new Settings();
		return $settings->getField('buy');
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

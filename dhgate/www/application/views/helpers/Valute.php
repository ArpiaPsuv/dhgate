<?php
class Zend_View_Helper_Valute {
	public $view;
	public function valute($price,$prefix = 1, $class = 0) {
	
		$valutes = new Valute();
		$html = $valutes->conversion($price,$prefix,$class);
		return $html;
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

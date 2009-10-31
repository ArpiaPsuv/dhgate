<?php
class Zend_View_Helper_Valute {
	public $view;
	public function valute($price, $class = null) {
		if(key_exists('valute', $_COOKIE)){
			$valute = $_COOKIE['valute'];
		} else {
			$valute = 'usd';
		}
		if($valute == 'usd')
		{
			$price = $price;
			$index = 'USD';
		}
		$settings = new Settings();
		if($valute == 'eur'){
			$price =  round($price * $settings->getValute($valute));
			$index = 'EUR';
		}

		if($valute == 'gbp')
		{
			$price =  round($price * $settings->getValute($valute));
			$index = 'GBP';
		}
		if($class)
		{
			return "<span class='$class'>$price</span> $index";
		} else {
			return "$price $index";
		}
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

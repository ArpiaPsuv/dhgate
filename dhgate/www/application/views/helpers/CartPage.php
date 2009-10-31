<?php
class Zend_View_Helper_CartPage
{
	public $view;
	public function cartPage() {

		$cart = new Cart();
		if(Zend_Auth::getInstance()->hasIdentity()){
			$info  = $cart->getInfo(Zend_Auth::getInstance()->getIdentity()->id);
		} else {
			$info = $cart->getInfo();
		}
		$html = "<div class='product_in_cart'>{$info['count']} X <a href>Product in cart</a>
				<div class='cart_price'>$ {$info['price']}</div>
				<div class='clear'></div>
				<div class='cart_line'></div>
				<div class='outcome'>{$info['count']} Products <span>$ {$info['price']}</span></div>
			</div>";
		return $html;
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

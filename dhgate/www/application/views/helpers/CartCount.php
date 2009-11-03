<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * CartCount helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_CartCount {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function cartCount() {
		// TODO Auto-generated Zend_View_Helper_CartCount::cartCount() helper 
		$cart = new Cart();
		return $cart->getCount();
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

<?php
/**
 *
 * @author max
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * SearchCategory helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_SearchCategory {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function searchCategory() {
		// TODO Auto-generated Zend_View_Helper_SearchCategory::searchCategory() helper 
		return null;///Должна вернуть html
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

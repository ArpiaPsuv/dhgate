<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * ImageMain helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_ImageMain {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function imageMain($id) {
		// TODO Auto-generated Zend_View_Helper_imageSmall::imageSmall() helper 
		
		$album = new App_Album_Product($id);
		$image = $album->getMainImage('m');
		if(!$image){
			$image="/application/public/img/product.gif";
		}
		
		
		
		return $image;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

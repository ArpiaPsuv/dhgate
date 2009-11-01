<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * MoveProduct helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_MoveProduct {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function moveProduct($product_id) {
		
		$form = new App_Form_MoveCategory();
		$form->setAction('/product/move/');
		$form->getElement('to')->setName('category_id');
		$form->getElement('from')->setName('product_id')->setValue($product_id);
		
		
		$catalogTable = new Catalog();
		$categories = $catalogTable->fetchAll();
	
		$keys=array();
		$values=array();
		
		array_push($keys,0);
		array_push($values,'Select category');
		
		foreach($categories as $row)
		{
			array_push($keys,$row->id);
			array_push($values,$row->title);
		}
		
		$options= array_combine($keys,$values);
		$form->getElement('to')->setmultiOptions($options);
		
		return $form;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

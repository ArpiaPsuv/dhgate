<?php
/**
 *
 * @author viknet
 * @version
 */
require_once 'Zend/View/Interface.php';

/**
 * FormAddCategory helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_FormAddCategory {

	/**
	 * @var Zend_View_Interface
	 */
	public $view;

	/**
	 *
	 */
	public function formAddCategory($parent_id = 0) {
		// TODO Auto-generated Zend_View_Helper_FormAddCategory::formAddCategory() helper
		$form= new App_Form_AddCategory();
		$form->getElement('parent_id')->setValue($parent_id);
//		$form->getElement('title')->setLabel('Category');
//		$form->getElement('coef')->setLabel('Coef');
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

<?php
/**
 *
 * @author viknet
 * @version
 */
require_once 'Zend/View/Interface.php';

/**
 * formMoveCategory helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_formMoveCategory {

	/**
	 * @var Zend_View_Interface
	 */
	public $view;

	/**
	 *
	 */
	public function formMoveCategory($id) {
		// TODO Auto-generated Zend_View_Helper_formMoveCategory::formMoveCategory() helper

		$catalogTable = new Catalog();
		$categorys= $catalogTable->fetchAll();
		$form= new App_Form_MoveCategory();


		$options= array();
		$keys=array();
		$values=array();
		$currentCategory= $catalogTable->getCurrent($id);
		$count=0;

		if($currentCategory->level){
			$count++;
			array_push($keys,0);
			array_push($values,'ROOT');
			foreach ($categorys as $category) {
				if((!$category->level) and ($category->id != $currentCategory->parent)){
					array_push($keys,$category->id);
					array_push($values,$category->title);
					$count++;
				}
			}

		}else{
			if(!$catalogTable->hasChildren($id)){
					
					
				foreach ($categorys as $category) {
					if((!$category->level) and ($category->id != $currentCategory->id)){
						array_push($keys,$category->id);
						array_push($values,$category->title);
						$count++;
					}
				}
			}
		}

		if($count>0){
			$options= array_combine($keys,$values);
			$form->getElement('to')->setmultiOptions($options);
			$form->getElement('from')->setValue($id);
			return $form;
		}else{
			return  null;
		}

	

		
	}

	/**
	 * Sets the view field
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

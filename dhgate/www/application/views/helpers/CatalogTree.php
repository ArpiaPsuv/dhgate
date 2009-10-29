<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * CatalogTree helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_CatalogTree {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function catalogTree() {
		// TODO Auto-generated Zend_View_Helper_CatalogTree::catalogTree() helper 
		
		$catalog= new Catalog();
		$level_0 = $catalog->getallLevel(0);
		$level_1= $catalog->getallLevel(1);
		
		$tree='';
		foreach ($level_0 as $parent) {
			
			$tree.='<a href="/catalog/category/id/'.$parent->id.'/"><h3>'.$parent->title.'</h3></a>';
			$tree.='<blockquote>';
			foreach ($level_1 as $child) {
				if($child->parent == $parent->id){
					$tree.='<p>&nbsp;&nbsp;&nbsp;<a href="/catalog/category/id/'.$child->id.'/">|___'.$child->title.'</p></a>';
				}	
			}
			$tree.='</blockquote>';	
		}
		
		$tree.='';

		return $tree;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

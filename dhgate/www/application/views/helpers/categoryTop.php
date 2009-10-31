<?php
/**
 *
 * @author Konovalov Maxim aka ZloY max.zloy@gmail.com
 *
 */
class Zend_View_Helper_categoryTop {
	public $view;
	public function categoryTop() {
		$category = new Catalog();

		$html='<div id="all_categories_ules">';
		foreach($category->fetchAll() as $category){
			$html.='<a href="/catalog/category/id/'.$category->id.'">'.$category->title.'</a>';
		}
		$html.='</div>';
		return $html;
	}
	public function setView(Zend_View_Interface $view) {

		$this->view = $view;
	}
}
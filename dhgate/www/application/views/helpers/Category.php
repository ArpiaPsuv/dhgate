<?php
class Zend_View_Helper_Category {

	public $view;

	public function category($category) {
		if($category->parent == 0){
			$html  = '<a href="#">'.$category->title.'<img class="arrows" src="/application/public/img/arrows-ffffff.gif"></a>';
		} else {
			$html  = '
			<li class="items_title"><a href="/catalog/category/id/'.$category->id.'">'.$category->title.'</a></li>';
		}
		$html  .= '</li>';
		return $html;
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

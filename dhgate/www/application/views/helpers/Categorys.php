<?php
class Zend_View_Helper_Categorys {
	public $view;

	public function categorys() {
		$category = new Catalog();
		$categorys = $childrenCategorys = $category->fetchAll();
		$html ='';
		for($i=0;$i<count($categorys);$i++){
			if($categorys[$i]->parent == 0){
				$html .= $this->view->category($categorys[$i]);
				$html.='<ul class="right_fall_list">';
				for($j=0;$j<count($categorys);$j++){
					if($categorys[$i]->id == $categorys[$j]->parent){
						$html .= $this->view->category($categorys[$j]);
					}
				}
				$html .= '</ul>';
			}
		}

		
		return $html;
	}
	
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

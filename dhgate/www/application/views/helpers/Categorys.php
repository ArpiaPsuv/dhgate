<?php
class Zend_View_Helper_Categorys {
	public $view;

	public function categorys() {
		$category = new Catalog();
		$categorys = $childrenCategorys = $category->fetchAll();
		$html ='';
		if(count($categorys)>0){
			for($i=0;$i<count($categorys);$i++){
				if($categorys[$i]->parent == 0){
					$childrenCategorys = array();
					for($j=0;$j<count($categorys);$j++){
						if($categorys[$i]->id == $categorys[$j]->parent){
							array_push($childrenCategorys, $categorys[$j]);
						}
					}
					$html.='<li class="title_left_menu">
							 <a href="/catalog/category/id/' . $categorys[$i]->id . '/">' . $categorys[$i]->title ;
					if(count($childrenCategorys)){ 
						$html.='<img class="arrows" src="/application/public/img/arrows-ffffff.gif">';
					}
							 $html.='</a>';

					if(count($childrenCategorys)){
						$html .='<ul class="right_fall_list">';
						for($j=0;$j<count($categorys);$j++){
								
							if($categorys[$i]->id == $categorys[$j]->parent){
								$html.='<li class="items_title"><a href="/catalog/category/id/' . $categorys[$j]->id . '/">' . $categorys[$j]->title . '</a></li>';
							}
						}
						$html.='</ul>';
					}
					$html .='</li>';
				}
			}
		} else {
			$html = '<li class="title_left_menu">
						category table currently empty
					 <li>';
		}
		return $html;
	}

	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

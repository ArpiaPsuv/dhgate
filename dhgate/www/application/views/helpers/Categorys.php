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
					$html.='<li class="title_left_menu">
							 <a href="/catalog/category/id/' . $categorys[$i]->id . '/">' . $categorys[$i]->title . '<img class="arrows" src="/application/public/img/arrows-ffffff.gif"></a>
								<ul class="right_fall_list">
									';
					for($j=0;$j<count($categorys);$j++){
							
						if($categorys[$i]->id == $categorys[$j]->parent){
							$html.='<li class="items_title"><a href="/catalog/category/id/' . $categorys[$j]->id . '/">' . $categorys[$j]->title . '</a></li>';
						}
					}
					$html.='</ul>
							</li>';
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

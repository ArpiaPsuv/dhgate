<?php

class Zend_View_Helper_FormSearchInCategories {
	public $view;
	public function FormSearchInCategories() {
		$form= new App_Form_Search();
		$html="<form action=\"{$form->getAction()}\" method=\"{$form->getMethod()}\">
			<div id=\"text_search\">Search</div>"; 
		$html.=$form->getElement('text_search');
		$html.=$form->getElement('category');

		//'<input type="submit" name="Submit" id="button" value="GO" />';
		//$html.='<input type="submit" value="Go" height="100">';
		$html.="<div class=\"go_button\">{$form->getElement('go')}</div>";
		$html.='</form>';
		return $html;
	}
	public function setView(Zend_View_Interface $view) {

		$this->view = $view;
	}
}
<?php
class Zend_View_Helper_Products
{
	public $view;
	public function products($products) {
		$products->setView($this->view);
		$html="<div id='products'>";
		foreach ($products as $product){
			$html .= $this->view->product($product);
		}
		$html .= "
        <p class='paginator'>{$this->view->paginationControl($products, 'Sliding', 'my_pagination.phtml')}</p>
        </div>";
		return $html;
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

<?php
class Zend_View_Helper_Product
{
    public $view;
    public function product($product) {
        Zend_debug::dump($product);
        return "
        <div class='product'>
        	<p><a href='/product/index/id/{$product['id']}/'>{$product['title']}</a></p>
        	<p>{$product['price']}</p>
        	<p>{$product['short_about']}</p>
        </div>
        ";
        return null;
    }
    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }
}
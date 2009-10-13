<?php
class CartController extends MainController
{
    public function indexAction()
    {
        $cart = new Cart();
        if(Zend_Auth::getInstance()->hasIdentity())
        {
        	$products = $this->view->products = $cart->getProducts(Zend_Auth::getInstance()->getIdentity()->id);
        } else {
        	$products = $this->view->products = $cart->getProducts();
        }
    }
    
    public function addAction()
    { 
    	Zend_Layout::getMvcInstance()->disableLayout();
		$cart = new Cart();
		$cart->add($_POST['item_id'], $_POST['count']);
    }
    
    public function updatecountAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout();
    	$count = $this->_getParam('count', 0);
    	if($this->_request->isPost())
    	{
			$cart = new Cart();
			$cart->updateCount($_POST['product_id'], $count);
    	}
    }
    public function getinfoAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout();
    	
    }
   
}
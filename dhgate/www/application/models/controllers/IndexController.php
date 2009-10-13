<?php
class IndexController extends MainController
{
    public function indexAction()
    {
        $product = new Product();
        $this->view->products = $product->fetchAll('main = 1');
    }
    
    public function infoAction()
    {
    	$settings = new Settings();
    	$page = $this->_getParam('page',0);
    	$this->view->page = $page;
    	$about = $settings->getField($page);
    	$this->view->text = $about;
    	if($_SESSION['admin']){
	    	if($this->_request->isPost()){
	    		$settings->update(array($page => $_POST['text']), 'id = 1');
	    		$this->_redirect('/index/info/page/' . $page . '/'); 
	    	}
    	}
    }
}
?>

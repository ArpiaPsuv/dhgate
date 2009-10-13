<?php
class ProductController extends MainController
{
    public function indexAction ()
    {
        $id = (int) $this->_getParam('id',0);
        if($id<1){
            $this->_redirect('/');
        }
        $this->view->controller  = 'product';
        $productTable = new Product();
        $productRow = $this->view->product = $productTable->find($id)->current();
        $category = $productTable->getCategory($productRow->id);
        $this->view->category = $category;
        $catalogTable = new Catalog();
        $this->view->parents = $catalogTable->getParentsRecursive($category[0]['id']);
        $this->view->album = App_Album::create('product',$productRow->id);
        $this->view->allProducts = $productTable->fetchAll();
        $this->view->interested = $productTable->getInterested($productRow->id);
    }
    
    public function addAction()
    {
        $category = $this->view->category = $this->_getParam('category',0);
        if($this->_request->isPost()){
            $productTable = new Product();
            $productTable->add($_POST, $category);
            $this->_redirect('/catalog/category/id/' . $category);
        }
    }
    public function editAction()
    {
        $id = (int) $this->_getParam('id',0);
        if($id<1){
            $this->_redirect('/');
        }
        $productTable = new Product();
        $productRow = $this->view->product = $productTable->find($id)->current();
        $category = $productTable->getCategory($productRow->id);
        $this->view->category = $category;
        $catalogTable = new Catalog();
        $this->view->parents = $catalogTable->getParentsRecursive($category[0]['id']);
        if($this->_request->isPost()){
        	$filter = Zend_Registry::get('autoFilter');
        	$_POST['specifications'] = $filter->postCopy['specifications'];
            $productTable->update($_POST, 'id = ' . $id);
            $this->_redirect('/product/index/id/' . $id);
        }
    }
    
    public function deleteAction()
    {
        $id = (int) $this->_getParam('id',0);
        if($id<1){
            $this->_redirect('/');
        }
        $productTable = new Product();
        $category = $productTable->deleteProduct($id);
        $this->_redirect('/catalog/category/id/' . $category[0]['id']);
    }
    
    public function addinterestedAction()
    {
        
    }
    
    public function expressAction()
    {
    	$id = (int) $this->_getParam('id', 0);
    	$act = (int) $this->_getParam('act',0);
    	$productTable = new Product();
    	$productTable->update(array('freeexpress'=>$act), 'id = ' . $id);
    	$this->_redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function uploadAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout(); 
    	$id = (int) $this->_getParam('id',0);
    	if($this->_request->isPost()){
	    	$album = new App_Album_Product($id);
	    	$album->upload();
    	}
    	echo $this->view->images($id);
    }
    
    public function getimageAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout();
    	$id = (int) $this->_getParam('id',0);
    	$album = new App_Album_Product($id);
    	$images = $album->getImages('m');
    	$count = (int)$this->_getParam('count',0);
        $next = (int)$this->_getParam('next',0);
		if($next !=0)
		{
			$img = abs($count+$next) % (count($images));
		} else {
			$img = $count;
		} 
    	$this->view->src = $images[$img];
    }
    
    public function setmainAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout();
    	$id = (int) $this->_getParam('id',0);
    	$this->view->id = $id;
    	$album = new App_Album_Product($id);
    	$album->setMainImage($_POST['src']);
    }
    
    public function deleteimageAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout();
    	$id = (int) $this->_getParam('id',0);
    	$this->view->id = $id;
    	$album = new App_Album_Product($id);
    	$album->delete($_POST['src']);
    }
    
    public function getimagesAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout();
    	$id = (int) $this->_getParam('id', 0);
    	$this->view->id = $id;
    }
    
    public function searchAction()
    {
    	if($this->_request->isPost())
    	{
    		$product = new Product();
    		$products = $product->search($_POST['query']);
    		if($this->_getParam('count',0)){
    			$products->setItemCountPerPage($this->_getParam('count',0));
    		}
    		$this->view->products = $products;
    	}
    }
    
    public function onmainAction()
    {
    	$id = (int) $this->_getParam('id' , 0 );
    	$product = new Product();
    	$act = (int) $this->_getParam('act',0);
    	$product->update(array('main'=>$act), 'id = ' . $id);
    	$this->_redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function onleftAction()
    {
    	$id = (int) $this->_getParam('id' , 0 );
    	$product = new Product();
    	$act = (int) $this->_getParam('act',0);
    	$product->update(array('left'=>$act), 'id = ' . $id);
    	$this->_redirect($_SERVER['HTTP_REFERER']);
    }
}
<?php
class CatalogController extends MainController
{
	public function indexAction()
	{
		$this->_redirect('/catalog/view/');

	}


	
	public function categoryAction()
	{
		$id = (int)$this->_getParam('id',0);

		if($id < 1){
			$this->_redirect('/');
		}
		
		
		
		$this->view->image = (int) $this->_getParam('image',0);
		$catalogTable = new Catalog();
		$currentCategory = $this->view->currentCategory  = $catalogTable->getCurrent($id);
		$this->view->subCategories = $catalogTable->getLevel($id);
		$this->view->parent = $catalogTable->getParent($currentCategory->id);
		
		
		$formPrice= new App_Form_Price();
		$formPrice->setAction('/catalog/category/id/'.$id);
		$formPrice->setMethod('POST');
	
		
		if($this->_request->isPOST()){
			$formPrice->populate($this->_request->getPOST());
		}
		
		$sort_by=$this->_getParam('sort',0);
//		сортировка
//		1 title по возрастанию
//		2 title по убыванию
//		3 price по возрастанию
//		4 price по убыванию
		
		switch ($sort_by){
			case 1:
				$sort_by=array('title');
				$this->view->sort=1;
				break;
			case 2:
				$sort_by=array('title DESC');
				$this->view->sort=2;
				break;
			case 3:
				$sort_by=array('price');
				$this->view->sort=3;
				break;
			case 4:
				$sort_by=array('price DESC');
				$this->view->sort=4;
				break;
			default:
				$sort_by=0;
				$this->view->sort=0;
				break;
		}
		
		
	
		$products =$catalogTable->getItems($currentCategory->id, (int) $this->_getParam('page',0),
		(int) $this->_getParam('from',0),(int) $this->_getParam('to',0),$sort_by);

		$this->view->count = $count = (int)$this->_getParam('count',20);
		$products->setItemCountPerPage($count);
		
	
		$products->setView($this->view);
		$this->view->products = $products;
		$this->view->current_category_id = $currentCategory->id;
		
	
				
		$this->view->formPrice=$formPrice;
		$cart= Cart::create();
		$this->view->cart = $cart;
		
		
		
		
		
		
		if($_SESSION['admin'])
		{
			$this->view->categorys = $catalogTable->fetchAll();
		}
	}

	public function addAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
	
		 
		if($this->_request->isPost()){
			$form = new App_Form_AddCategory();
			$coef=$this->_getParam('coef',1);
			
			$_POST['coef']=str_replace('.',',',$coef) ; 
			if ($form->isValid($_POST)){
				$catalogTable = new Catalog();
				$row = $catalogTable->createChildRow((int)$this->_getParam('parent_id'), $_POST);
				$row->save();

			}
			//Zend_Debug::dump($_POST);
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function editAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		$id = (int) $this->_getParam('id',0);
		if($id < 1) {
			$this->_redirect('/');
		}
		$form=new App_Form_AddCategory();
		if ($form->isValid($_POST)){
			$catalogTable = new Catalog();
			$currentRow = $catalogTable->getCurrent($id);
			//$currentRow->title = $_POST['title'];
			$currentRow->save();
		}
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function deleteAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		$id = (int) $this->_getParam('id',0);
		if($id < 1) {
			$this->_redirect('/');
		}

		//удаляются текущая категория её подкатегории и все продукты
		$catalogTable = new Catalog();
		$connectTable = new Connect_Catalog();
		$productTable = new Product();
		$currentRow = $catalogTable->getCurrent($id);
		
		$childs = $catalogTable->getLevel($id);
		foreach ($childs as $child) {
			$products = $connectTable->fetchAll('category_id = '.$child->id);
			foreach ($products as $product){
				$productTable->deleteProduct($product->id);
			}
			$connectTable->delete('category_id = '.$child->id);
		}
		$catalogTable->delete('parent = '. $id);
		
		$products = $connectTable->fetchAll('category_id = '.$id);
		foreach ($products as $product){
			$productTable->deleteProduct($product->id);
		}
		$connectTable->delete('category_id = '.$id);
		$catalogTable->delete('id = '.$id);
		
		$parent = $currentRow->parent;
		if($parent !=0 ){
			$this->_redirect('/catalog/category/id/' . $parent);
		} else {
			$this->_redirect('/');
		}
	}

	public function moveAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		if (isset($_POST)){
			$from= $this->_getParam('from',0);
			$to = $this->_getParam('to',0);
			$catalogTable = new Catalog();
			$parentId=$catalogTable->find($from)->current()->parent;
			if (($from > 0) and ($to >= 0) ){
				Zend_Debug::dump($_POST);
				$catalogTable->moveBranch($from, $to);
			}

		}



		$this->_redirect('/catalog/category/id/'.$parentId.'/');
	}

	public function viewAction(){

	}
}
<?php
class CatalogController extends MainController
{
	public function indexAction()
	{
	
            
         
     
            
		
         	
            
		$this->_redirect('/catalog/view/');

	}
	public function searchAction()
	{
		Zend_Debug::dump($_POST);
	}
	public function categoryAction()
	{
		$id = (int)$this->_getParam('id',0);
		$form= new App_Form_AddCategory();
		$form->getElement('parent_id')->setValue($id);
		$this->view->form=$form;
		
		if($id < 1){
			$this->_redirect('/');
		}
		$this->view->image = (int) $this->_getParam('image',0);
		$catalogTable = new Catalog();
		$currentCategory = $this->view->currentCategory  = $catalogTable->getCurrent($id);
		$this->view->subCategories = $catalogTable->getLevel($id);
		$this->view->parent = $catalogTable->getParent($currentCategory->id);
		
		$products = $catalogTable->getItems($currentCategory->id, (int) $this->_getParam('page',0));
		
		
		$this->view->count = $count = (int)$this->_getParam('count',20);
		$products->setItemCountPerPage($count);
		$products->setView($this->view);
		$this->view->products = $products;
		$this->view->current_category_id = $currentCategory->id;
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
			if (!$_POST['title']==''){
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
		
		//По моему не правильная реализация удаления категории (не удаляются дочернии категории и их товары)
		$catalogTable = new Catalog();
		$currentRow = $catalogTable->getCurrent($id);
		$parent = $currentRow->parent;
		$connectTable = new Connect_Catalog();
		$connectTable->deleteItem($id);
		$currentRow->delete();
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
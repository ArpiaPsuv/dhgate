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
		
		$this->view->category_coef=$category_coef=$productTable->getParentCategoryCoef($id);
		$productRow = $this->view->product = $productTable->find($id)->current();
		$category = $productTable->getCategory($productRow->id);
		$this->view->category = $category;
		$catalogTable = new Catalog();
		
		
		$this->view->parents = $parents= $catalogTable->getParentsRecursive($category[0]['id']);
		$this->view->album = App_Album::create('product',$productRow->id);
		$this->view->allProducts = $productTable->fetchAll();
		//$this->view->interested = $productTable->getInterested($productRow->id);
		$this->view->category =$category;
		
		$album = new App_Album_Product($id);
		$image = $album->getMainImage('m');
		if(!$image){
			$image='/application/public/img/productimg.jpg';
		}
		$this->view->image = $image;
		$cart= Cart::create();
		$this->view->cart = $cart;
//	  	Zend_Debug::dump($image);
	}

	public function addAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		$id = (int) $this->_getParam('category',0);
		if($id<1){
			$this->_redirect('/');
		}
		$category = $this->view->category = $id;
		$catalogTable = new Catalog();
		
		
		$this->view->currentCategory=$currentCategory = $catalogTable->getCurrent($category);
		$this->view->parent = $catalogTable->getParent($currentCategory->id);
		
		$form= new App_Form_AddProduct();
		$form->setAction('/product/add/category/'.$category);
		

		if($this->_request->isPost()){
			if($form->isValid($this->_request->getPost())){
				$productTable = new Product();
				$productTable->add($_POST, $category);
				$this->_redirect('/catalog/category/id/' . $category);
			}
		}
		$this->view->form = $form;
	}
	public function editAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		$id = (int) $this->_getParam('id',0);
		if($id<1){
			$this->_redirect('/');
		}
		$form=new App_Form_AddProduct();
		$form->setAction('/product/edit/id/'.$id);
		$form->getElement('submit')->setLabel('Update product');
		$productTable = new Product();
		
		$productRow = $this->view->product = $productTable->find($id)->current();
		
		$catalogTable = new Catalog();
		
		$this->view->category =$category = $productTable->getCategory($productRow->id);
		$this->view->parents = $catalogTable->getParentsRecursive($category[0]['id']);
		//$this->view->currentCategory=$currentCategory = $catalogTable->getCurrent($category);
		$this->view->parent = $catalogTable->getParent($category[0]['id']);
		
		
		if($this->_request->isPost()){
			if($form->isValid($_POST)){
			$productTable->update(array(
			'title'=>$_POST['title'],
			'short_about'=>$_POST['short_about'],
			'about'=>$_POST['about'],
			'price'=>$_POST['price'],
			'processing'=>$_POST['processing'],
			)
			, 'id = ' . $id);
			$this->_redirect('/product/index/id/' . $id);
			}
		}else{
			$form->populate($productRow->toArray());
		}
		$this->view->form=$form;
	}

	public function changehotAction() {
		
		if($_SESSION['admin']){
			$id=$this->_getParam('id',0);
			if($id>0){
				$product= new Product();
				$product->changehot($id);
			}
		}
		
		
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function moveAction()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}
		
		if($this->_request->isPost()){
			$category_id=$_POST['category_id'];
			$product_id=$_POST['product_id'];
			if($category_id >0){
			$product= new Product();
			$product->moveProduct($product_id,$category_id);	
			}
			
		}
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function mainpageAction() 
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}	
		
		$id = (int) $this->_getParam('id',0);
		
		if($id<1){
			$this->_redirect('/');
		}
//			
		
		$products= new Product();
		$productMain=$products->find($id)->current();
		if(!$productMain->main){
			$album = new App_Album_Product($id);
			$image= new App_Image();
			$image_path_to_file=$_SERVER['DOCUMENT_ROOT'].$album->getMainImage('s');
		
			if($album->getMainImage('s')==''){
				//$image_path='...'//Картинка которая будет отображаться на главной в случае отсутствия изображения у товара
				$image_path_to_file.='\application\public\img\product.gif';
			}
			$path_to_src_dir=$_SERVER['DOCUMENT_ROOT'].'/application/public/images/product/'.$id.'/';
			$white=16777215;//dec
 			$color=10027008;//dec
			$image->writeText('$'.$productMain->price,$color,$white,'AGCOO13.TTF',14,$image_path_to_file,$path_to_src_dir,10,10);
		
			
		}
		
		$productMain->main=!$productMain->main;
		$productMain->save();
		$this->_redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	public function deleteAction()
	{
		if($_SESSION['admin']){
		$id = (int) $this->_getParam('id',0);
		if($id<1){
			$this->_redirect('/');
		}
		$productTable = new Product();
		$category = $productTable->deleteProduct($id);
		$this->_redirect('/catalog/category/id/' . $category[0]["id"]);
		//Zend_Debug::dump($category);
		}else{
			$this->_redirect('/');
		}
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
		$size = $this->_getParam('size','m');
		$album = new App_Album_Product($id);
		$image = $album->getMainImage($size);
		$this->view->src = $image;
	}



	public function searchAction()
	{
		if($this->_request->isPost()){
			$_SESSION['category_id']=$_POST['category'];
			if($_POST['category']){
				$catalog = new Catalog();
				$_SESSION['category_title']=$catalog->find($_POST['category'])->current()->title;
			}else{
				$_SESSION['category_title']='All Categories';
			}

			$_SESSION['text_search']=$_POST['text_search'];
		}

		if ($_SESSION['text_search'] == ''){
			$this->_redirect('/');
		}
			
		$this->view->count = $count = (int)$this->_getParam('count',20);
		$page = (int) $this->_getParam('page' , 0 );
		$category_id=$_SESSION['category_id'];
			
		$this->view->category_id=$_SESSION['category_id'];
		$this->view->category_title=$_SESSION['category_title'];
		$this->view->textsearch=$textsearch=$_SESSION['text_search'];
			
		$product = new Product();
		$products = $product->search($category_id,$textsearch,$page);
		$products->setItemCountPerPage($count);
		$this->view->products = $products;
			

	}

}
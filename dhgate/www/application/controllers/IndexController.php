<?php
class IndexController extends MainController
{
	public function indexAction()
	{
		$product = new Product();
		$this->view->products = $product->fetchAll('main = 1');
		if ($this->auth->hasIdentity()){
			if ($this->admin){
				echo '<h1> Admin is loged ..... <a href="/user/logout/">Logout?</a></h1>';
			} else {
				echo '<h1> User is loged ..... <a href="/user/logout/">Logout?</a></h1>';
			}
		}
		
		
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
				$filter = Zend_Registry::get('autoFilter');
				 
				$settings->update(array($page => $filter->postCopy['text']), 'id = 1');
				$this->_redirect('/index/info/page/' . $page . '/');
			}
		}
	}
}
?>

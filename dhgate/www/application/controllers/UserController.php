<?php
class UserController extends MainController
{
	/**
	 * The default action - show the home page
	 */
	public function indexAction ()
	{

	}

	public function profileAction()
	{
		$id = (int) $this->_getParam('id',0);
		$user = new User();
		$this->view->user = $user->find($id)->current();
	}

	public function userAction()
	{
		if($this->_request->isPost())
		{
			$this->_login($_POST['login'], $_POST['pass'], true);
			$this->_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function registerAction()
	{

			

		$country = new Country();
		$this->view->countrys = $country->fetchAll();
			
		$checkout = $this->_getParam('checkout',0);
		if($this->_request->isPost()){
			$userTable = new User();
			if(trim($_POST['pass']) == trim($_POST['repass'])){
				if($_POST['login'] != ''
				&& $_POST['pass'] != ''
				&& $_POST['mail'] != ''
				/*  && $_POST['firstname'] != ''
				 && $_POST['adress'] != ''
				 && $_POST['city'] != ''
				 && $_POST['zip'] != ''
				 && $_POST['country'] != ''
				 && $_POST['phone'] != ''
				 */                ){
				if($userTable->checkMail($_POST['mail']))
				{
					if($userTable->checkLogin($_POST['login']))
					{
						unset($_POST['repass']);
						$_POST['pass'] = md5($_POST['pass']);
						$row = $userTable->createRow();
						foreach($_POST as $key => $value ){
							if(isset($row->$key))
							{
								$row->$key = $value;
							}
						}
						$row->save();
						$this->_login($_POST['mail'], $_POST['pass']);
						$cart = new Cart();
						$cart->savecookie();
						$this->_redirect('/');
						/*
						if($checkout){
							$this->_redirect('/order/step1/');
						} else {
							$this->_redirect('/');
						}*/

					}
					else
					{
						$this->view->message = 'login you chose is already registered';
					}
						
				}
				else
				{
					$this->view->message = 'mail you chose is already registered';
				}
				 } else {
				 	$this->view->message = 'Empty fields';
				 }
			} else {
				$this->view->message = 'Passwords do not match';
			}
		}
	}

	public function loginAction()
	{



		if($this->_request->isPost())
		{
			if ($_POST['pass'] != ''
			&& $_POST['mail'] != '')
			{
				if(!$this->_login($_POST['mail'], $_POST['pass']))
				{

					if (isset($_POST['remember']))
					{
						if((bool)$_POST['remember'])
						{
							Zend_Session::rememberMe(10000*10000);
						}
					}
					$this->view->message = $message = 'failed';


				}
				else
				{
					$message = '';
					$cart = new Cart();
					$cart->savecookie();
					$this->_redirect('/');
				}
			}
			else
			{
				$this->view->message = $message = 'failed';
			}
			/*			$params =$this->_getAllParams();
			 if($this->getRequest()->isXmlHttpRequest()){
				$this->view->show = false;
				$this->view->message = $message;
				}
				else
				{
				$this->view->message = $message;
				if($this->_getParam('checkout',0))
				{
				$this->_redirect('/order/step1/');
				}
				else
				{
				if($params['action'] == 'login')
				{
				$this->_redirect('/');
				}
				else
				{
				$this->_redirect($_SERVER['HTTP_REFERER']);
				}
				}
				}*/

		}
	}

	private function _login($login, $pass, $hash = null)
	{
		$dbAdapter = Zend_Registry::get('db');
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		$authAdapter->setTableName('user');
		$authAdapter->setIdentityColumn('mail');
		//$authAdapter->setIdentityColumn('login');
		$authAdapter->setCredentialColumn('pass');
		$authAdapter->setIdentity($login);
		//if($hash){
		//	$authAdapter->setCredential($pass);
		//} else {
		$authAdapter->setCredential(md5($pass));
		//}
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
		if($result->isValid()){
			$data = $authAdapter->getResultRowObject(null, 'pass');
			$auth->getStorage()->write($data);
			return  true;
		} else {
			return false;
		}
	}


	public function editAction()
	{
		$id = (int) $this->_getParam('id',0);
		$userTable = new User();
		$user = $this->view->user = $userTable->find($id)->current();
		$country = new Country();
		$this->view->countrys = $country->fetchAll();
		$state = new State();
		$this->view->states = $state->fetchAll('country_id=' . $user->country);
		if($this->_request->isPost())
		{
			if(
			$_POST['firstname'] != ''
			&& $_POST['adress'] != ''
			&& $_POST['city'] != ''
			&& $_POST['zip'] != ''
			&& $_POST['country'] != ''
			&& $_POST['phone'] != ''
			){
				$userTable->update($_POST, 'id = ' . $id);
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function setvaluteAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		setcookie('valute' , $_POST['valute'], mktime(0,0,0,01,25,2099),'/');
	}
}
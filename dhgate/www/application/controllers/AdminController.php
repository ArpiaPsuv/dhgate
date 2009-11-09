<?php

/**
 * AdminController
 *
 * @author
 * @version
 */

require_once 'Zend/Controller/Action.php';

class AdminController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function init()
	{
		if(!$_SESSION['admin']){
			$this->_redirect('/');
		}

	}
	public function indexAction()
	{


	}
	public function userlistAction()
	{
		$user = new User();
		$allUsers = $user->fetchAll();
		$this->view->users=$allUsers;

	}

	public function userdeleteAction()
	{
		$currentAdminID=Zend_Auth::getInstance()->getIdentity()->id;
		$id = (int)$this->_getParam('id',0);
		if (($id > 0) and ($id != $currentAdminID)) {
			$user = new User();
			$currentUser=$user->find($id)->current()->delete();
		}
		$this->_redirect("/admin/userlist");
	}

	public function userroleAction()
	{
		$currentAdminID=Zend_Auth::getInstance()->getIdentity()->id;
		$id = (int)$this->_getParam('id',0);
		if (($id > 0) and ($id != $currentAdminID)) {
			$user = new User();
			$currentUser=$user->find($id)->current();
			$currentUser->admin=(int)!$currentUser->admin;
			$currentUser->save();
		}
		$this->_redirect("/admin/userlist");
	}

}
?>

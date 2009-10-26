<?php
require_once 'Zend/Controller/Action.php';

class CommentController extends Zend_Controller_Action
{
	public function addAction()
	{
		if($this->_request->isPost())
		{
			if(trim($_POST['text']) != ''){
				$commentTable = Comment::create((string) $this->_getParam('item',null));
				$date = new Zend_Date();
				$data = array('text'=>$_POST['text'],'user_id' => (int)$this->_getParam('user_id',0), 'date'=>$date->getIso());
				$row = $commentTable->add((int)$this->_getParam('parent',0),$data,(int)$this->_getParam('item_id',0));
				if(!$this->getRequest()->isXmlHttpRequest()){
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				if(!$this->getRequest()->isXmlHttpRequest()){
					$this->_redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}
}
?>
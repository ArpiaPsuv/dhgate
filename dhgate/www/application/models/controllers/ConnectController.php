<?php
class ConnectController extends MainController
{
	public function init()
	{
	    if(!$_SESSION['admin']){
    		$this->_redirect('/');
    	}
	}
    public function addAction()
    {
        $connectTable = Connect::create((string) $this->_getParam('item', null));
        if(!$connectTable){
            $this->_redirect('/');
        }
        $row = $connectTable->add($_POST['category_id'], $_POST['item_id']);
        $row->save();
        $this->_redirect($_SERVER['HTTP_REFERER']);
    }
    public function moveAction()
    {
        $connectTable = Connect::create((string) $this->_getParam('item', null));
        if(!$connectTable){
            $this->_redirect('/');
        }
        $connectTable->move((int) $this->_getParam('item_id',0),(int)$_POST['in'], $_POST['out']);
        $this->_redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function copyAction()
    {
        $connectTable = Connect::create((string) $this->_getParam('item', null));
        if(!$connectTable){
            $this->_redirect('/');
        }
        $connectTable->connect($_POST['out'], (int) $this->_getParam('item_id',0)); 
        $this->_redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function deleteAction()
    {
        $connectTable = Connect::create((string) $this->_getParam('item', null));
        if(!$connectTable){
            $this->_redirect('/');
        }
        $connectTable->delete($_POST['out'], (int) $this->_getParam('item_id',0)); 
        $this->_redirect($_SERVER['HTTP_REFERER']);
    }
}
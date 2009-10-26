<?php
class ImageController extends MainController
{
	public $album;
	public function preDispatch()
	{
		$this->album = App_Album::create((string) $this->_getParam('item'),(int) $this->_getParam('item_id',0));
	}

	public function indexAction()
	{

	}
	public function uploadAction()
	{
		$this->album->upload();
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function setmainAction()
	{
		$this->album->setMainImage($_POST['src']);
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}

	public function deleteAction()
	{
		$this->album->delete($_POST['src']);
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
}
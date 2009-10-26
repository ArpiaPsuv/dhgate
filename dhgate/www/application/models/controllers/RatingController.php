<?php
class RatingController extends MainController
{
	//@todo black list (�� ��� ��������� ��������� id ������������ �������� ����)
	//@todo �������� id ������������

	/**
	 * ����� ��������� ��������
	 * ��� ��������� ���������� ����� ������ ����� ����� ���� ������� ajax
	 */
	public function setAction()
	{
		$ragingTable = Rating::create($this->_getParam('item',0));
		$ragingTable->setRating((int)$this->_getParam('user_id',0), (int)$this->_getParam('item_id',0), (int)$this->_getParam('mark',0));
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
}
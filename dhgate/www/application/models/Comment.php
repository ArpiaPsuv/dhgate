<?php
abstract class Comment extends App_TreeTable
{
	protected $_parentRowName = 'item_id';
	protected $_userTableName = 'user';
	public static function create($tableName)
	{
		switch($tableName){
			case 'user' : return new Comment_User(); break;
		}
	}
	public function add($parent, array $data, $parentItemId) {
		$row = parent::createChildRow($parent, $data);
		$row->{$this->_parentRowName} = $parentItemId;
		$row->save();
	}

	public function getComments($item_id)
	{
		$select = $this->getAdapter()->select()
		->from(array('c'=>$this->_name))
		->join(array('u'=>$this->_userTableName), 'c.user_id = u.id', array('user_id'=>'u.id','user_login'=>'u.login'))
		->where('c.item_id = ' . $item_id);
		return $this->getAdapter()->fetchAll($select);
	}
}

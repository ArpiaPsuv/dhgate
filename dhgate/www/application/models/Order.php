<?php
class Order extends Zend_Db_Table_Abstract {
	protected $_name = 'order';

	public function getMaxNum()
	{
		$select = $this->select()->from($this->_name, array('num','max(num)'))->group('id');
		$res = $this->fetchAll($select)->toArray();
		if($res){
			return $res[0]["num"];
		} else {
			return 0;
		}
	}

	public function getOrders($status = null)
	{
		$select = $this->select()
		->from($this->_name)
		->group('status');
		if($status !== null){
			$select->where("status = '$status'");
		}
		return $this->fetchAll($select);
	}

	public function getOrderByNum($num)
	{
		$select = $this->select()->where('num = ' . $num);
		return $this->fetchAll($select);
	}

	public function getCart($cart_id)
	{
		$select = $this->getAdapter()->select()->from(array('c'=>'cart'))
		->join(array('p'=>'product') , 'c.item_id = p.id');
		return $this->getAdapter()->fetchAll($select);
	}

	public function updateOrderStatus($number , $status)
	{
		return $this->update(array('status'=>$status), 'num='. $number);
	}

	public function getTrack($number, $mail)
	{
		$date = $this->getOrerDate($number, $mail);
		$date = new Zend_Date();
	}
	public function getOrderDate($number, $mail){
		$select = $this->getAdapter()->select()
		->from(array('o'=>$this->_name))
		->join(array('u'=>'user'),'u.id = o.user_id')
		->where('o.num=' . $number)
		->where("u.mail = '$mail'");
		$res = $this->getAdapter()->fetchAll($select);
		if($res){
			return new Zend_Date($res[0]['date']);
		} else {
			return false;
		}
	}
}

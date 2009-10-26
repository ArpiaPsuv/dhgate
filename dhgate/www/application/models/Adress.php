<?php
class Adress extends Zend_Db_Table_Abstract {
	protected $_name = 'adress';

	public function add($user_id , $data ,$id = null)
	{
		$data['user_id'] = $user_id;
		if($id === null){
			$row = $this->createRow();
		} else {
			$row = $this->find($id)->current();
		}
		return $this->insert($data);

		foreach($data as $key=>$value){
			if(isset($row->$key)){
				$row->$key = $value;
			}
		}
		$row->save();
		return $row;
	}
}

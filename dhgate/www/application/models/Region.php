<?php
class Region extends Zend_Db_Table_Abstract
{
	protected  $_name = 'region';
	
	public function getRegion($region_id)
	{
		return $this->find($region_id)->current();
	}

	public function getRegions()
	{
		return $this->fetchAll();
	}
	
	public function addRegion($name,$coef=1)
	{
		$data=array(
		'name'=>$name,
		'coef'=>$coef
		);
		return $this->insert($data);
	}
	
	public function updateRegion($id,$data)
	{
		return $this->update($data,"id = $id");
	}
	
	public function deleteRegion($id)
	{
		return $this->delete("id = $id");
	}
	
}
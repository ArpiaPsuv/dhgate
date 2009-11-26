<?php

class Valute extends Zend_Db_Table_Abstract
{
	protected $_name = 'valute';


	public function get($id = 0)
	{
		if($id > 0){
			return $this->find($id)->current();
		}else{
			return false;
		}
		
	}
	
	public function conversion($price,$prefix = 1, $class = 0)
	{
		 
	
		$valutes = $this;
		
		if(key_exists('valute', $_COOKIE)){
			$valute = $valutes->get($_COOKIE['valute']);
			if(!$valute){
				$valute = $valutes->getDefault();
			}
		}else{
			$valute = $valutes->getDefault();
		}
		
		if($class){
			if($valute){
				$html='<span class="'.$class.'">'.(round(($price*$valute['rate'])*100)/100).'</span>';
			}else{
				$html='<span class="'.$class.'">'.$price.'</span>';
			}
				
		}else{
			if($valute){
				$html=(round(($price*$valute['rate'])*100)/100);
			}else{
				$html=$price;
			}
		}
		
		if($prefix == 1 ){
			if($valute){
				$html.=' '.$valute['prefix'];
			}else{
				$html.=' USD';
			}
		}
		
		if($prefix == 2 ){
			if($valute){
				$html=$valute['prefix'].' '.$html;
			}else{
				$html='USD '.$html;
			}
		}
		
		if($prefix == 3 ){
			if($valute){
				$html=$valute['prefix'];
			}else{
				$html='USD';
			}
		}
						
		return $html;
	}
	
	public function add($prefix, $rate = 1, $default = 0) 
	{
		$data=array(
		'default'=>0
		);
		if($default){
			$this->update($data);
		}
		
		$data=array(
		'prefix'=>$prefix,
		'rate'=>$rate,
		'default'=>$default
		);
		
		return $this->insert($data);
	
	}
	
	public function getValutes() 
	{
		return $this->fetchAll();
	}
	
	public function setDefault($id)
	{
		$data=array(
		'default'=>0
		);
		$this->update($data);
		
		$row = $this->find($id)->current();
		$row->default = 1;
		$row->save();
		return row;
	}
	
	public function getDefault() 
	{
		return $this->fetchRow('`default` = 1');
	}
	
	public function updateRate($id,$rate)
	{
		$row = $this->find($id)->current();
		$row->rate=$rate;
		$row->save();
		return $row;
	}
	
	public function delete_valute($id) 
	{
		$row = $this->find($id)->current();
		if(!$row['default']){
			$this->delete('id = '.$id);
			return true;			
		}else{
			return false;
		}
	}
	
}


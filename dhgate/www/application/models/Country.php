<?php
class Country extends Zend_Db_Table_Abstract 
{
	protected  $_name = 'country';
    public function getCountry($country_id)
    {
    	return $this->find($country_id)->current();
    }
    
    public function isAllowed($id)
    {	
    	$country = $this->find($id)->current();
    	return (boolean) $country->allowed;
    }
}
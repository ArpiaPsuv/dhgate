<?php
class User extends Zend_Db_Table_Abstract
{
    protected $_name = 'user';
    
    public  function getUser($user_id)
    {
        return $this->find($user_id)->current();
    }
    
    public function checkLogin($login)
    {
        $validator = new App_Validate_NoDbRecordExists('user','login');
        return $validator->isValid($login);
    }
}
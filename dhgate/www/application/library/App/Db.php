<?php
class App_Db extends Zend_Db_Adapter_Pdo_Mysql
{
    
    public function insert($table, array $bind)
    {
        echo "insert";
        return parent::insert($table, $bind);
    }
    
    public function update($table, array $bind, $where = '')
    {
        echo 'update';
        return parent::update($table, $bind, $where='');
    }
    
    public function delete($table, $where = '')
    {
        echo 'delete';
        return parent::delete($table, $where = '');
    }
    public function query($sql, $bind = array()){
        echo 'delete2';
        return parent::query($sql, $bind = array() );
    }
}
?>
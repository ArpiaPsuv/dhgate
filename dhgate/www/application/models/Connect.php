<?php
abstract class Connect extends Zend_Db_Table_Abstract
{
    protected $_rowsName = array('category_id' => 'category_id', 'item_id'=>'item_id');
    
    public static function create($tableName)
    {
        switch($tableName){
            case  'catalog_product': return new Connect_Catalog(); break;
            case  'interested': return new Connect_Interested(); break;
        }
    }
        
    public function add($category_id, $item_id)
    {
        $data = array($this->_rowsName['category_id']=> $category_id, $this->_rowsName['item_id']=>$item_id);
        return $this->createRow($data);
    } 
    
    public function move($item_id, $in_category_id, $out_category_id)
    {
        $this->deleteItem($item_id , $out_category_id);
        return $this->add($item_id, $in_category_id);  
    }
      
    public function deleteItem($category_id = null, $item_id = null)
    {
        if($category_id === null){
             return parent::delete($this->_rowsName['item_id'] . ' = ' . $item_id);
        }
        if($item_id === null){
            return parent::delete($this->_rowsName['category_id'] . ' = ' . $category_id);
        }
        return parent::delete($this->_rowsName['category_id'] . ' = ' . $category_id . ' AND ' . $this->_rowsName['item_id'] . ' = ' . $item_id);
    }
}
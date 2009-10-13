<?php
class Product extends Zend_Db_Table_Abstract
{
    protected $_name = 'product';
    
    public function add($data, $category_id)
    {
        $row = $this->createRow($data);
        $row->save();
        $connectTable = Connect::create('catalog_product');
        $row = $connectTable->add($category_id, $row->id);
        $row->save();
        
    }
    
    public function getProduct($id)
    {
        return $this->find($id)->current();
    }
    
    public function getCategory($id)
    {
        $select = $this->getAdapter()->select()->from(array('c'=>'catalog'))
            ->join(array('con'=>'connect_catalog_product'), 'con.category_id = c.id', array())
            ->where('con.item_id = ' . $id)->limit(1);
        return $this->getAdapter()->fetchAll($select);
    }
    
    public function deleteProduct($id)
    {
        $category = $this->getCategory($id);
        $this->delete('id = ' . $id);
        $connectTable = new Connect_Catalog();
        $connectTable->deleteItem(null, $id);
        //@todo удалять картинки
        //$album = App_Album::create('product',$id);
        //$album->deleteAll();
        return $category;
    }
    
    public function getInterested($product_id)
    {
        $select = $this->getAdapter()->select()->from(array('p'=>$this->_name))
            ->join(array('c'=>'connect_product_interested'),'c.category_id = p.id')
            ->where('c.item_id = ' . $product_id);
        return $this->getAdapter()->fetchAll($select);
    }
    
    public function search($search)
    {
    	$select = $this->select()->from($this->_name)
    		->where("title like  '%$search%'")
    		->orwhere("about like '%$search%'")
    		->orwhere("short_about like '%$search%'")
    		->orwhere("about like '%$search%'")
    		->orwhere("specifications like '%$search%'");
    	return  new Zend_Paginator(new Zend_Paginator_Adapter_DbTableSelect($select));
    }
    
    public function getLeftProducts()
    {
    	$select = $this->select()->from(array('p'=>'product'))->where('p.left=1');
    	return $this->fetchAll($select);
    }
}
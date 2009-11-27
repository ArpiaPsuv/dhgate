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

	public function changehot($id)
	{
		$row=$this->find($id)->current();
		$row->hot=!$row->hot;
		$row->save();
	}
	public function getProduct($id)
	{
		return $this->find($id)->current();
	}

	public function getParentCategory($product_id=0)
	{
		if($product_id > 0 ){
			$current_category=$this->getCategory($product_id);
			if ($current_category[0]['level'] == 0 ){
				return $current_category[0];
			}else{
				$select= $this->getAdapter()->select()->from('catalog')->where('id = ?',$current_category[0]['parent']);
				$row= $this->getAdapter()->fetchRow($select);
				return $row;
			}
		}else{
			return false;
		}
	}
	
	
	
	public function getHot()
	{
		return $this->fetchAll('hot = 1');
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
		$album = App_Album::create('product',$id);
		$album->RecursiveDelete($album->fullPath);
		return $category;
	}

//	public function getInterested($product_id)
//	{
//		$select = $this->getAdapter()->select()->from(array('p'=>$this->_name))
//		->join(array('c'=>'connect_product_interested'),'c.category_id = p.id')
//		->where('c.item_id = ' . $product_id);
//		return $this->getAdapter()->fetchAll($select);
//	}

	public function search($category_id = 0,$searchText, $page=0)
	{


		$select = $this->getAdapter()->select()->from(array('p'=>'product'))
		->join(array('c'=>'connect_catalog_product'), 'p.id = c.item_id')
		->Where('c.category_id = '. $category_id)
		->where("`title` LIKE '%$searchText%' or `short_about` LIKE '%$searchText%' or `about` LIKE '%$searchText%'");
		
		$catalog= new Catalog();
		if ($category_id){
			$childs=$catalog->getLevel($category_id);
		}else{
			$childs=$catalog->fetchAll();
		}

		foreach ($childs as $childCategory) {
			$select->orWhere("c.category_id  = ".$childCategory->id);
			$select->where("`title` LIKE '%$searchText%' or `short_about` LIKE '%$searchText%' or `about` LIKE '%$searchText%'");
			
		}

		$paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Zend_Paginator($paginatorAdapter);
		$paginator->setItemCountPerPage(10);

		if($page !== null){
			$paginator->setCurrentPageNumber($page);
		}

		return $paginator;


	}



	public function moveProduct($product_id,$category_id) 
	{
		$data=array('category_id'=>$category_id);
		$this->getAdapter()->update('connect_catalog_product',$data,'item_id = '.$product_id);
	}
	
	public function getLeftProducts()
	{
		$select = $this->select()->from(array('p'=>'product'))->where('p.left=1');
		return $this->fetchAll($select);
	}
}
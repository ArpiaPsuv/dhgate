<?php
class Catalog extends App_TreeTable
{
	protected $_name = 'catalog';

	public function getCurrent($id)
	{
		return $this->find($id)->current();
	}

	public function getItems($category_id, $page = null,$from=NULL,$to=NULL,$sort_by = 0)
	{
		$select = $this->getAdapter()->select()->from(array('p'=>'product'))
		->join(array('c'=>'connect_catalog_product'), 'p.id = c.item_id')
		->where('c.category_id = ' . $category_id);
		if(($from >=0) and ($to >$from)){
			$select->where("`price` BETWEEN $from AND $to");
		}
		////// небольшая доработка....чобы товары выбирались из категории и из её подкатегорий
		$childs=$this->getLevel($category_id);
		foreach ($childs as $childCategory) {
			$select->orWhere('c.category_id  = '.$childCategory->id);
		}
		
		if($sort_by !=0){
			$select->order($sort_by);
		}
		
		
		/////
		$paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Zend_Paginator($paginatorAdapter);
		
		//$paginator->setItemCountPerPage(2);
		if($page !== null){
			$paginator->setCurrentPageNumber($page);
		}
		return $paginator;
	}

}
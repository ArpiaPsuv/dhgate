<?php
class Catalog extends App_TreeTable
{
	protected $_name = 'catalog';

	public function getCurrent($id)
	{
		return $this->find($id)->current();
	}

	public function getItems($category_id, $page = null)
	{
		$select = $this->getAdapter()->select()->from(array('p'=>'product'))
		->join(array('c'=>'connect_catalog_product'), 'p.id = c.item_id')
		->where('c.category_id = ' . $category_id);
		
		////// небольшая доработка....чобы товары выбирались из категории и из её подкатегорий
		$childs=$this->getLevel($category_id);
		foreach ($childs as $childCategory) {
			$select->orWhere('c.category_id  = '.$childCategory->id);
		}
		
		/////
		$paginatorAdapter = new Zend_Paginator_Adapter_DbSelect($select);
		$paginator = new Zend_Paginator($paginatorAdapter);
		$paginator->setItemCountPerPage(2);
		if($page !== null){
			$paginator->setCurrentPageNumber($page);
		}
		return $paginator;
	}

}
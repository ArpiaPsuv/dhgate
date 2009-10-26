<?php
class App_Plugin_AutoFilter extends Zend_Controller_Plugin_Abstract {
	protected  $filter;
	public     $postCopy;

	function __construct($filter = null)
	{
		if($filter===null){
			$this->filter= new Zend_Filter_StripTags();
		}
		$this->postCopy = $_POST;
		$this->_filterPost();
	}

	protected  function _filterPost()
	{
		if($_POST){
			foreach ($_POST as $key => $value){
				$_POST[$key] = $this->filter->filter(trim($_POST[$key]));
			}
		}
	}
	public function setFilter($filter){
		$this->filter = $filter;
	}
	public function getItemOfPost($key){
		return $this->postCopy[$key];
	}
}

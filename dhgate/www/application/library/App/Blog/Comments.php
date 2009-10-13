<?php 
class App_Blog_Comments extends App_ListTree {
	
	protected $_name = 'comments';
	protected $_parent = 'parent';
	protected $_id = 'id';
	protected $_dependentTables = array('App_Blog_Comments');
	
	 	protected $_referenceMap    = array(
        'Bug' => array(
            'columns'           => array('parent'),
            'refTableClass'     => 'App_Blog_Comments',
            'refColumns'        => array('id')
        )
    );
    
	public function getComments($id)
	{
		
	}
}
?>
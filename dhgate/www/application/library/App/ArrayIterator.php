<?php
class App_ArrayIterator extends ArrayIterator implements RecursiveIterator
{
	function __construct($array)
	{
		parent::__construct( $array );
	}

	function hasChildren()
	{
		return is_array($this->current());
	}

	function getChildren()
	{
		return $this->current();
	}
}
/*
 traverse($array);

 function traverse($array)
 {
 $obj = new recursiveArrayIterator( $array );

 while($obj->valid())
 {
 echo $obj->key() . '<br />';

 if ($obj->hasChildren())
 {
 traverse( $obj->getChildren() );
 }
 $obj->next();
 }
 }
 */
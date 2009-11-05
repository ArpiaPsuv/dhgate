<?php

class App_Form_AddProduct extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		//$this->setAction('/product/add/category/'.$cat_id);
		$this->setMethod('POST');
		

		$title= new Zend_Form_Element_Text('title',array(
		'required' => true,
		'label'=>'Title :',
		
		));
		

		$price=new Zend_Form_Element_Text('price',array(
		'required' => true,
		'label'=>'Price :',
		'validators' => array('float')
		));
		

		$shortDescription= new Zend_Form_Element_Text('short_about',array(
		'required' => true,
		'label'=>'Short about :',
		));

		
		$description= new Zend_Form_Element_Textarea('about', array(
		'required' => true,
		'label'=>'About :',

		));

		$procressing= new Zend_Form_Element_Text('processing',array(
		'required' => true,
		'label'=>'Processing :',
		'validators' => array('Int')
		));
		



			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Add product');


		$this->addElements(array(
		$title,
		$price,
		$shortDescription,
		$description,
		$procressing,
		$submit
		));
	}
}
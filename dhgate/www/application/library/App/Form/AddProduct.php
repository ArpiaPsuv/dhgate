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
		'filters'=>array('StringTrim','StripTags'),
		
		));
		

		$price=new Zend_Form_Element_Text('price',array(
		'required' => true,
		'label'=>'Price :',
		//'validators' => array('float'),
		'filters'=>array('StringTrim','StripTags'),
		));
		

		$shortDescription= new Zend_Form_Element_Text('short_about',array(
		'required' => true,
		'label'=>'Short about :',
		'filters'=>array('StringTrim','StripTags'),
		));

		
		$description= new Zend_Form_Element_Textarea('about', array(
		'required' => true,
		'label'=>'About :',
		'filters'=>array('StringTrim','StripTags'),

		));

		$procressing= new Zend_Form_Element_Text('processing',array(
		'required' => true,
		'label'=>'Processing :',
		'validators' => array('Int'),
		'filters'=>array('StringTrim','StripTags'),
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
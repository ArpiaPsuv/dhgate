<?php

class App_Form_AddProduct extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		//$this->setAction('/product/add/category/'.$cat_id);
		$this->setMethod('POST');
		//$this->setAttrib('class','addCategory');
		/*
		 $cat = new Zend_Form_Element_Text(
		 'name', array(
		 'required'    => true,
		 'maxlength'   => '30',
		 'validators'  => array(
		 array('Alnum', true, array(true)),
		 array('StringLength', true, array(0, 30))
		 ),
		 'filters'     => array('StringTrim'),

		 ));
		 $this->addElement($cat);
		 $cat->setName('name');*/

		/*Поля
		 Titlte
		 price
		 about
		 Description
		 processing*/

		$title= new Zend_Form_Element_Text('title',array(
		'required' => true,
		'label'=>'Name :',
		
		));
		

		$price=new Zend_Form_Element_Text('price',array(
		'required' => true,
		'label'=>'Price :',
		'validators' => array('Int')
		));
		

		$shortDescription= new Zend_Form_Element_Text('short_about',array(
		'required' => true,
		'label'=>'Short about :',
//		'validators' => array('Int')
		));

		
		$description= new Zend_Form_Element_Textarea('about', array(
		'required' => true,
		'label'=>'About :',
//		'validators' => array('Int')
		));

		$procressing= new Zend_Form_Element_Text('proсressing',array(
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
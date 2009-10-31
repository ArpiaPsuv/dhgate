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

		$title= new Zend_Form_Element_Text('title');
		$title->setLabel('Name');

		$price=new Zend_Form_Element_Text('price');
		$price->setLabel('Price');

		$shortDescription= new Zend_Form_Element_Text('short_about');
		$shortDescription->setLabel('Short Description');

		$description= new Zend_Form_Element_Textarea('about');
		$description->setLabel('Description');

		$procressing= new Zend_Form_Element_Text('progressing');
		$procressing->setLabel('Processing');



			
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
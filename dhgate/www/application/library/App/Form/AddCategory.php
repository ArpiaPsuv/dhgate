<?php

class App_Form_AddCategory extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		$this->setAction('/catalog/category/');
		$this->setMethod('POST');
		$this->setAttrib('class','addCategory');

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
		$cat->setName('name');

		 
		$submit = new Zend_Form_Element_Submit('submit', array(
            'label'       => 'Добавить',
		));

		$this->addElement($submit);
	}
}
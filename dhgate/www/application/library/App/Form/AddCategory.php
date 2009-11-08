<?php

class App_Form_AddCategory extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		$this->setAction('/catalog/add/');
		$this->setMethod('POST');
		$this->setAttrib('class','addCategory');

		$cat = new Zend_Form_Element_Text(
			'title', array(
			 'label'=>'Category title: ',
			 'required'    => true,
			 'maxlength'   => '30',
			 'validators'  => array(
		array('Alnum', true, array(true)),
		array('StringLength', true, array(0, 30))
		),
           'filters'=>array('StringTrim','StripTags'),

		));
		$this->addElement($cat);

		$parentId=  new Zend_Form_Element_Hidden('parent_id',
		array('value'=>0)
		);

		$coef = new Zend_Form_Element_Text('coef',array(
		'required'=>true,
		'label'=>'Category coef:',
		'size'=>3,
		'value'=>1,
		'filters'=>array('StringTrim','StripTags'),
		'validators' => array(
		'float'
		)
		));
		  
		
		//$cat->setName('name');

			
		$submit = new Zend_Form_Element_Submit('submit', array(
            'label'       => 'Add',
		));
		

		$this->addElement($coef);
		$this->addElement($submit);
		$this->addElement($parentId);

//		foreach($this->getElements() as $element){
//			$element->clearDecorators()
//			->addDecorator("ViewHelper")
//			->addDecorator("Errors");
//		}

	}
}
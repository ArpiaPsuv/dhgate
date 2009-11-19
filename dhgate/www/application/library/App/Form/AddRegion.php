<?php

class App_Form_AddRegion extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		$this->setAction('/admin/regions/');
		$this->setMethod('POST');
		

		$name = new Zend_Form_Element_Text('name', array(
			 'label'=>'Region name: ',
			 'required'    => true,
			 'validators'  => array(
	         array('StringLength', true, array(0, 30))),
           'filters'=>array('StringTrim','StripTags'),

		));
		
		$coef = new Zend_Form_Element_Text('coef',array(
		'required'=>true,
		'label'=>'Region coef:',
		'size'=>3,
		'value'=>1,
		'filters'=>array('StringTrim','StripTags'),
		'validators' => array(
		'float'
		)
		));
		  
					
		$submit = new Zend_Form_Element_Submit('submit', array(
            'label'       => 'Add Region',
		));
		

		$this->addElement($name);
		$this->addElement($coef);
		$this->addElement($submit);
		

//		foreach($this->getElements() as $element){
//			$element->clearDecorators()
//			->addDecorator("ViewHelper")
//			->addDecorator("Errors");
//		}

	}
}
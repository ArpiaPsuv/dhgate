<?php
class App_Form_Register extends App_Form {

	public function init(){
		parent::init();

		$this->setMethod('POST');

		

		$company= new Zend_Form_Element_Text('company',array(
			'label'=> 'Company name:'
		));
		$name= new Zend_Form_Element_Text('name',array(
			'required'=> true,
			'label'=> 'Contact name:'
		));
		$adress1= new Zend_Form_Element_Text('adress1',array(
			'required'=> true,
			'label'=>'Address Line 1:'
		));
		$adress2= new Zend_Form_Element_Text('adress2',array(
			'label'=>'Address Line 2:'
		));
		$city= new Zend_Form_Element_Text('city',array(
			'required'=> true,
			'label'=>'City:'
		));
		
		
		
		$region= new Zend_Form_Element_Select('region',array(
		'label'=>'Region:'
		));
		
		
		$region->addMultiOption(1,'Europe');
		$region->addMultiOption(2,'USA & Canada');
		$region->addMultiOption(3,'Asia');
		$region->addMultiOption(4,'Rest of the world');
		
		$state_select= new Zend_Form_Element_Select('state_select',array(
		'label'=>'State / Province:'
		));
		
		$state_text= new Zend_Form_Element_Text('state_text',array(
			'required'=> true,
			'label'=>'State / Province:'
		));
		
		

		
			
		$zip= new Zend_Form_Element_Text('zip',array(
			'required'=> true,
			'label'=>'Postal Code:'		
		));
		
		$phone= new Zend_Form_Element_Text('phone',array(
			'required'=> true,
			'label'=>'Phone number:'		
		));
		$fax= new Zend_Form_Element_Text('fax',array(
		'label'=>'Fax number:'
		));
		
		$submit = new Zend_Form_Element_submit('submit', array(
        	'value'=>'submit'
        	));
        $this->addElements(
        $company,
        $name,
        $adress1,
        $adress2,
        $region,
        $state_select,
        $state_text,
        $city,
        $zip,
        $phone,
        $fax,
        $submit
        );
        	
        	
        
//        	foreach($this->getElements() as $element){
//        		$element->clearDecorators()
//        		->addDecorator("ViewHelper")
//        		->addDecorator("Errors");
       	
	}
}
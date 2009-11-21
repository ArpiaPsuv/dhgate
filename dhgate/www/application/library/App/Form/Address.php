<?php
class App_Form_Address extends Zend_Form 
{
	public function __construct()
	{
		parent::__construct();
		$this->setName('address');
		$this->setAction('/order/step1/');
		
		$company_s = new Zend_Form_Element_Text('company_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		$contact_s = new Zend_Form_Element_Text('contact_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$contact_s->setRequired(true);
		
		$address_s = new Zend_Form_Element_Text('address_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$address_s->setRequired(true);
		
		$address2_s = new Zend_Form_Element_Text('address2_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		
		$city_s = new Zend_Form_Element_Text('city_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$city_s->setRequired(true);
		
		$region_s = new Zend_Form_Element_Select('region_s');
		$region_s->setRequired(true);
		$regionTable = new Region(); 
		foreach ($regionTable->getRegions()as $item){
			$region_s->addMultiOption($item->id, $item->name);
		}
		$state_s = new Zend_Form_Element_Text('state_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$state_s->setRequired(true);
		
		$postal_s = new Zend_Form_Element_Text('postal_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$postal_s->setRequired(true);
		
		$phone_s = new Zend_Form_Element_Text('phone_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$phone_s->setRequired(true);
		
		$fax_s = new Zend_Form_Element_Text('fax_s',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		
		
		
		
		
		$shipping= new Zend_Form_Element_Checkbox('shipping',array(
		'checked'=>'true',
		'class'=>'check'
		));
		
		
		
		
		$company_b = new Zend_Form_Element_Text('company_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		$contact_b = new Zend_Form_Element_Text('contact_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$contact_b->setRequired(true);
		
		$address_b = new Zend_Form_Element_Text('address_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$address_b->setRequired(true);
		
		$address2_b = new Zend_Form_Element_Text('address2_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		$city_b = new Zend_Form_Element_Text('city_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$city_b->setRequired(true);
		
		$region_b = new Zend_Form_Element_select('region_b');
		$region_b->setRequired(true);
		$regionTable = new Region(); 
		foreach ($regionTable->getRegions()as $item){
			$region_b->addMultiOption($item->id, $item->name);
		}
		$state_b = new Zend_Form_Element_Text('state_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$state_b->setRequired(true);
		
		$postal_b = new Zend_Form_Element_Text('postal_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$postal_b->setRequired(true);
		
		$phone_b = new Zend_Form_Element_Text('phone_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$phone_b->setRequired(true);
		
		$fax_b = new Zend_Form_Element_Text('fax_b',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		
		
		
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElements(array(
		$company_s, 
		$contact_s,  
		$address_s, 
		$address2_s, 
		$city_s, 
		$region_s,
		$state_s, 
		$postal_s,
		$phone_s, 
		$fax_s,
		
		$shipping,
		
		$company_b, 
		$contact_b,  
		$address_b, 
		$address2_b, 
		$city_b, 
		$region_b,
		$state_b, 
		$postal_b,
		$phone_b, 
		$fax_b,
		
		$submit
		));
		foreach($this->getElements() as $element){
        		$element->clearDecorators()
        		->addDecorator("ViewHelper")
        		->addDecorator("Errors");
       }
	}
}
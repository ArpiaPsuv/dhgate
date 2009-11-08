<?php
class App_Form_Address extends Zend_Form 
{
	public function __construct()
	{
		parent::__construct();
		$this->setName('adress');
		$company = new Zend_Form_Element_Text('company',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		$contact = new Zend_Form_Element_Text('contact',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$contact->setRequired(true);
		
		$address = new Zend_Form_Element_Text('address',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$address->setRequired(true);
		
		$address2 = new Zend_Form_Element_Text('address2',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		$city = new Zend_Form_Element_Text('city',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$city->setRequired(true);
		
		$country = new Zend_Form_Element_Select('country');
		//$country->setRequired(true);
		$countryTable = new Country(); 
		foreach ($countryTable->fetchAll() as $item){
			$country->addMultiOption($item->id, $item->name);
		}
		$state = new Zend_Form_Element_Text('state',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$state->setRequired(true);
		
		$postal = new Zend_Form_Element_Text('postal',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$postal->setRequired(true);
		
		$phone = new Zend_Form_Element_Text('phone',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		$phone->setRequired(true);
		
		$fax = new Zend_Form_Element_Text('fax',array(
		'filters'=>array('StringTrim','StripTags'),
		));
		
		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElements(array($company, $contact,  $address , $address2, $city, $country,$state, $postal,$phone, $fax));
		foreach($this->getElements() as $element){
        		$element->clearDecorators()
        		->addDecorator("ViewHelper")
        		->addDecorator("Errors");
       }
	}
}
<?php

class App_Form_Regions extends App_Form  {
	public function init(){
		parent::init();


		$region= new Zend_Form_Element_Select('region');
		$region->addMultiOption(0,'Select region');
		$region->addMultiOption(1.2,'Europe');
		$region->addMultiOption(2.1,'USA & Canada');
		$region->addMultiOption(1.9,'Asia');
		$region->addMultiOption(2,'Rest of the world');

		$this->addElement($region);

		foreach($this->getElements() as $element){
			$element->clearDecorators()
			->addDecorator("ViewHelper");
		}
	}
}
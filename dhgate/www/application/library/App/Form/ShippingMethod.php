<?php

class App_Form_ShippingMethod extends App_Form  {
	public function init(){
		parent::init();
		$helper  = new Zend_View_Helper_Url();
		//$this->setAction('/admin/newshipping/'.$cat_id);
		$this->setMethod('POST');
        $this->setAttrib('enctype', 'multipart/form-data');



		
		$title= new Zend_Form_Element_Text('title',array(
		'required' => true,
		'label'=>'Title :',
		'filters'=>array('StringTrim','StripTags'),
		
		));
		
				
		$about= new Zend_Form_Element_Textarea('about', array(
		//'required' => true,
		'label'=>'About :',
		'filters'=>array('StringTrim','StripTags'),

		));

		$image= new Zend_Form_Element_File('image',array(
			//'validators' => array('IsImage')
		));
		$path=$_SERVER['DOCUMENT_ROOT'].'/application/public/images/shipping';
		if(!file_exists($path)){
			mkdir($path,0,1);
		}
		$image->setLabel('Image:')
            ->setDestination($path);
		
		
		
		$coef= new Zend_Form_Element_Text('coef',array(
		'required' => true,
		'label'=>'Coef :',
		//'validators' => array('Float'),
		'filters'=>array('StringTrim','StripTags'),
		));
		



			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Add');


		$this->addElements(array(
		$title,
		$about,
		$coef,
		$image,
		$submit
		));
	}
}
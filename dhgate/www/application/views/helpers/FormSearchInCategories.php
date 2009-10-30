<?php

class Zend_View_Helper_FormSearchInCategories {
	public $view;
	public function FormSearchInCategories() {
		$category = new Catalog();
		
				
				
		$form= new App_Form_Search();
				
				
				
					$catalog = new Catalog();

		
	
		 $options= array();
    	 $keys=array();
    	 $values=array();
    	 
    	
        	array_push($keys,0);
		    array_push($values,'All Categories');
		    
      /*		foreach ($categories as $category) {
      					array_push($keys,$category->id);
            			array_push($values, '  '.$category->title);
               	
            } 		 	
*/
            
        $level_0 = $catalog->getallLevel(0);
		$level_1= $catalog->getallLevel(1);
		
		$tree='';
		foreach ($level_0 as $parent) {
			
						array_push($keys,$parent->id);
            			array_push($values, '  '.$parent->title);
			
			foreach ($level_1 as $child) {
				if($child->parent == $parent->id){
						array_push($keys,$child->id);
            			array_push($values, '    '.$child->title);
					}	
			}
			
		}
		
	
            
            
            
	  	
         
            	$options= array_combine($keys,$values);
       
            
            	
             	$form->getElement('category')->setmultiOptions($options);
          
				$html=
				'<form action="/catalog/search/" method="POST">
				<div id="text_search">Search</div>';
            	$html.=$form->getElement('text_search');
            	$html.=$form->getElement('category');
				
		 		$html.='<input type="submit" name="Submit" id="button" value="GO!" />';
				//$html.='<input type="submit" value="Go" height="100">';		
				//$html.='<div class="go_button"></div>';
			
				$html.='</form>';
				
				
				
		return $html;
	}
	public function setView(Zend_View_Interface $view) {

		$this->view = $view;
	}
}
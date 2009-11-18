<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * HotDealsItems helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_HotDealsItems {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function hotDealsItems() {
	
		$products= new Product();
		$hot= $products->getHot();
		
		
		
		$html='';
		foreach ($hot as $product) {
		if ($_SESSION['admin']){
			$p_admin='<p><a href="/product/changehot/id/'.$product['id'].'">Remove from hot</a></p>';
		}else{
			$p_admin='';
		}
			
		        $album = new App_Album_Product($product['id']);
                $image = $album->getMainImage('vs');
                if(!$image){
                        $image="/application/public/img/01000000.jpg";
                }
                
			
			$html.='
			<div class="hot_deals_title">
			
			<img src="'.$image.'" alt=""> 
			
			<a href="/product/index/id/'.$product['id'].'">'.$product['title'].'</a>
			<p>$'.$product['price'].'</p>
			'.$p_admin.'
			</div>';		
		}
	
		
		return $html;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

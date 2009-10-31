<?php
class Zend_View_Helper_RightColumn {
	public $view;

	public function rightColumn() {
		$html = '<div class="head_chapter"><p><img src="/application/public/img/cart-mod-h3.png" alt="buy">Latest Specials</p></div>';
		$product = new Product();
		$products = $product->getLeftProducts();
		foreach ($products as $product){
			$html .= '
						<div class="contain_chapter">
							<p style="padding:15px 0px 5px 0px;"><a href="/product/index/id/' .$product->id . '" style="font-size:13px;font-weight:bolder;">' . $product->title . '</a></p>
							';
			$album = new App_Album_Product($product->id);
			if($album->getMainImage('s')){
				$html.= '<img src="'.$album->getMainImage('s').'" alt="' . $product->title . '">';
			}
			$html.= '
							<p class="old_price top_padding">'.$this->view->valute($product->price).'</p>';
			if($product->oldprice){
				$html .= '<p class="price top_padding">' . $this->view->valute($product->oldprice). ' <span class="small_price">(inc 10% GST)</span></p>
										  <p class="save top_padding">You Save: '.$this->view->valute($product->oldprice - $product->price).'</p>';
			}
			$html.='
							<p style="padding-bottom:30px;"> <a href="#"><p style="display:none">'.$product->id.'</p><span class="add_to_cart">Add to cart</span></a></p>
							<div class="end_line_chapter" style="width: 80%; margin: 0 auto 20px auto;"></div>
						</div>';
		}
		$html .= '
						<div class="end_line_chapter"></div>';
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

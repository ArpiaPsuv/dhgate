<?php
class Zend_View_Helper_images
{
	public $view;
	public function images($id) {
		$html = '<div class="product_photo">';
		$album  = new App_Album_Product($id);
		$images = $album->getImages('s');
		if(count($images)){
			$html.='<a href="/product/getimage/id/' . $id . '" class="show_image">View Full-Size Image</a>';
		}
		$i=0;
		foreach( $images as $image){
			$html.="<div><a href='/product/getimage/id/{$id}/count/{$i}' class='show_image'>
					<img class='product_photo_small' src='{$image}'></a>";
			if($_SESSION['admin']){
				if(!$album->isMain($image)){
					$html .= "<p><a href='/product/setmain/id/{$id}' class='main'>set as main</a></p>";
				}
				$html.="<p><a class='deleteimg' href='/product/deleteimage/id/{$id}/'>delete</a></p>";
			}
			$html .='</div>';
			$i++;
		}
		if($_SESSION['admin']){
			$html.='<a href="#" id="upload">upload image</a>';
		}
		$html .= '</div>';
		return $html;
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
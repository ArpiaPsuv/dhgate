<?php
class Zend_View_Helper_Album
{
    public $view;
    public function album(App_Album $album, $item, $access = false) {
        $html = '';
        Zend_Debug::dump($album->getImages('s'));
        $mainImage = $album->getMainImage('l');
        if($mainImage){
            $html.= "<div id='main'>
            			<p><img src='{$mainImage}'>
                    	<form action='/image/delete/item/{$item}/item_id/{$album->itemId}/' method='POST'>
                            	<input type='hidden' name='src' value='{$mainImage}'>
                            	<p><input type='submit' value='delete'></p>
                    	</form>
            			</p>
            		</div>";
        }
        foreach ($album->getImages('s') as $image){
            $html .= "<p><img src='{$image}'>"; 
            if($access){
                $html.="<form action='/image/setmain/item/{$item}/item_id/{$album->itemId}/' method='POST'>
                        	<input type='hidden' name='src' value='{$image}'>
                        	<p><input type='submit' value='set as main'></p>
                	    </form>
                	    <form action='/image/delete/item/{$item}/item_id/{$album->itemId}/' method='POST'>
                        	<input type='hidden' name='src' value='{$image}'>
                        	<p><input type='submit' value='delete'></p>
                	    </form>
                ";
            }
            $html .="</p>";
        }
        return $html;
    }
    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }
}

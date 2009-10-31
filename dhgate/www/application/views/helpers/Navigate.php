<?php
class Zend_View_Helper_Navigate {
	public $view;
	protected $_html;
	public function navigate(array $elements, $append = null) {
		$this->prepend('<a href="/">Home</a>');
		for($i=0;$i<count($elements)-1;$i++){
			$this->_html.=' > <a href="'.$elements[$i]['href'].'">'.$elements[$i]['text'].'</a>';
		}

		$this->append(' > <span>'. $elements[count($elements)-1]['text'] .'</span>');
		if($append)
		{
			$this->append($append);
		}
		$this->append(
          '</div>');


		return $this->_html;
	}

	public function append($html)
	{
		$this->_html =   $this->_html . $html;
	}

	public function prepend($html)
	{
		$this->_html =  $html . $this->_html ;
	}

	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

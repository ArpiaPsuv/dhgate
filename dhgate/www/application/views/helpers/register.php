<?php
/**
 *
 * @author max
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * register helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_register {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function register() {
		$form= new App_Form_Register();
//		$form->populate($_POST);
	$html="
<form action=\"{$form->getAction()}checkout/1/ \"
method=\"{$form->getMethod()}\">
<div id=\"registration_form\">
<p class=\"processed_checkout_right_title\">Email Address :</p>
<p class=\"processed_checkout_right_text\">{$form->getElement('mail')}<img
	src=\"/application/public/img/check_out_account_corret.gif\" alt=\"\"></p>

<p class=\"processed_checkout_right_title\">Password :</p>
<p class=\"processed_checkout_right_text\">{$form->getElement('pass')}<img
	src=\"/application/public/img/check_out_account_corret.gif\" alt=\"\"></p>


<p class=\"processed_checkout_right_title\">Re-type Password :</p>
<p class=\"processed_checkout_right_text\">{$form->getElement('pass_approve')}<img
	src=\"/application/public/img/check_out_account_corret.gif\" alt=\"\"></p>

<p class=\"processed_checkout_right_title\">Nickname :</p>
<p class=\"processed_checkout_right_text\">{$form->getElement('login')}<img
	src=\"/application/public/img/check_out_account_corret.gif\" alt=\"\"></p>
</div>
<div class=\"registration_button\">
<p class=\"registration_button\">{$form->submit}</p>
</div>
</form>";
		
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

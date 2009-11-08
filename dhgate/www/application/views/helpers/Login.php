<?php
/**
 *
 * @author max
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Login helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Login {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function login() {
		$form= new App_Form_Login();
		
		$html="
		<form action=\"{$form->getAction()}checkout/1/\"
		method=\"{$form->getMethod()}\">
		<p>E-mail Address :{$form->getElement('mail')}</p>
		<p>Password :{$form->getElement('pass')}</p>
		<p>{$form->getElement('remember')} Remember my E-mail address
		for this computer.</p>
		<p class=\"sign_in_button_big\">{$form->getElement('submit')}</p>
		<p><a href=\"/user/recover/\">Forgot your password?</a></p>
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

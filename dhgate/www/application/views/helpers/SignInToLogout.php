<?php
/**
 *
 * @author viknet
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * SignInToLogout helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_SignInToLogout {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function signInToLogout() {
		// TODO Auto-generated Zend_View_Helper_SignInToLogout::signInToLogout() helper 
		
		if (!Zend_auth::getInstance()->hasIdentity()){
			$html='<a href="/user/login/"> Sign In </a>';
		}else{
			if($_SESSION['admin']){
			$html = '<a href="/admin/">Admin Panel</a> | ';
			$html .= '<a href="/user/">Admin Profile</a> | ';
			}else{
			$html = '<a href="/user/">User Profile</a> | ';	
			}
			
			$html.='<a href="/user/logout/"> Sign Out </a>';
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

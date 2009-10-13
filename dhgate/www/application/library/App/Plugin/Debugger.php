<?php
class App_Plugin_Debugger extends Zend_Controller_Plugin_Abstract {
    public function preDispatch() {
        $this->fb($_SERVER,'$_SERVER');
        $this->fb($_POST,'$_POST');
    }
    
    static function fb($message, $label=null)
    {
        if ($label!=null) {
            $message = array($label,$message);
        }
        Zend_Registry::get('logger')->debug($message);
    }
}

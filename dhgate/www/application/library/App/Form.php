<?php
/**
 * Класс расширяющий Zend_Form указание декораторов, валидаторов
 *
 * @author Коновалов Максим (max.zloy@gmail.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 */
class App_Form extends Zend_Form
{
	public function init()
	{
		parent::init();
		//$translator = new Zend_Translate('array',  './application/translate/errors.php');
		//$this->setTranslator($translator);
		$this->clearDecorators();
		$this->clearAttribs();
		$this->addElementPrefixPath('App_Validate', 'App/Validate/', 'validate');
		$this->addElementPrefixPath('App_Filter', 'App/Filter/', 'filter');
		$this->addElementPrefixPath('App_Form_Decorator', 'App/Form/Decorator/', 'decorator');
	}
	/**
	 * Процедура вывода jquery кода, который добавляет сообщение о ошибке
	 *
	 * @return NULL
	 */

	public  function printErrorMessages()
	{
		echo '<script>';
		foreach ($this->getElements() as $element){
			$errors = '';
			foreach ($element->getMessages() as $error){
				$errors .= $error . "<br>";
			}
			echo '$("#error_' . $element->getName() . '").html("' . $errors . '");';
		}
		echo '</script>';
	}
	 
}
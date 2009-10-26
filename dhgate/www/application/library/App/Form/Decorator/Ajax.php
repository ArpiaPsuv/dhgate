<?php
/**
 * Декоратор для форм позволяет добавлять jquery-ajax фукнции к формам
 *
 * @author Коновалов Максим (max.zloy@gmail.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class App_Form_Decorator_Ajax extends Zend_Form_Decorator_Abstract
{
	/**
	 * Фукция построения jquery кода - функции ajax
	 *
	 * @return string
	 */
	public function getJSCode()
	{
		$form = $this->getElement();
		$button = $form->getElement('submit_' . $form->getName());
		$formId  = $form->getAttrib('id') ;
		$jsCode='
		<div id ="check' . $formId . '"></div>
		<script>
            $("#'.$button->getAttrib('id').'").click(function () {
                data =	$("#' . $formId . '").serialize();
                $.ajax({
                    type: "'.$form->getMethod().'",
                    url: "'.$form->getAction().'",
                    data: data,				
                    success: function(msg){
                        $("#check'.$form->getAttrib('id').'").html(msg)
                    }
                });
                return false;
            });
		</script>';
		return $jsCode;
	}
	public function render($content)
	{
		$placement = $this->getPlacement();
		switch  ($placement) {
			case  'APPEND':
				return $content . $this->getJSCode();
			case  'PREPEND':
				return  $this->getJSCode() . $content;
			case  null:
			default:
				return $this->getJSCode();
		}
	}
}
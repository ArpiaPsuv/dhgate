<?php
/**
 * Декоратор для элементов, добавляет <div id="error_<имя элемента>"></div>
 * для элемента к которому был применён
 * 
 * @author Коновалов Максим (max.zloy@gmail.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * 
 */
class App_Form_Decorator_AjaxErrors extends Zend_Form_Decorator_Abstract
{
    /**
     * Фукция возвращает html код div`a
     *
     * @return String
     */
    public function getHtmlCode()
    {
        $element = $this->getElement();
        return '<div id="error_' . $element->getName() . '"></div>';
	}
	
    public function render($content)
	{
        $element = $this->getElement();
        if (!$element instanceof Zend_Form_Element) {
            return $content;
        }
        if (null === $element->getView()) {
            return $content;
        }
        $placement = $this->getPlacement();
        switch  ($placement) {
            case  'APPEND':
                return $content . $this->getHtmlCode();
            case  'PREPEND':
                return  $this->getHtmlCode() . $content;
            case  null:
            default:
                return $this->getHtmlCode();
		}
	}
}
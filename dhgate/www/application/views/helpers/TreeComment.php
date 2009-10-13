<?php
require_once 'Zend/View/Interface.php';
class Zend_View_Helper_TreeComment
{
    public $view;
    public function treeComment($comments,$parent_item, $tableName, $parent = 0) {
        $html = $this->_getTree($comments,$parent_item, $tableName, $parent = 0);
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $html.= "
                <form action='/comment/add/item_id/" . $parent_item['id'] . "/user_id/".Zend_Auth::getInstance()->getIdentity()->id."/item/" . $tableName . "/parent/0/' method='post'>
                    <p><textarea cols='40' rows='5' name='text'></textarea></p>
                    <p><input type='submit' value='Ответить'></p>
                </form>
            ";
        }
        return $html;
    }
    protected function _getTree($comments,$parent_item, $tableName, $parent = 0){
        $html= '';
        foreach($comments as $comment){
            if($comment['parent'] == $parent){
                 $html .= $this->view->comment($comment, $parent_item, $tableName);
                 $html .= $this->_getTree($comments, $parent_item, $tableName, $comment['id']);
            }
        }
        return $html;
    }
    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }
}
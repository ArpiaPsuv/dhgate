<?php
require_once 'Zend/View/Interface.php';
class Zend_View_Helper_Comment
{
	protected $_comment;
	protected $_parentItem;
	protected $_tableName;
	public $view;
	public function comment($comment,$parent_item, $tableName) {
		$this->_comment = $comment;
		$this->_parent_item = $parent_item;
		$this->_tableName = $tableName;
		if(Zend_Auth::getInstance()->hasIdentity()){
			return $this->_getActiveComment();
		}
		return "
            <div class='comment' style='margin-left:" . $this->_comment['level']*10 . "%;'>
                <p>" . $this->_comment['text'] . "</p>
                ".$this->view->rating(1, $this->_comment['id'],'comment_' . $this->_tableName)."
            </div>
        ";
	}

	protected function _getActiveComment()
	{
		return "
            <div class='comment' style='margin-left:" . $this->_comment['level'] . "%;'>
                <p>" . $this->_comment['text'] . "</p>
                ".$this->view->rating(1, $this->_comment['id'],'comment_user')."
                <form action='/comment/add/item_id/" . $this->_parent_item['id'] . "/user_id/".Zend_Auth::getInstance()->getIdentity()->id."/item/" . $this->_tableName . "/parent/".$this->_comment['id']."/' method='post'>
                    <p><textarea cols='40' rows='5' name='text'></textarea></p>
                    <p><input type='submit' value='Ответить'></p>
                </form>
            </div>
        ";
	}
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
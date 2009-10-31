<?php
/**
 * @author Коновалов Максим aka ZloY
 *      mailto: max.zloy@gmail.com
 * Помошник вида для рейтинга
 */
class Zend_View_Helper_Rating
{
	public $view;
	protected $_plusClass = 'inactive';
	protected $_zeroClass = 'inactive';
	protected $_minusClass = 'inactive';
	public function rating ($user_id = null, $item_id, $tableName)
	{
		$ratingTable = Rating::create($tableName);
		if($user_id === null) {
			$user_id = $this->_getUserId();
		}
		if(!$user_id)
		{
			return $this->_getInactiveRating();
		}
		$rating = $ratingTable->isVoted($user_id, $item_id);
		if($rating === false){
			return "
                <a href='/rating/set/user_id/" . $user_id . "/item_id/" . $item_id . "/item/" . $tableName . "/mark/1/' alt=''>+</a>
                <a href='/rating/set/user_id/" . $user_id . "/item_id/" . $item_id . "/item/" . $tableName . "/mark/0/' alt=''>--</a>
                <a href='/rating/set/user_id/" . $user_id . "/item_id/" . $item_id . "/item/" . $tableName . "/mark/-1/' alt=''>-</a>
            ";
		} else {
			return $this->_getVotedRating($rating);
		}
	}

	protected function _getInactiveRating()
	{
		return "
                <a href='#' class='".$this->_plusClass."' alt=''>+</a>
                <a href='#' class='".$this->_zeroClass."'>-</a>
                <a href='#' class='".$this->_minusClass."' alt=''>-</a>
            ";
	}

	protected function _getVotedRating($rating)
	{
		switch($rating){
			case $rating > 0: $this->_plusClass = 'plus'; break;
			case $rating == 0: $this->_zeroClass = 'zero'; break;
			case $rating < 0: $minusClass = 'minus'; break;
		}
		return "
                <a href='#' class='$this->_plusClass' alt=''>+</a>
                <a href='#' class='$this->_zeroClass'>" . $rating . "</a>
                <a href='#' class='$this->_minusClass' alt=''>-</a>
            ";
	}
	public function setView (Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	/**
	 * если id пользователя нет можно взять из  Zend_Auth
	 * @return integer user_id
	 */
	protected function _getUserId()
	{
		if(Zend_Auth::getInstance()->hasIdentity()){
			return Zend_Auth::getInstance()->getIdentity()->id;
		} else {
			return false;
		}
	}
}

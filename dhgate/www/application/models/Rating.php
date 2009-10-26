<?php
/**
 * @author Коновалов Максим aka ZloY
 *      mailto: max.zloy@gmail.com
 * абстрактный класс для рейтингования всего чего только можно
 */
abstract class Rating extends Zend_Db_Table_Abstract
{
	protected $_name = 'rating';
	/*
	 * @var _tableRowNames array
	 * названия полей в таблице с рейтингом
	 * ключи:
	 *     integer item_id - id рейтингуемой сушности - по умолчанию item_id
	 *     integer user_id - id пользователя который рейтингует :) - по умолчанию user_id
	 *     integer mark    - оценка которую выставил пользователь  - по умолчанию mark
	 */
	protected $_tableRowNames;

	/**
	 * конструктор
	 * @param $config - конфиг от Zend_Db_Table_Abstract
	 * @param $tableRowNames - массив с названием полей таблицы
	 * @return а ничего не возвращает :P
	 */
	public function __construct($config=array(), $tableRowNames = null)
	{
		if($tableRowNames === null){
			$this->_tableRowNames = array(
                'item_id' => 'item_id', 
                'user_id' => 'user_id', 
                'mark'    => 'mark'
                );
		} else {
			$this->_tableRowNames = $tableRowNames;
		}
		parent::__construct($config);
	}

	/**
	 * Фабричный метод (Factory method pattern)
	 * @param $tableName - название таблицы которую нужно вернуть,
	 *      если нехватает дописывать swich :)
	 * @return возвращает наследников от этого класса, фабрика же!
	 */
	public static function create($tableName)
	{
		switch ((string)$tableName){
			case 'user' : return new Rating_User(); break;
			case 'comment_user' : return new Rating_Comment_User(); break;
			default: return null;
		}
	}
	/**
	 * Установка рейтинга
	 * @param integer - $user_id -  id пользователя
	 * @param integer - $item_id - id сущности
	 * @param integer - $mark - оценка
	 * @return в зависимости от того голосовал ли пользователь за эту сущность
	 *  возвращает или id последней записи или false
	 */
	public function setRating($user_id, $item_id, $mark)
	{
		if(!$this->isVoted($user_id, $item_id)){
			$data = array($this->_tableRowNames['user_id'] => (int)$user_id, $this->_tableRowNames['item_id']=> (int)$item_id, $this->_tableRowNames['mark'] => (int)$mark);
			return $this->insert($data);
		} else {
			return false;
		}
	}
	/**
	 * Получение рейтинга
	 * @param $item_id  id - integer - сущности
	 * @return integer рейтинг сущности
	 */
	public function getRating($item_id)
	{
		$select = $this->select()->form(array('r' => $this->_name), array('sum'=>'SUM(r.' . $this->_tableRowNames['mark'] . ')'))
		->where($this->_tableRowNames['item_id'] . ' = ' . (int)$item_id);
		$result = $this->fetchAll($select);
		return (int)$result[0]['sum'];
	}

	/**
	 * Проголосовал ли пользователь за итем
	 * @param integer $user_id - id пользователя
	 * @param integer $item_id - id итема
	 * @return boolean
	 */
	public function isVoted($user_id, $item_id)
	{
		$select = $this->select()->from($this->_name)
		->where($this->_tableRowNames['user_id'] . ' = ' . $user_id)
		->where($this->_tableRowNames['item_id'] . ' = ' . $item_id);
		$row = $this->fetchRow($select);
		if($row){
			return $row->{$this->_tableRowNames['mark']};
		} else {
			return false;
		}
	}
}
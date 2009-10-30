<?php
/**
 * @author Коновалов Макисим aka ZloY
 * mail: max.zloy@gmail.com
 * @version 0.8
 *
 * Абстрактный класс деревьев List Model
 *
 */
abstract class App_TreeTable extends Zend_Db_Table_Abstract {

	/**
	 * Имя поля для родительского id по умолчанию = 'parent'
	 *
	 * @var string _parent
	 */
	protected $_parent;
	 
	/**
	 * Имя поля для основного id по умолчанию = 'id'
	 *
	 * @var string _id
	 */
	protected $_id;

	/**
	 * Имя класса наследника по умолчанию = get_class($this);
	 *
	 *
	 * @var string _refclassName
	 */
	protected $_refclassName;

	/**
	 * название поля для уровня по умолчанию level
	 *
	 * @var string $_level
	 */
	protected $_level;

	function __construct($config = array())
	{
		parent::__construct($config);
		if($this->_parent === null) {
			$this->_parent = 'parent';
		}

		if($this->_id === null){
			$this->_id = 'id';
		}
		if($this->_refclassName === null){
			$this->_refclassName =get_class($this);
		}
		if($this->_level === null){
			$this->_level = 'level';
		}
		array_push($this->_dependentTables,$this->_refclassName);
		// карта зависимостей выставляется к самой таблице
		$this->_referenceMap['tree'] =  array(
            'columns'           => array($this->_parent),
            'refTableClass'     => $this->_refclassName,
		    'refColumns'        => array($this->_id),
		    'onDelete'          => 'cascade',
            'onUpdate'          => 'cascade'
            );
	}

	/**
	 * функция установки родительского id
	 *
	 * @param string $parent
	 * @access protected
	 */

	protected function _setParentField($parent)
	{
		$this->_parent = (string) $parent;
	}

	/**
	 * Фун фунция установки главного id
	 *
	 * @param string $id
	 * @access protected
	 */
	protected function _setIdField($id = null)
	{
		$this->_id = (string) $id;
	}

	/**
	 * Добавление нового итема в дерево
	 *
	 * @param integer $parentId - родительский id
	 * @param array $data - массив данных
	 * @return Zend_Db_Table_Row - созданный итем
	 * @access public
	 */

	public function createChildRow($parent, array $data) /// @todo сделать возможность входящего параметра - объектом столбца
	{
		if(is_integer($parent)){
			$data[$this->_parent]  =  $parent;
			$parent= $this->fetchRow($this->_id . ' = ' . $parent);
		}
		if(!$parent){
			$parentId = 0;
			$level = 0;
		} else {
			$idRowName = $this->_id;
			$parentId = (integer)$parent->$idRowName;
			$levelRowName = $this->_level;
			$level = $parent->$levelRowName;
			$level++;
		}
		$data[$this->_parent] = $parentId;
		$data[$this->_level]  = $level;
		$row = $this->createRow($data);
		return $row;
	}

	/**
	 * Функция получения потомков итема
	 *
	 * @param integer $id
	 * @return Zend_Db_Table_Rowset
	 * @access public
	 */
	public function getChildren($obj, $table = null,$rule = null)
	{
		if(is_integer($obj)){
			$obj = $this->find($obj)->current();
		}
		 
		if($table === null){
			foreach ($this->_dependentTables as $table) {
				$array[$table] = $obj->findDependentRowset($table);
			}
			return $array;
		} else {
			if($rule === null){
				return $this->findDependentRowset($table);
			} else {
				return $this->findDependentRowset($table,$rule);
			}
		}
	}

	/**
	 * Функция проверки ветви на данном узле
	 * @param integer $id
	 * @return boolean
	 */
	public function hasChildren($id)
	{
		$validator = new App_Validate_NoDbRecordExists($this->_name,$this->_parent);
		return !$validator->isValid($id);
	}

	/**
	 * Функция получения родителя итема
	 *
	 * @param integer $id
	 * @return Zend_Db_Talbe_Rowset
	 * @access public
	 */
	public function getParent($id)
	{
		if($id>1){
			$row = $this->find((integer) $id)->current();
			if($row->{$this->_parent} !=0){
				return $row->findParentRow($this);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * @param $parent_id - integer
	 * @param $array  - array
	 * @return array of Zend_Db_Table_Row;
	 */
	public function getParentsRecursive($item_id, $array = array())
	{
		$parent = $this->getParent($item_id);
		if($parent)
		{
			array_push($array, $parent);
			$array = $this->getParentsRecursive($parent->{$this->_id}, $array);
		}
		return $array;
	}
	/**
	 * Фунция получения полного дерева join`ом
	 *
	 * @return Zend_Db_Talbe_Rowset
	 * @access public
	 */
	public function getTree()
	{
		$select  = $this->select()->from("$this->_name as n1")
		->from("$this->_name as n2")
		->where("n1.$this->_id = n2.$this->_parent");
		return $this->fetchAll($select)->toArray();
	}

	/**
	 * рекурсивная Функция для получения ветки дерева
	 * крайне не советуется к использованию изза множества sql Запросов
	 * @param integer $id
	 * id итема с от которого нужно найти подветвь
	 * @return array
	 * возвращает вложенный массив
	 * @access public
	 */

	public function getBranchRecursive($id = 1)
	{
		$children = $this->getChildren((integer)$id, $this, 'tree')->toArray();
		if($children) {
			for ($i=0;$i<count($children);$i++){
				$tmp = $this->getBranchRecursive($children[$i]["$this->_id"]);
				if($tmp){
					$children[$i]['child'] = $tmp;
				}
			}
		}
		return $children;
	}

	/**
	 * Процедура переноса дерева от одного родителя к другому
	 *
	 * @param integer $in
	 * id итема от в который нужно перенести ветку
	 * @param unknown_type $out
	 * id итема который нужно перенести
	 *
	 */
	public function moveBranch($fromID, $toID)
	{
		$from=$this->find($fromID)->current();
		
		
		
		if($toID != 0){
		$to=$this->find($toID)->current();	
		$from->level = $to->level+1;
		}else{
			$from->level=0;
		}
		
		$from->parent = $toID;
		$from->save();
		///Обновление level'a только для 2-х уровневого дерева	(примитив)
	   if($this->hasChildren($from->id)){
	   $childs= $this->getLevel($from->id);	
		   foreach ($childs as $child) {
		    $row = $this->find($child->id)->current();
		   	$row->level = $from->level+1;
		   	$row->save();
		   }
	   }
		
		
		
		
	}
	/**
	 * Процедура удаления ветви дерева, рекурсивна
	 * @param integer $id
	 * @return NULL
	 */
	public function deleteBranch($id)
	{
		$rowset = $this->fetchAll($this->_parent . ' = ' . (integer)$id );
		foreach($rowset as $row){
			if($this->hasChildren($row->id))
			{
				$this->deleteBranch($row->id);
			}
			$row->delete();
		}
		$this->find((integer)$id)->current()->delete();
	}

	/**
	 * Функция увеличения или уменьшения level`a для ветки дерева
	 * @param Zend_Db_table_Row $parentRow
	 * @param integer $count
	 * @access public
	 */

	public function updateLevel($parentRow,$count)
	{
		$level = $this->_level;
		$id = $this->_id;
		$rowset = $this->fetchAll($this->_parent . ' = ' . (integer)$parentRow->$id);
		foreach ($rowset as $row){

			if($this->hasChildren($row->id)){
				$this->updateLevel($row,$count);
			} else {
				$this->_plusRowLevel($row, $count,$level);
			}
		}
		$this->_plusRowLevel($parentRow,$count,$level);
	}

	/**
	 * функция установки уровня
	 * @param Zend_Db_Table_Row $row
	 * @param integer $count
	 * @param string $levelRowName
	 * @return Zend_Db_Table_Row
	 */
	protected function _setLevel($row, $count, $levelRowName = null)
	{
		if($levelRowName === null){
			$levelRowName = $this->_level;
		}
		 
		$row->$levelRowName = (integer)$count;
		if($row->$levelRowName<0){
			$row->$levelRowName = 0;
		}
		$row->save();
		return $row;
	}

	/**
	 * @param $parent_id - integer
	 * @return Zend_Db_Table_Rowset;
	 */
	public function getLevel($parent_id)
	{
		return $this->fetchAll($this->_parent . ' = ' . (int)$parent_id);
	}
	
	public function getAllLevel($level)
	{
		return $this->fetchAll('level = '. (int)$level);
	}
	
	/**
	 * Функция добавления числа к левелу
	 * @param Zend_Db_Table_Row $row
	 * @param integer $count
	 * @param string $levelRowName
	 * @return Zend_Db_Table_Row
	 */
	protected function _plusRowLevel($row,$count,$levelRowName = null)
	{
		return $this->_setLevel($row, $row->$levelRowName+(integer)$count,(string)$levelRowName);
	}
}
?>
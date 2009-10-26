<?php
abstract class App_Album  {
	protected $_path;
	protected $_fullpath;
	public $itemId;
	public $userId;
	protected $_mainFolder = 'main/';
	public $image;
	protected $_table;

	public function __construct($item_id = null, $user_id = null)
	{
		$this->_setTableClass();
		$this->_setPath();
		if($user_id !== null){
			$this->userId = $user_id;
		} else  {
			$this->userId = 0;
		}
		if($item_id !==null){
			$this->itemId = $item_id;
		} else {
			$this->itemId = $this->_getLastId()+1;
		}
		$this->_path .= "{$this->userId}/";
		$this->_fullpath = $_SERVER['DOCUMENT_ROOT'] . $this->_path;
		if(!file_exists($this->_fullpath)){
			mkdir($this->_fullpath);
		}
		$this->_path .= "{$this->itemId}/";
		$this->_fullpath = $_SERVER['DOCUMENT_ROOT'] . $this->_path;
		if(!file_exists($this->_fullpath)){
			mkdir($this->_fullpath);
		}
		if(!file_exists($this->_fullpath.$this->_mainFolder))
		{
			mkdir($this->_fullpath.$this->_mainFolder);
		}
	}


	static public function create($name ,$item_id = null, $user_id = null)
	{
		if($user_id === null)
		{
			if(!Zend_Auth::getInstance()->hasIdentity()){
				$user_id = 0;
			} else {
				$user_id = (int) Zend_Auth::getInstance()->getIdentity()->id;
			}
		}

		switch($name){
			case 'product': return new App_Album_Product($item_id, 0);
			default: return null;
		}
	}

	abstract protected function _setPath();
	abstract protected function _setTableClass();

	public function setImageClass($image)
	{
		$this->image = $image;
	}

	public function getImageClass()
	{
		if($this->image){
			return $this->image;
		} else {
			return new App_Image();
		}
	}
	public function upload($image = null)
	{
		if(!$this->image){
			$this->image = $this->getImageClass();
		}

		$this->image->setUploadPath($this->_path);
		$this->image->upload();
	}

	public function setMainImage($path)
	{
		$this->_moveIntoMainFolder();
		$image = $this->getImageClass();
		foreach ($image->prefixs as $prefix => $value)
		{
			$this->_moveToMainFolder($path, $prefix);
		}
		$this->_moveToMainFolder($path);
	}

	protected function _moveToMainFolder($path, $prefix = null)
	{
		$folder = $this->_fullpath . $this->_mainFolder ;
		if(!file_exists($folder))
		{
			mkdir($folder);
		}
		$array = explode('_',$path);
		if($prefix === null)
		{
			$arr = explode('/', $_SERVER['DOCUMENT_ROOT'].$path);
			$file = $this->_fullpath.$array[1];
			@copy(
			$file,
			$folder.$array[1]
			);
			@unlink($file);
		} else {
			@copy($this->_fullpath . $prefix .'_' . $array[1],
			$folder.$prefix.'_'.$array[1]
			);
			@unlink($this->_fullpath . $prefix .'_' . $array[1]);
		}

	}

	protected function _moveIntoMainFolder()
	{

		$folder = $this->_fullpath . $this->_mainFolder ;
		if(!file_exists($folder))
		{
			mkdir($folder);
		}
		foreach (scandir($folder) as $file)
		{
			if($file !='..' && $file!='.')
			{
				@copy($folder.$file, $this->_fullpath . $file);
				@unlink($folder.$file);
			}
		}
	}

	protected function _getLastId()
	{
		$select = $this->_table->select()->from($this->_table, 'max(id)');
		$result = $this->_table->fetchAll($select);
		return $result[0]['max(id)'];
	}

	public function getImages($prefix)
	{
		$images = array();
		foreach (scandir($this->_fullpath) as $file)
		{
			if($file  != '.' && $file !='..'){
				$arr =  explode('_',$file);
				if($arr[0] == $prefix)
				{
					array_push($images, $this->_path. $file);
				}
			}
		}
		return $images;
	}

	protected function _isFirst()
	{
		if(count(scandir($this->_fullpath)) > 2){
			return false;
		} else {
			return true;
		}
	}
	public function delete($path)
	{
		$arr = explode('_' , $path);
		$image = $this->getImageClass();
		if(!$this->isMain($path)){
			foreach ($image->prefixs as $prefix => $value)
			{
				unlink($this->_fullpath.$prefix.'_'.$arr[1]);
			}
			unlink($this->_fullpath.$arr[1]);
		} else {
			foreach ($image->prefixs as $prefix => $value)
			{
				unlink($this->_fullpath.$this->_mainFolder.$prefix.'_'.$arr[1]);
			}
			unlink($this->_fullpath.$this->_mainFolder.$arr[1]);
		}
	}

	public function isMain($path)
	{
		foreach (explode('/', $path) as $dir){
			if($dir.'/' == $this->_mainFolder){
				return true;
			}
		}
		return false;
	}

	public function getMainImage($prefix = null)
	{

		foreach (scandir($this->_fullpath.$this->_mainFolder) as $file)
		{

			if($file != '.' && $file != '..'){
				$separatedFile  = explode('_',$file);
				if($prefix == null){
					if(count($separatedFile) == 1){
						return $this->path . $this->_mainFolder . $file;
					}
				} else {
					if($separatedFile[0] == $prefix){
						return $this->_path . $this->_mainFolder  . $file;
					}
				}
			}
		}
	}

	public function deleteAll()
	{
		foreach (scandir($this->_fullpath) as $file){
			if($file != '.' && $file != '..'){
				@unlink($this->_fullpath.$file);
			}
		}
		foreach (scandir($this->_fullpath.$this->_mainFolder) as $file){
			if($file != '.' && $file != '..'){
				@unlink($this->_fullpath.$this->_mainFolder.$file);
			}
		}
	}
}
?>
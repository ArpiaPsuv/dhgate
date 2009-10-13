<?php
/*
 *  Работчая но недоделанная версия класса для работы с фотогалерей 
 *  
 *  размещает картинки в дирректориях по папкам в зависимости от размера, которые называются префиксами 
 *  умеет делать главную картинку
 */
class App_Album_Product{
     public $path = '/application/public/images/product/';   // - путь до папки с галереей 
     public $fullPath;
     public $id;                                 // id итема к которому привязанна галерея
     protected $_image;       // экземпляр класса картинок с которыми работаем 
     
     
     public function __construct($id)
     {
          $this->id = $id;
          $this->fullPath = $_SERVER['DOCUMENT_ROOT'].$this->path;
          $this->setPath($this->path.$this->id.'/');
          if(!file_exists($this->fullPath)){
               mkdir($this->fullPath);
          }
          $this->_image = new App_Image();
     }
     
     public function upload()
     {
          $this->_image->setUploadPath($this->path);
          $this->_image->upload();
     }
     
     // вовзвращает массив путей к картинкам входящий параметр префикс папки 
     public function getImages($prefix = null)
     {
          $images  = array();
          if(!file_exists($this->fullPath.$prefix.'/')){
               mkdir($this->fullPath.$prefix.'/');
          }
          foreach(scandir($this->fullPath.$prefix.'/' ) as $file){
               if($file != '.' && $file!='..')
               {
                    array_push($images, $this->path.$prefix.'/'.$file);
               }
          }
          if($this->getMainImage($prefix)){
               array_push($images , $this->getMainImage($prefix));
          }
          return array_reverse($images);
     }
     
     
     // возвращает главную картинку по префиксам 
     public function getMainImage($prefix)
     {
          if(!file_exists($this->fullPath.'main/')){
               mkdir($this->fullPath.'main/');
          }
          if(!file_exists($this->fullPath.'main/'. $prefix.'/'))
          {
               mkdir($this->fullPath.'main/'. $prefix.'/');
          
          }
          foreach(scandir($this->fullPath.'main/'. $prefix.'/') as $file){
               if($file != '.' && $file!='..'){
                    return $this->path.'main/'. $prefix .'/'.$file;
               }
          } 
     }
     
     // устанавливает картинку главной входящий параметр путь до неё 
     public function setMainImage($path)
     {
          $pathArray  = explode('/', $path);
          $image =  $pathArray[count($pathArray) - 1];
          $mainFolder = $this->fullPath.'main/';
          if(!file_exists($mainFolder))
          {     
               mkdir($mainFolder);
          }
          
          foreach ($this->_image->prefixs as $prefix => $size)
          {
               if(!file_exists($mainFolder.$prefix.'/'))
               {
                    mkdir($mainFolder.$prefix.'/');
               }
               foreach(scandir($mainFolder.$prefix.'/') as $file)
               {
                    if($file != '.' && $file!='..')
                    {
                         @copy($mainFolder.$prefix.'/'.$file, $this->fullPath.$prefix.'/'.$file);
                         @unlink($mainFolder.$prefix.'/'.$file);
                    }
               }
               @copy($this->fullPath.$prefix.'/'.$image, $mainFolder.$prefix.'/'.$image);
               @unlink($this->fullPath.$prefix.'/'.$image);
          }
     }
     
     // установить путь до папки с альбомом
     public function setPath($path)
     {
          $this->path  = $path;
          $this->fullPath = $_SERVER['DOCUMENT_ROOT'].$this->path;
     }
     // является ли картинка главной входящий параметр - путь 
     public function isMain($path)
     {
          $pathArray = explode('/' , $path);
          foreach ($pathArray as $dir)
          {
               if($dir == 'main'){
                    return true;
               }
          }
          return false;
     }
     
     
     // удалить картинку 
     public function delete($path)
     {
          @unlink($_SERVER['DOCUMENT_ROOT']. $path);
     }
}
?>
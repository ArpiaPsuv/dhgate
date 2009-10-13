<?
class App_Filter_PostFilter implements Zend_Filter_Interface 
{
    
    public function filter($value) 
    {
            $filter = new Zend_Filter_StripTags($filter = null);
            if($filter === null){
                $filter = new Zend_Filter_StripTags();
            }
            foreach ($value as $key=>$val){
                $result[$key]  = $filter->filter($val);
            } 
            return $result; 
    }
}  
<?php
class Media extends Model {
    public $id;
    public $article_id;
    public $name;
    public static $TABLE_NAME = 'media';
    

    public static function getMediaByUser($id=0) {
        $condition=sprintf("`user_id`='%u'",intval($id));
    	return static::readRecords ($condition, true, true, 0, PHP_INT_MAX, 'id', true);
    }
    

    
    public static function deleteMediaByArticle($id=0) {
        
        $id=intval($id);
        if ($id===0) { return false; }
        
        $medias = static::readRecords (sprintf("`article_id`='%u'", $id), true, true);
        
        if (empty($medias)) {return true;}
        foreach ($medias as $media){
            $path = '/public/img/articles/'.$media->name;
            if (file_exists($path)){ unlink($path); }
        }
       
       static::deleteRecords(sprintf("`article_id`='%u'", $id));

    }
}
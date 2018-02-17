<?php
class Article extends Model {
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $status;
    public $date_published;
    public $date_created;
    public static $TABLE_NAME = 'articles';

    
    public static function getPublishedArticles($search_key=null, $count=null){
        $search='';

        if ($search_key) {
            if (trim(str_replace("*", '', $search_key)) ==="") {return false;}
            $search_key=htmlspecialchars($search_key, ENT_QUOTES);
            if (substr($search_key, 0,1) == "*") {$search_key='%'.substr($search_key,1);} 
            if (substr($search_key, -1) == "*") {$search_key=substr($search_key,0,-1).'%';} 
            $search=sprintf(" AND (`title` LIKE '%s' OR `description` LIKE '%s') ORDER BY CASE WHEN `title` LIKE '%s' THEN 1 WHEN `description` LIKE '%s' THEN 2 END",$search_key,$search_key,$search_key,$search_key);            
        }   
        
        $result=static::getPage(PAGE_INDEX, PER_PAGE, ("status = 'PUBLISHED'".$search));
 
        if ($count === true) {
            $counter=static::execQuery("SELECT COUNT(*) AS Count FROM `articles` WHERE status = 'PUBLISHED'".$search);
            $response = [$result, $counter[0]['Count']];
        }else{
            $response = $result; 
        }
        
        return $response;

    }


    public function getDetailsUrl(){
        return 'index.php?page=details&id='.$this->id;
    }
    
    public static function incrementView($id){
        $query= "UPDATE `articles` SET views = views + 1 WHERE id = '".$id."'";
        $res=static::execQuery($query);
    } 
    
    public static function getAllView($id=null) {
        if ($id) {
            $query= "SELECT SUM(`views`) AS total_view FROM `articles` WHERE `user_id`='".$id."'";
        }else{
            $query= "SELECT SUM(`views`) AS total_view FROM `articles`";
        }
        $res=static::execQuery($query);
        return $res=$res[0]['total_view'];
    }
    
    public function getShortDescription () {
        $content=htmlspecialchars_decode($this->description);
        if (strlen($content) > 100){
            return substr($content, 0, 100)."...";       
        }else{
            return $content;
        }
    }
    
    public static function readArticlesByUser($id=0) {
        $condition=sprintf("`user_id`='%u'",intval($id));
    	return static::readRecords ($condition, true, true, 0, PHP_INT_MAX, 'date_created', true);
    }
    
    public static function deleteArticle($id=0) {
        $id=intval($id);
        if ($id===0) { return false; }
        if (!User::isLogged()) { return false; }
        $user_id=intval($_SESSION['loggedUserId']);
        $condition=sprintf("`user_id`='%u' AND id='%u'", intval($user_id), $id);
        //return if articleid and userid not pair (user isnt author)
        $article=static::readRecords ($condition, true);
        if (!$exist = !empty($article)) {return false;}
        $title = $article->title;
        $path=UPLOAD_DIR.$id.'.jpg';
        $thumb_path=UPLOAD_DIR.'thumb_'.$id.'.jpg';
        if (file_exists($path)) { 
            unlink($path);
            unlink($thumb_path);
        }
        Media::deleteMediaByArticle($id);
        Comment::deleteCommentByArticle($id);
        Article::deleteRecords(sprintf("`id`='%u'", $id));
        return $title;
    }
}

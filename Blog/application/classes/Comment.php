<?php
class Comment extends Model {
    public $id;
    public $article_id;
    public $user_id;
    public $content;
    public $status;
    public $date_created;
    public static $TABLE_NAME = 'comments';
    public static $statusTypes = ['REJECTED', 'APROVED', 'PENDING'];
    
   

    public static function addComment($data) {
 
        $comment = new Comment();
        $data['date_created'] = date("Y-m-d H:i:s");
        $article = new Article($data['article_id']);
        $error = null;
        
        if (!isset($article->id)) {
            $error="Article not exist";
        } else if ($data['user_id'] == 0) {
            $error="You must login";
        } else if (trim($data['content']) === "") {
            $error="No content";
        }
        

        if ($error) { return [0, $error]; }
        
        foreach ($data as $key => $value) {
            $comment->$key = $value;
        }
        
        unset($comment->id);
        $lastInsertedId = 0;

        if ($comment->save()) { 
            $lastInsertedId = $comment->getInsertedId();
            $error = $data['date_created']; // well bad name but no point in new var + checking
        } else { $error="Cannot save the comment";  }
        
        return [$lastInsertedId, $error];
    	
    }
    

    public static function editComment($data) {
 
        if (!isset($data['id']) || (!isset($data['content']) && !isset($data['status']))) {
            return "Missing id or content/status";
        }
        
        
        $id = intval($data['id']);
        $userId = User::getUserId();
        $comment = new Comment($id);
        //$data['date_created'] = date("Y-m-d H:i:s");
        if (isset($comment->article_id)) {
            $article = new Article($comment->article_id);
            $authorId = $article->user_id;
        }else{
            $authorId = $userId;
        }
       

        if (!isset($comment->id)) {
            return "Comment not exist";
        } else if ($comment->user_id != $userId && $authorId != $userId) {
            return "Cannot edit because not your comment!";
        } else if (isset($data['status'])) {
            $status = $data['status'];
            if (in_array($status, static::$statusTypes)) {
               // ads
            } else {
                return "invalid status type!";
            }
            
        } else if (trim($data['content']) === "" || ($data['content'] === $comment->content)) {
            return "No content or unchanged";
        }
        
        if (isset($data['content'])) {
            $comment->content = $data['content'];
        }elseif(isset($data['status'])) {
            $comment->status = $data['status'];
        }
        
        $comment->id = $id;
        
        //if ($comment->save()) { return true; }else{ return "Cannot save the comment"; } 
        return $comment->save() ? true : "Cannot save the comment"; 
   
    }    

    public static function getCommentsByArticle($id = 0, $status = 'APROVED', $page = 0, $limit = 1000) {
        
        $statusCondition = in_array($status, static::$statusTypes) ? " AND c.status='".$status."'" : '';
        // reasone why i check count because dont want useless query, and i use if because the query string is long
        $count = static::execQuery(sprintf("SELECT count(*) as count FROM comments c WHERE c.article_id=%u %s", $id, $statusCondition));
        if ($count > 0) {
            if ($limit > 1000) { $limit = 1000; }
            $start = $page * $limit;
            // if the page index not exist then we return the highest existing page index
            if ($start > $count) {
                $page = ceil($count/$limit)-1;
                $stat = $page * $limit;
            }
            
            $data = static::execQuery(sprintf("SELECT c.id as id, c.article_id as articleId, c.user_id as userId, c.status as status, c.content as content, c.date_created as dateCreated, u.name as userName, u.email as userEmail, u.id as userId FROM comments c LEFT JOIN users u ON c.user_id=u.id WHERE c.article_id=%u %s ORDER BY c.date_created DESC LIMIT %u, %u", $id, $statusCondition, $start, $limit));
        }else{
            $data = [];
        }
        // i return the page index too, because if user sent invalid page number then i correct it to max
        return [ 'count' => $count[0]['count'], 'page' => $page, 'comments' => $data ];

    }
    
    public static function deleteComment($id=0) {
        
        $error = null;
        $user_id = User::getUserId();
        
        if ( $user_id === 0) {
            $response = "Your not logged in!";
        } else {
            
            $comment = new Comment($id);
            $article = new Article($comment->article_id);
   
            if (!isset($comment->id)) {
                $response = "Comment not exist!";
            } else if (isset($article->id) && $comment->user_id != $user_id && $article->user_id != $user_id) {
                $response = "Cannot delete comment what is not your!";
            } else {
                static::deleteRecords(sprintf("`id`='%u'", $id)); 
                //$count = static::execQuery(sprintf("SELECT count(*) as count FROM comments c WHERE c.article_id=%u %s", $id, $statusCondition));
                $response =true;
            }

        }
        return $response;
    }    
    
    public static function deleteCommentByArticle($id=0) {
        
        $error = null;
        
        if ($user_id = User::getUserId() === 0) {
            $error = "Your not logged in!";
        } else {
            $article = new Article($id);
            if (!empty($article)) {
                if ($user_id !== $article->user_id) { return false; }
                static::deleteRecords(sprintf("`article_id`='%u'", $id));
            }
        }
    }

    public static function getCommentByUser($id=null) {
        $id = intval($id);
        $count = static::execQuery(sprintf("SELECT count(*) as count FROM comments as c INNER JOIN articles as a ON c.article_id = a.id WHERE a.user_id = %s", $id));
        return $count[0]['count'];
    }
    
    public static function getCommentsStatistics($id=null) {
        $result;
        $arr = [];
        if (!$id) { return false; }
        
        $count = static::execQuery(sprintf("SELECT a.title AS title, ( SELECT COUNT( * ) FROM  `comments` AS c WHERE c.article_id = a.id ) AS count FROM  `articles` AS a WHERE a.user_id=%s ORDER BY count DESC LIMIT 0, 7", $id));
        $result = '["My Articles", "Comments"],';
        if (count($count) === 0) {
            $result = '["Top Articles", "Comments"],';
            $count = static::execQuery("SELECT a.title AS title, ( SELECT COUNT( * ) FROM  `comments` AS c WHERE c.article_id = a.id ) AS count FROM  `articles` AS a ORDER BY count DESC LIMIT 0, 7");
        }
        $max = count($count);
        
        if ($max===0) {
            $result = '["My mood", "at hour"], ["Six AM", 2], ["3 PM", 4], ["Five PM", "25"]';
        }else{
            for ($i = 0; $i < $max; $i++) {
                $result .= '["'.substr($count[$i]['title'], 0, 15).'", '.$count[$i]['count'].']';
                if ($i != ($max - 1)) {  $result .=',';  }
            }
        }

       return '{ "data": ['.$result.']}'; 
    }
    
}


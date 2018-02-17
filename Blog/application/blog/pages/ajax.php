<?php

header("content-type: application/json");

$action = getParam('action');
if ($action === "getsumm") {
    $a = intval(getParam('a', 0));
    $b = intval(getParam('b', 0));
    
    $arr = ['success'=>true, 
            'data'=> ['summ' => $a+$b ] ];
    echo json_encode($arr);
    die;
} else if ($action==="login"){
    $arr = ['success'=>false, 'error'=> $_POST['user']];    
    $username = htmlspecialchars($_POST['user'], ENT_QUOTES);
    $password = htmlspecialchars($_POST['pass'], ENT_QUOTES);
    include "application/blog/pages/login.php";
    die;
    
} else if ($action==="getComments") {
    $article_id = intval(getParam('article_id', 0));
    $page = intval(getParam('index', 0));
    $limit = intval(getParam('limit', 0));
    $status = getParam('status', 'APROVED');
    $data = Comment::getCommentsByArticle($article_id, $status, $page, $limit);
    $arr = ["success"=>true, "data"=>$data];
    die (json_encode($arr));
    
} else if ($action==="addComment") {
    
    if (!isset($_POST['comment'])) {
        die(json_encode(["success"=>false, "error"=>"Sent data is empty"]));
    }
    $data = $_POST['comment'];
    
    $response = Comment::addComment($data);
    if ($response[0] > 0) {
        $arr = ["success"=>true, "data"=>['id'=>$response[0], 'dateCreated'=>$response[1]]];
    }else{
        $arr = ["success"=>false, "error"=>$response[1]];
    }
    die (json_encode($arr));

    
} else if ($action==="delComment") {
    $id = intval(getParam('id', 0));;
    if ($id === 0) {
        json_encode(["success"=>false, "error"=>"Invalid comment id!"]);
    }
    
    $response = Comment::deleteComment($id);
    if (gettype($response) === "string") {
        $arr = ["success"=>false, "error"=>$response];
    }else{
         $arr = ["success"=>true, "data"=>['deleted'=>$response]];
    }
    die (json_encode($arr));   
    
} else if ($action==="editComment") {
    if (!isset($_POST['comment'])) {
        die(json_encode(["success"=>false, "error"=>"Sent data is empty"]));
    }

    $response = Comment::editComment($_POST['comment']);
    
    if ($response === true) {
        $arr = ["success"=>true, "data"=>["updated"=>true]];
    }else{
        $arr = ["success"=>false, "error"=>$response];
    }
    die (json_encode($arr));    
    
}   

$arr = ['success'=>false, 'error'=> 'What do you tryin?'];    
echo json_encode($arr);
?>
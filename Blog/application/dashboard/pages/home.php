<?php

if (isset($_GET['delete'])){
    $resp = Article::deleteArticle(intval($_GET['delete']));
    $_SESSION['dashboard']['mesage']= $resp ? '<b>'.$resp.'</b> has been deleted!' : 'Ups, unable to delete article';
    redirect('/dashboard.php');
}

$user_id = User::getLogged()->id;

$T['articles'] = Article::readArticlesByUser($user_id);

if (isset($_SESSION['dashboard']['mesage'])) {
    $T['message']=$_SESSION['dashboard']['mesage'];
    unset($_SESSION['dashboard']['mesage']);
}

$T['views'] = Article::getAllView($user_id);
$T['commentCounter'] = Comment::getCommentByUser($user_id);
$T['statistics'] = Comment::getCommentsStatistics($user_id);  

/*

    was a more problem with c9 (ex disappeared id column, rollbacks, dissappeared column attributes)
    so images now is a bit dizzy because i renemad manuallly and thumbnail sometimes have different 
    suffix then needed, (and i not verify & reuploaded every image)
     but image upload/thumbnail function work well...

*/
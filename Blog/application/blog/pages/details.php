<?php 
    $id = intval($_GET['id']);
    $article = new Article($id);
    if (!isset($article->id)) { redirect('/index.php'); }
    Article::incrementView($id);
    $user = new User($article->user_id);
    if (!isset($user->id)) {
        $user->name = "Deleted User";
        $user->email = "notexist@mail.com";
        $user->id = 0;
    }
    $article->author = $user;
    unset($article->author->password);  //because i dont see any reason for handleing the password too
    $T['article'] = $article;
    $T['myUserData'] = User::getLogged();

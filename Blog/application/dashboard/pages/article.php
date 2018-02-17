<?php 
$showUI=true;
if ($id === 0)  { redirect('/dashboard.php?page=login'); }
$article = new Article($id);
if (!isset($article->id)) { redirect('/dashboard.php'); }
$article->author = new User($article->user_id);
$T['article']=$article;
$T['myUserData'] = User::getLogged();
if (!isset($T['myUserData']->id) || ($T['myUserData']->id != $article->author->id)) { redirect('/dashboard.php'); }
FormHelper::clearSession();
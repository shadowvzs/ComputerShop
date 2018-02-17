<?php 
if ($id > 0) {
    $article = Article::readId ($id);
    $article ? :  die('id ['.$id.'] id not exist');
    $T['article'] = $article;

    $cache['title']['value']=htmlspecialchars_decode($article->title);
    $cache['description']['value']=htmlspecialchars_decode($article->description);
    $cache['id']['value']=$article->id;
    $cache['status']=$article->status;
	$user = User::getLogged();
	
    if (!isset($user->id) || ($user->id != $article->user_id)) { redirect('/dashboard.php'); }

}else{
	if (!isset($_SESSION['validForm'])) {
		FormHelper::clearSession();
	}
	$article=null;
}

if (isset($_SESSION['input']) || !$article){
	$cache['title']=[];
    $cache['description']=[];
    $cache['id']=[];
    $cache['status']='';
}

$url = $id > 0 ? '?page=edit&id='.$id : '';

$FORM = [
	'create'=>['name'=>'LogForm','url'=>$url, 'enctype'=>'multipart/form-data', 'method'=>'POST'],
	'input'=>[
		'title' => ['text', 'cache'=>true, 'attr'=>array_merge(['required','placeholder'=>'Article title'],$cache['title']),'rule'=>['pattern'=>['length'=>[1,255]]]],
		'id' => ['hidden','cache'=>true, 'attr'=>array_merge(['placeholder'=>'Article title'], $cache['id'])],
		'description' => ['textarea', 'cache'=>true, 'attr'=>array_merge(['placeholder'=>'Article content'],$cache['description']),'rule'=>['pattern'=>['length'=>[1, 5000000]]]],
		'status' => ['select','selected'=>$cache['status'], 'label'=>'Status', 'options'=>['DRAFT', 'PUBLISHED']],
		'file' => ['file'],
		'submit' => ['submit', 'attr'=>['value'=>'Salveaza modificarile']]
	],
	'end'=>true,
];

if (isset($_SESSION['validForm']) && $_SESSION['validForm']){
	
	if ($_SESSION['input']['id'] != '') {
		$article=new Article($_SESSION['input']['id']);
		if ($article->user_id !== User::getLogged()->id) {FormHelper::clearSession();$_SESSION['dashboard']['mesage']="Do not try to cheat";redirect('/dashboard.php');}
		if (empty($article)) {FormHelper::clearSession();$_SESSION['dashboard']['mesage']="Article not exist anymore";redirect('/dashboard.php');}
	}else{
		$article = new Article();
		unset($article->id);
		$article->user_id=User::getLogged()->id;
		$article->date_created = date2Mysql();
	}
	
	$article->title=$_SESSION['input']['title'];
	$article->description=$_SESSION['input']['description'];
	if ((!$article->status) || ($article->status="DRAFT")&&($_SESSION['input']['status']==="PUBLISHED")) {
		$article->status=$_SESSION['input']['status'];
		$article->date_published = date2Mysql();
	}

	$article->save();
	$newId=$article->getInsertedId();
	if (isset($_SESSION['input']['file'])){
		if ($_SESSION['input']['file'][0]) {
			$name=$_SESSION['input']['file'][1];
			$newPath = UPLOAD_DIR.$newId.'.jpg';
			$oldPath = UPLOAD_DIR.$name;
			if (file_exists($newPath)) {
				unlink($newPath);
			}
			//die;
			rename(	$oldPath, $newPath);
			createThumbnail($newId.'.jpg', 242, 230);
			//die;
		}
	}
		
	FormHelper::clearSession();
	$_SESSION['dashboard']['mesage']="Article saved";
	 
	redirect('/dashboard.php');
	
}else{
	if (isset($_SESSION['input']['error'])){
		$_SESSION['dashboard']['mesage'] = implode('',$_SESSION['input']['error']);
	}
	
}


FormHelper::init($FORM);

if (isset($_SESSION['dashboard']['mesage'])) {
    $T['message']=$_SESSION['dashboard']['mesage'];
    unset($_SESSION['dashboard']['mesage']);
}

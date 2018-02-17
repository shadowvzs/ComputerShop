<?php $article=$T['article']; ?>
<?php $img = 'background: url("/public/img/articles/'.(isset($T['article']) ? ($T['article']->id).'.jpg' : 'default.jpg').'") no-repeat center center scroll;';	?>

<div class="showArticle .middle">
	<div class="header" style='<?= $img ?>'></div>
	<div class="main editArticle">
		<h1><span class="article_category">Categorie</span> / by <span class="article_author"><?= $article ? $article->user_id : 'You' ?></span> / <span class="article_date"><?= $article ? date2Mysql($article->date_created, 'M d, Y \a\t H:i') : 'Now' ?></span></h1>
		<article>
			<?= FormHelper::getForm() ?>
		</article>
	</div>
</div>
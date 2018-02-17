<a href='index.php'>
	<?php 
		$img = 'background: url("/public/img/articles/'.(isset($T['article']) ? ($T['article']->id).'.jpg' : 'cover.jpg').'") no-repeat center center scroll;';	
		$title = isset($T['article']) ? htmlspecialchars_decode($T['article']->title) : 'Smartboard';
		$short_description = isset($T['article']) ? $T['article']->getShortDescription() : 'Welcome on our blog page, we hope you enjoy our articles and maybe you write also several new article like us!';
		?>
	<div class="black-header-bg"></div>
	<header style='<?= $img ?>'>
		<div class="title">
			<h1><?= $title ?></h1>
			<p><?= $short_description ?></p>
		</div>
	</header>
</a>
<?php $search_key = getSearchKey(); 
if (!isset($T['articles']) || empty($T['articles'])) : ?>
	<article>
		<h1><i> ... sorry but no article ... </i></h1>
	</article>
<?php else: foreach ($T['articles'] as $article): ?>
	
	<article>
		<div class="imgParent"><img src="/public/img/articles/<?= intval($article->id) ?>.jpg" onerror="this.src='./public/img/default.jpg';"></div>
		<a href="index.php?page=details&id=<?= intval($article->id) ?>"><h1><?= hightlightString(htmlspecialchars_decode($article->title),$search_key) ?></h1></a>
		<p><?= hightlightString(htmlspecialchars_decode($article->getShortDescription()),$search_key) ?></p>
		<a href='index.php?page=details&id=<?= intval($article->id) ?>'>Citeste mai mult...</a>
	</article>
		
	<?php endforeach; ?>
	
	<div class="pagination">
	  <a href="<?= PREV_PAGE ? 'index.php?p='.(PAGE_INDEX-1) : 'javascript::void(0)' ?>"><button <?= PREV_PAGE ? : 'disabled' ?> >❮</button></a> 
	  		<span> <?= $T['pager'] ?> </span> 
	  <a href="<?= NEXT_PAGE ? 'index.php?p='.(PAGE_INDEX+1) : 'javascript::void(0)' ?>"><button <?= NEXT_PAGE ? : 'disabled' ?> >❯</button></a>
	</div>
<?php  endif; ?>
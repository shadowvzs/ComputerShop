<section class="article">
	<h1> Written by <?= $T['article']->author->name ?> / <?= date2Mysql($T['article']->date_created, 'M d, Y \a\t H:i') ?></h1>
	<main>
		<article> <p>			<?= convertLineBreaks(htmlspecialchars_decode($T['article']->description)) ?>		</p></article>
	</main>		

	<footer>
		<h3><span id="commentCounter">Loading</span> Comments <a href="javascript:void(0);" id="commentOrder" class="myButton">DESC</a></h3>
		<span id="commentList">
			<!-- comments will going here -->
		</span>
		<center><a id="show_more" href="javascript:void(0);" class="myButton">Show more</a></center>
		<div class="form">
			
		
		<?php if ($T['myUserData']) { ?>
			<h5>adauga comentariu</h5>
			<textarea id="addCommentInput"> </textarea>
			<button id="addCommentButton" value=" Post "> Post </button>

		<?php }else{ ?>
			You have to <a href='dashboard.php?page=login'><b></b>log in</b></a> before leaving a comment
		<?php } ?>
		</div>
	</footer>
<section>

<script>
	var info = (function(){
		var articleId = parseInt("<?= $T['article']->id ?>", 10) ;
		var userId = parseInt("<?= isset($T['myUserData']) ? $T['myUserData']->id : 0 ?>", 10);
		var authorId = parseInt("<?= intval($T['article']->user_id)  ?>", 10);
		var userName = "<?= isset($T['myUserData']) ? $T['myUserData']->name : 'Guest' ?>";
		var userEmail = "<?= isset($T['myUserData']) ? $T['myUserData']->email : 'noemail@mail.com' ?>";
	
		return {
			getAuthorId: function() { return authorId; },
			getUserId: function() { return userId; },
			getUserName: function() { return userName; },
			getUserEmail: function() { return userEmail; },
			getArticleId: function() { return articleId; },
		};
	})();	
</script>
	
<script src="/public/js/ajaxRequest.js?<?= time() ?>" type="application/javascript"></script>
<script src="/public/js/comment.js?<?= time() ?>" type="application/javascript"></script>
<script src="/public/js/commentList.js?<?= time() ?>" type="application/javascript"></script>
<script src="/public/js/article.js?<?= time() ?>" type="application/javascript"></script>

<script>

if (document.readyState === 'complete') {
	article(true);
  
 }
  
document.onreadystatechange = function() {
  if (document.readyState === 'complete') {
	  article(true);
  }
};
</script>
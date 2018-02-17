<?php $article=$T['article']; ?>
<?php $img = 'background: url("/public/img/articles/'.(isset($T['article']) ? ($T['article']->id).'.jpg' : 'default.jpg').'") no-repeat center center scroll;';	?>

<div class="showArticle .middle">
	<div class="header" style='<?= $img ?>'></div>
	<div class="main readArticle">
		<h1>Written by <?= $T['article']->author->name ?> / <?= date2Mysql($T['article']->date_created, 'M d, Y \a\t H:i') ?></h1><a href="?page=edit&id=<?= $article->id ?>" title="Editeaza articolul" class="edit">Editeaza articolul</a>
		<article>
			<h2><?= htmlspecialchars_decode($article->title, ENT_QUOTES) ?></h2>
			<p><?= convertLineBreaks(htmlspecialchars_decode($article->description, ENT_QUOTES)) ?>
			</p>
		</article>
		<div class="commets">
			<h3><span id="commentCounter">Loading</span> Comments 
				<span class="rightBox">
					<select id="perPage">
						<option value="2" selected>2</option>
						<option value="5">5</option>
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					<select id="statusType">
						<?php foreach (Comment::$statusTypes as $statusType) : ?>
							<option value="<?= $statusType ?>"> 
								<?= $statusType ?> 
							</option>
						<?php endforeach; ?>
						<option value="ALL" selected> ALL </option>
					</select>
					<a href="javascript:void(0);" id="commentOrder" class="myButton">DESC</a>
				</span>
			</h3>
			<span id="commentList">
				<!-- comments will going here -->
			</span>
			<center><div id="pagination" class="pagination"> </div></center>
		</div>
	</div>
</div>


<div class="modal" id="modal">
    <div class="window">
        <div class="header">Edit comment
            <div class="close">
                <a href="javascript:void(0);" title="Close" class="red" onclick="document.getElementById('modal').style.display='none';">&#10008;</a>
            </div>
        </div>
        <div class="content">
            <textarea id="editCommentField">asdasd</textarea>
            <center><button id="editCommentButton">Save</button></center>
        </div>
    </div>
</div>

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
	article(false);
  
 }
  
document.onreadystatechange = function() {
  if (document.readyState === 'complete') {
	  article(false);
  }
};
</script>
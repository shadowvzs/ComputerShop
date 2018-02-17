<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Blog Homepage </title>
        <link rel="stylesheet" href="/public/css/index.css?<?= time() ?>" type="text/css"/>     
        <link rel="stylesheet" href="/public/css/common.css?<?= time() ?>" type="text/css"/>     
    </head>
    <body>
  	    <?php      require ("header.php");   ?>     <!-- header --> 
		<section class="parent">
			<main class="parent">
                <?php  require ($templatePath);    ?> <!-- main -->  	
			</main>
	        <?php     require ("sidebar.php");     ?>  <!-- sidebar -->
		</section>
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
    </body>
</html>
	

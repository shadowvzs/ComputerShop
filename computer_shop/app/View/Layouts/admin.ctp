<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	
		echo $this->Html->meta('icon');
		echo $this->Html->css('combine.php?combine=bootstrap.min,font-awesome.min,my-style');
		echo $this->Html->script('combine.php?combine=jquery.min,bootstrap.min,notify.min');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->meta('title', isset($currentPage['meta_title']) ? $currentPage['meta_title'] : '' );
		echo $this->Html->meta('keywords', isset($currentPage['meta_keyword']) ? $currentPage['meta_keyword'] : '' );
		echo $this->Html->meta('description', isset($currentPage['meta_description']) ? $currentPage['meta_description'] : '' );	
		//echo $this->Js->writeBuffer(); 
	?>

	<style>
		* {
			padding:0;
			margin:0;
			box-sizing: border-box;
		}
	</style>
</head>
<body>
	<?php $admin = true; ?>
	<div id="header">
		<?php 
			echo $this->Element('admin_header');
		?>
	</div>
	
	<div class="row col-xs-12 col-sm-12 col-md-12">
		<?php if (isset($_SESSION['Message']['flash'])) { ?>
			<div class="alert alert-danger alert-dismissable text-center fade in" style='z-index: 20;'>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<div class="text-center"> <?php echo $this->Flash->render(); ?> </div>
			</div>	
		<?php } ?>
		<?php 
			echo "<div class='col-sm-3 col-md-3'>".$this->Element('admin_sidebar')."</div>";
			echo "<div class='col-sm-9 col-md-9 content'>".$this->fetch('content')."</div>";		
		?>
	</div>
	<div id="footer">
		<?php if(isset($currentPage['footer'])) { echo (intval($currentPage['footer'])!==0) ? $this->Element('page_header') : ''; } ?>
	</div>
	
</body>
</html>

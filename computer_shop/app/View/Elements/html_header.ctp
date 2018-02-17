<?php echo $this->Html->charset(); ?>
<title>
	<?php //echo $cakeDescription ?>:
	<?php echo $this->fetch('title'); ?>
</title>
<?php
	echo $this->Html->meta('icon');
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	//echo $this->Html->css('cake.generic');
	echo $this->Html->css('font-awesome.min');
	echo $this->Html->css('bootstrap.min');
	echo $this->Html->script('jquery');
	echo $this->Html->script('bootstrap.min');
	//echo $this->Js->writeBuffer(); 
?>

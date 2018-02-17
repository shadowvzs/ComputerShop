<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		$meta_title = "";
		if (isset($currentPage['meta_title'])) {
			$meta_title .= $currentPage['meta_title'];
		}
		
		$meta_description = "";
		if (isset($currentPage['meta_description'])) {
			$meta_description .= $currentPage['meta_description'];
		}

		$meta_keyword = "";
		if (isset($currentPage['meta_keyword'])) {
			$meta_keyword .= $currentPage['meta_keyword'];
		}
		
		if (isset($ProductMeta)) {
			$meta_title .= $ProductMeta['meta_title'];
			$meta_description .= $ProductMeta['meta_description'];
			$meta_keyword .= $ProductMeta['meta_keyword'];
		}
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->css('combine.php?combine=bootstrap.min,font-awesome.min,my-style,default');
		echo $this->Html->script('combine.php?combine=jquery.min,bootstrap.min,notify.min');
		echo $this->Html->meta('title', $meta_title );
		echo $this->Html->meta('keywords', $meta_keyword );
		echo $this->Html->meta('description', $meta_description );	
		//echo $this->Js->writeBuffer(); 
	?>

	<style>

	</style>
</head>
<body>

<div class="grid">
	<div class="header">
		<?php echo $this->Element('default_header'); ?>
	</div>

	<div class="menu">
		<ul class="category" id="category">
			<?php $mainList = array(); ?>
			<li>
				<?php 
					echo $this->Html->link(
							__('Show All'), 
							array(
								'controller'=>'products', 
								'action'=>'index', 
							), 
							array(
								'escape'=>false,
								'style'=>'display:block; text-decoration:none; color: inherit;'
								)
					);
				?>
			</li>
			<?php foreach ($categories as $key => $category) {?>
				<li class='dropdown-submenu' data-catId="<?php echo $key; ?>">
					<?php echo $category['Category']['name']; ?> 
				</li>
				<?php 
				if (isset($category['Child']) && !empty($category['Child'])){ 
					$subList = array();
					foreach ($category['Child'] as $subcategory) { 
						$subList[] = $this->Html->link(
							$subcategory['name'], 
							array(
								'controller'=>'products', 
								'action'=>'index', 
								null, 
								'?' =>"category=".$subcategory['slug']
							), 
							array('escape'=>false)
						);
					} 
					$mainList[] = "<div id='cat_".$key."' style='display: none;'>".implode(PHP_EOL,$subList)."</div>";
				} ?>
			<?php 
			}
			?>
		</ul>
		<div id="subCatMenu">
			<?php echo implode(PHP_EOL, $mainList); ?>
		</div>

		<div class="searchBar box-shadow">
		<?php
		$orderBy = array(
						'price_ASC'=>'Price ASC', 
						'price_DESC'=>'Price DESC',
						'name_ASC'=>'Name ASC', 
						'name_DESC'=>'Name DESC'
					);
					
					echo $this->Form->create('Product', array('url' => '/','type' => 'get', 'class'=>'navbar-form'));
					echo "<div class='clearfix'>".$this->Form->input('category', array('class' => 'pull-right','style'=>'width: 60px;','label' => array('class'=>'control-label','text'=>__('Category').':'), 'options' => $categs, 'default'=>'0'))."</div>";
					echo "<div class='clearfix'>".$this->Form->input('brand', array('class' => 'pull-right','style'=>'width: 60px;','label' => array('class'=>'control-label','text'=>__('Brand').':'), 'options' => $brands, 'default'=>'0'))."</div>";
					echo "<div class='clearfix'>".$this->Form->input('classification', array('class' => 'pull-right','style'=>'width: 60px;','label' => array('class'=>'control-label','text'=>__('Series').':'), 'options' => $series, 'default'=>'0'))."</div>";
					echo "<div class='clearfix'>".$this->Form->input('accessory', array('class' => 'pull-right','style'=>'width: 60px;','label' => array('class'=>'control-label','text'=>__('Acc. set').':'), 'options' => $accessories, 'default'=>'0'))."</div>";
					echo "<div class='clearfix'>".$this->Form->input('condition', array('class' => 'pull-right','style'=>'width: 60px;','label' => array('class'=>'control-label','text'=>__('Condition').':'), 'options' => array('any'=>'Any', 'used'=>'Used', 'new'=>'New'), 'default'=>'0'))."</div>";
					echo "<div class='clearfix text-center' style='margin: 10px 0;'>";
						echo $this->Form->input('min_price', array('class'=>'form-control','style'=>'width: 100px;display:inline-block;', 'value'=>'','placeholder'=>'Min Price','label'=>false,'div'=>false)).' ';
						echo $this->Form->input('max_price', array('class'=>'form-control','style'=>'width: 100px;display:inline-block;','value'=>'','placeholder'=>'Max Price','label'=>false,'div'=>false));
					echo "</div>";
					echo "<div class='clearfix'>".$this->Form->input('orderby', array('class' => 'pull-right','style'=>'width: 90px;','label' => array('class'=>'control-label','text'=>__('Order').':'), 'options' => $orderBy, 'default'=>'0'))."</div>";
					echo $this->Form->input('page', array('type'=>'hidden','label'=>false,'value'=>'1','div'=>false));
					echo $this->Form->input('search', array('class'=>'form-control', 'style'=>'width:100%;margin: 10px 0;','placeholder'=>'Search','label'=>false,'div'=>false))."<br>";
					echo "<div class='text-center'>".$this->Form->button('Search', array('class'=>'btn btn-default text-center'))."</div>";
					echo $this->Form->end(); 
		?>
		</div>		
	</div>

	<div class="main"> 
		<div class="text-center" style="padding: 20px 0;"> <?php echo $this->Flash->render(); ?> </div>
		<?php echo $this->fetch('content'); ?>
	</div>
	<div class="aside">
		<div class="well box-shadow">
				<h4>Top 10 Product</h4>
				<table style="width: 100%;">
				<?php	foreach ($topProducts as $product) { ?>
						<tr><td>
						<?php 
							echo $this->Html->link($product['e']['name'], array(
								'controller'=>'products', 
								'action'=>'view', 
								$product['e']['slug']
							));
						?>
						</td><td style='text-align: right;'>
							<?php echo number_format($product[0]['rate'] ? $product[0]['rate'] : 0, 1); ?>
						</td></tr>
				<?php }	?>
				</table>
		</div>

		<div class="well box-shadow">
			<h4>Top 10 Discount</h4>
			<table style="width: 100%;">
				<?php	foreach ($eventProducts as $product) { ?>
						<?php 
							$discount = $product['d']['discount'] ? $product['d']['discount'] : 0;
							if ($discount > 0) { 
							?>
						<tr><td>
						<?php 
							echo $this->Html->link($product['e']['name'], array(
								'controller'=>'products', 
								'action'=>'view', 
								$product['e']['slug']
							));
						?>
						</td><td style='text-align: right;'>
							<?php echo '-'.$discount.'%'; ?>
						</td></tr>
					<?php } ?>
				<?php }	?>
				</table>
		</div>
	</div>

	<div class="footer text-center">
		<p><strong><i>Copyright by Computer Shop, 2011 - 2022</i></strong></p>
	</div>

</div>
</body>
</html>

<!--
<div class="col-md-10 col-md-offset-1">
<div class="carousel slide" data-ride="carousel" data-type="multi" data-interval="3000" id="myCarousel">
  <div class="carousel-inner">
    <div class="item active">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Plants/pineapple-96.png" class="img-responsive"></a></div>
    </div>
    <div class="item">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Plants/paprika-96.png" class="img-responsive"></a></div>
    </div>
    <div class="item">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Plants/avocado-96.png" class="img-responsive"></a></div>
    </div>
    <div class="item">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Food/banana-96.png" class="img-responsive"></a></div>
    </div>
    <div class="item">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Plants/onion-96.png" class="img-responsive"></a></div>
    </div>
    <div class="item">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Food/asparagus-96.png" class="img-responsive"></a></div>
    </div>
    <div class="item">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Plants/watermelon-96.png" class="img-responsive"></a></div>
    </div>
    <div class="item">
      <div class="col-md-2 col-sm-6 col-xs-12"><a href="#"><img src="https://maxcdn.icons8.com/Color/PNG/96/Food/eggplant-96.png" class="img-responsive"></a></div>
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
</div>
</div>
-->


<script>

var myCat = (function(){
	let catMenu = 'category';
	let catPrefix = 'cat_';
	let subCat = 'subCatMenu';
	let dataHolder = 'data-catId';
	
	let e = $('#'+subCat), m = $('#'+catMenu);
	
	let obj = {
		e, m,
		selected: null,
		select(index) {
			if (this.selected) {
				$('#'+catPrefix+this.selected).hide();
			}
				
			if (index) {
				$('#'+catPrefix+index).fadeIn();
				this.e.show();
			}else{
				this.e.hide();
			}
			
			this.selected = index;
		}	
	};
	
	$("body").click( function(e) {	
		if (e.target.getAttribute(dataHolder)) {
			e.preventDefault();
			obj.select(e.target.getAttribute(dataHolder));
		}else if(e.target.id !== subCat) {
			obj.select(null);
		}
	  }
	);
	

	obj.e.offset({ top: obj.m.offset().top, left: ($(window).width() > 768) ? (5+obj.m.width()+obj.m.offset().left) : 180});

	return obj
	
})($);

$('.carousel[data-type="multi"] .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i=0;i<4;i++) {
    next=next.next();
    if (!next.length) {
    	next = $(this).siblings(':first');
  	}
    
    next.children(':first-child').clone().appendTo($(this));
  }
});

</script>
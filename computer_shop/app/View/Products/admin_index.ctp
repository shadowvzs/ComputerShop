<div class="row">
	<nav class="col-xs-12 col-xs-offset-0 col-sm-12 col-md-12 text-center">
		<div class="navbar-header">
		<div style="display: flex;">
			<div class="dropdown navbar-form pu1ll-left">
					<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Categories
					<span class="caret"></span></button>
					<ul class="dropdown-menu">
						  <?php 
							  echo ($this->CategoryList->start($categories, $search));
						  ?>
					</ul>
					<?php echo $link = $this->Html->link("<div class='btn btn-info'>".__('Add Product')."</div>", array('controller'=>'products','action'=>'add'), array ('escape'=>false)); ?>
			</div>  
			
			<div class="dropdown navbar-form">
				<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Filter</button>
				<ul class="dropdown-menu list-group">
					<li style="width: 300px; padding: 10px;">
					<?php 
						$orderBy = array(
							'price_ASC'=>'Price ASC', 
							'price_DESC'=>'Price DESC',
							'name_ASC'=>'Name ASC', 
							'name_DESC'=>'Name DESC'
						);
						
						echo $this->Form->create('Product', array('url' => '','type' => 'get', 'class'=>'navbar-form'));
						echo "<div class='clearfix'>".$this->Form->input('category', array('class' => 'pull-right','style'=>'width: 150px;','label' => array('class'=>'control-label','text'=>__('Category').':'), 'options' => $categs, 'default'=>'0'))."</div>";
						echo "<div class='clearfix'>".$this->Form->input('brand', array('class' => 'pull-right','style'=>'width: 150px;','label' => array('class'=>'control-label','text'=>__('Brand').':'), 'options' => $brands, 'default'=>'0'))."</div>";
						echo "<div class='clearfix'>".$this->Form->input('classification', array('class' => 'pull-right','style'=>'width: 150px;','label' => array('class'=>'control-label','text'=>__('Series').':'), 'options' => $series, 'default'=>'0'))."</div>";
						echo "<div class='clearfix'>".$this->Form->input('accessory', array('class' => 'pull-right','style'=>'width: 150px;','label' => array('class'=>'control-label','text'=>__('Acc. set').':'), 'options' => $accessories, 'default'=>'0'))."</div>";
						echo "<div class='clearfix'>".$this->Form->input('condition', array('class' => 'pull-right','style'=>'width: 150px;','label' => array('class'=>'control-label','text'=>__('Condition').':'), 'options' => array('any'=>'Any', 'used'=>'Used', 'new'=>'New'), 'default'=>'0'))."</div>";
						echo "<div class='clearfix text-center' style='margin: 10px 0;'>";
							echo $this->Form->input('min_price', array('class'=>'form-control','style'=>'width: 100px;display:inline-block;', 'value'=>'','placeholder'=>'Min Price','label'=>false,'div'=>false)).' ';
							echo $this->Form->input('max_price', array('class'=>'form-control','style'=>'width: 100px;display:inline-block;','value'=>'','placeholder'=>'Max Price','label'=>false,'div'=>false));
						echo "</div>";
						echo "<div class='clearfix'>".$this->Form->input('orderby', array('class' => 'pull-right','style'=>'width: 150px;','label' => array('class'=>'control-label','text'=>__('Order by').':'), 'options' => $orderBy, 'default'=>'0'))."</div>";
						echo $this->Form->input('page', array('type'=>'hidden','label'=>false,'value'=>'1','div'=>false));
						echo $this->Form->input('search', array('class'=>'form-control', 'style'=>'width:100%;margin: 10px 0;','placeholder'=>'Search','label'=>false,'div'=>false))."<br>";
						echo "<div class='text-center'>".$this->Form->button('Search', array('class'=>'btn btn-default text-center'))."</div>";
						echo $this->Form->end; 
					?>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</div>

<div class="row text-center">
	<div class="col-xs-12 col-xs-offset-0 col-sm-12 col-md-12" style="display: flex; flex-direction: row;flex-wrap: wrap;">
		<?php 
		if (empty(${$model})) {
			echo "<h1 class='text-center'>sorry but no result</h1>";
		}else{
			$imgDir = "products/";
			foreach (${$model} as $row) { 
				$product = $row[$model];
				$imagePath = $imgDir.($row['ProductsImage']['name'] ? $row['ProductsImage']['name'] : 'default.jpg'); 
				$image = $this->Html->image($imagePath);
				$active = intval($product['active']);
				$activeStyle = $active === 1 ? '' : 'opacity: 0.6'; 
				$discount = $row['Discount'];
				$product_disc = $discount['price_modifier'] ? $discount['price_modifier'] : 0;
				if ($product_disc > 0) {
					$time = time();
					$time1 = strtotime($discount['start_date']);
					$time2 = strtotime($discount['end_date']);
					if ($time<$time1 || $time>$time2) {
						$product_disc = 0;
					}                                
				}
				$total_wo_vat = $product['price']  - ($product['price'] * ($user_discount+$product_disc) / 100);
				if ($total_wo_vat < 0) {$total_wo_vat = 0.01;}

				$total_price = ($total_wo_vat * $vat / 100 + $total_wo_vat);
				$total_price = ((round($total_price * 100))/100).' '.$server_currency;

				$addLink = $this->Html->link($this->Icon->icon('cart-plus','',true, 'blue', '24px'), 'javascript:void(0)', array('onclick' => 'addToCart('.$product['id'].');', 'escape' => false, 'title'=>'Add to cart'));
				$deleteLink = $this->Html->link($this->Icon->icon('delete','',true, 'red', '24px'),  array('controller' => 'products','action' => 'delete', $product['id']), array('escape' => false, 'title'=>'Permanently delete', 'confirm' => 'Are you sure?'));
				$link = $this->Html->link("<div class='imgHolder'>".$image."</div><div class='caption'><p>".$product['name']."</p></div>", array('controller'=>'products','action'=>'view',$product['id']), array ('class' => 'button', 'escape'=>false));
				echo "<div class='inline-product-thumbnail' style='".$activeStyle."'>".$link.$total_price."<div class='deleteProduct'>".$deleteLink."</div></div>";
			} 
		}
		?>	
	</div>
</div>

<div class="row">
	<div class="container text-center">
		<?php echo $search['paginator']; ?>
	</div>
</div>

<script>

function addToCart(product_id) {

var args = {
  _method: 'POST',
  data: {
	Cart : {
		product_id: product_id
	}
  }
};

$.post("carts/add", $.param( args ), function(data){
	$('#cart-counter').text(data);
	if (data) {
		$.notify("Added into cart...", "success");
	}else{
		$.notify("Failed to add into cart...", "warn");
	}

});	
}

</script>

<style>
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
}

.dropdown-menu .right-arrow {
	position: absolute;
	right:8px;
}

li.dropdown-submenu:hover > ul {
	display: block;
}
.inline-product-thumbnail:hover .deleteProduct {
	display:block;
}
.inline-product-thumbnail .deleteProduct {
	position: absolute; 
	right: 13px; 
	top:10px;
	display: none;
}
</style>
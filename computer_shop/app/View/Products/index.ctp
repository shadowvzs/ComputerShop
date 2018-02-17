<style>
	.inline-product-thumbnail:hover .deleteProduct, .inline-product-thumbnail:hover .addProduct {
		display:block;
	}
	.inline-product-thumbnail .deleteProduct, .inline-product-thumbnail .addProduct {
		position: absolute; 
		right: 13px; 
		top:10px;
		display: none;
	}
.myFlex {
	display: flex; 
	flex-wrap: wrap;
	justify-content: center;
	align-content: center;
}
.hiddenFlex {
	visibility: hidden;
	margin: 0 5px;
	height: 0;
 	padding: 3px;
	margin: 10px;
	width: 240px; 
	height: 240px; 
}
</style>

<div class="myFlex" style="">
	<?php 
	if (empty(${$model})) {
		echo "<h1 class='text-center'>sorry but no result</h1>";
	}else{
		$imgDir = "products/";
		foreach (${$model} as $row) { 
			$product = $row[$model];
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
			
			$imagePath = $imgDir.($row['ProductsImage']['name'] ? $row['ProductsImage']['name'] : 'default.jpg'); 
			$image = $this->Html->image($imagePath);
			$addLink = $this->Html->link($this->Icon->icon('cart-plus','',true, 'blue', '24px'), 'javascript:void(0)', array('onclick' => 'addToCart('.$product['id'].');', 'escape' => false, 'title'=>'Add to cart'));
			$link = $this->Html->link("<div class='imgHolder'>".$image."</div><div class='caption'><p>".$product['name']."</p></div>", array('controller'=>'products','action'=>'view', $product['slug']), array ('class' => 'button', 'escape'=>false));
			echo "<div class='inline-product-thumbnail'>".$link.$total_price."<div class='addProduct'>".$addLink."</div></div>";
		} 
	}
	?>	
	<?php	for ($i = 0; $i<2; $i++) { 	?>
		<div class="hiddenFlex"> </div>
	<?php	}	 ?>
</div>

<div class="text-center">
	<?php 
		echo $search['paginator']; 
	?>
</div>

<script>

function addToCart(product_id) {
	
	var idata = {
	  _method: 'POST',
	  data: {
		Cart : {
			product_id: product_id
		}
	  }
	};

	$.post("carts/add", $.param( idata ), function(data){
		$('#cart-counter').text(data);
		if (data) {
			$.notify("Added into cart...", "success");
		}else{
			$.notify("Failed to add into cart...", "warn");
		}
	});	
}


$('#products').addClass('active');

</script>

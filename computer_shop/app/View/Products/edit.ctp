<?php extract(${$model}); ?>

<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">
		
		<?php

		$item_discount = 0;
		$oldPrice = $Product['price'];
		$newPrice = $oldPrice;
		$time = time();
		
		if ($User['discount']>0) {
			$disc = ($oldPrice* $User['discount']) / 100;
			$user_discount = ' -'.$User['discount'].'% ('.$disc.')';
			$newPrice -= $disc; 
		}

		if ((strtotime($Discount['start_date']) <= $time) && (strtotime($Discount['end_date']) >= $time) && ($Discount['price_modifier']>0)) { 
			$disc = ($oldPrice* $Discount['price_modifier']) / 100;
			$item_discount = ' -'.$Discount['price_modifier'].'% ('.$disc.')';
			$newPrice -= $disc; 
		}

		if ($vat>0) {
			$newPrice = $newPrice + ($newPrice * $vat / 100);
		}
	
		$newPrice = (round($newPrice * 100))/100;

		if ($newPrice < 0) {$newPrice = 0.01;}
		
		$item_condition=['Used','New'];
		
		$cover_image_id = $Product['cover_image_id'];
		$filepath = null;
		
		if (intval($cover_image_id) > 0) {
			if (isset($ProductsImage[$cover_image_id])){
				$filepath = 'products/'.$ProductsImage[$cover_image_id];
			}
		}
		
        echo $this->Form->create('Cart',array('id'=>'add-form','url'=>array('controller'=>'carts','action'=>'add')));
        echo $this->Form->hidden('product_id',array('value'=>$Product['id']));
        echo $this->Form->submit('Add to cart',array('class'=>'btn-success btn btn-lg pull-right'));
        echo $this->Form->end();
			
		if ($filepath) {
			echo "<div class='text-center'>".$this->Html->image($filepath, array('alt' => __($model.' '.'logo'), 'style'=>'width:100%;max-width: 300px;'))."</div>";
		}
		
		$imageList = [];
		
		foreach($ProductsImage as $key => $image){
			$path = '/app/'.WEBROOT_DIR.'/img/products/'.$image;
			$imageList[] = $this->Html->image($path, array("alt" => $Product['name'], 'style' => 'width: 100px;','url'=>$path));
		}

		$filter = array();
		
		if ($Category['id'] != null && $Category['active'] == 1) {
			$filter[] = $this->Html->link($Category['name'], '/?category='.$Category['slug'], array('escape' => false));
		}
		if ($Brand['id'] != null && $Brand['active'] == 1) {
			$filter[] = $this->Html->link($Brand['name'], '/?brand='.$Brand['slug'], array('escape' => false));
		}
		if ($Classification['id'] != null && $Classification['active'] == 1) {
			$filter[] = $this->Html->link($Classification['name'], '/?classification='.$Classification['slug'], array('escape' => false));
		}
		if ($Accessory['id'] != null && $Accessory['active'] == 1) {
			$filter[] = $this->Html->link($Accessory['name'], '/?accessory='.$Accessory['slug'], array('escape' => false));
 		}
		
		echo $this->AdvHTML->rowGroup(array(
			'Review'=>${$model}['name'],
			'Images'=>empty($imageList) ? null : implode(', ', $imageList),
			'Tags'=> implode(' / ', $filter),
			'Condition'=>$item_condition[intval(${$model}['item_condition'])],
			'Product Discount'=>($item_discount===0 ? null : $item_discount),
			'Personal Discount'=>($user_discount===0 ? null : $user_discount),
			'Price'=>$oldPrice.' '.$server_currency,
			'Vat'=>$vat.'%',
			'Final Price'=>($oldPrice !== $newPrice ? $newPrice.' '.$server_currency : null),
			'Specification'=>${$model}['short_content'],
			'Description'=>${$model}['content'],

		));
		
		?>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
    $('#add-form').submit(function(e){
        e.preventDefault();
        var tis = $(this);
        $.post(tis.attr('action'), tis.serialize(), function(data){
			$('#cart-counter').text(data);
			
        });
    });
});
</script>
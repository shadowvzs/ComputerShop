<?php extract(${$model}); ?>
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">
		
		<?php

		$item_discount = 0;
		$user_discount = 0;
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
		
		$newPrice = (round($newPrice * 100))/100;

		if ($newPrice < 0) {$newPrice = 0.01;}
		
		$status=['Inactive','Active'];
		$item_condition=['Used','New'];
		
		$cover_image_id = $Product['cover_image_id'];
		$filepath = null;
		
		if (intval($cover_image_id) > 0) {
			if (isset($ProductsImage[$cover_image_id])){
				$filepath = 'products/'.$ProductsImage[$cover_image_id];
			}
		}
		
		if ($filepath) {
			echo $this->Html->image($filepath, array('alt' => __($model.' '.'logo'), 'style'=>'width:100%;'));
		}
		
		$imageList = [];
		$i=0;
		foreach($ProductsImage as $key => $image){
			$i++;
			$imageList[] = $this->Html->link("image".$i, '/app/'.WEBROOT_DIR.'/img/products/'.$image);
		}

		
		echo $this->AdvHTML->rowGroup(array(
			'Category'=>$this->Html->link($Category['name'], array('controller'=>'categories','action' => 'view', $Category['id']), array('escape' => false)),
			'Brand'=>$this->Html->link($Brand['name'], array('controller'=>'brands','action' => 'view', $Brand['id']), array('escape' => false)),
			'Series'=>$this->Html->link($Classification['name'], array('controller'=>'classifications','action' => 'view', $Classification['id']), array('escape' => false)),
			'Part of'=>$this->Html->link($Accessory['name'], array('controller'=>'accessories','action' => 'view', $Accessory['id']), array('escape' => false)),
			'Name'=>${$model}['name'],
			'Score'=>$Score,
			'Images'=>empty($imageList) ? null : implode(', ', $imageList),
			'Status'=>$status[intval(${$model}['active'])],
			'Condition'=>$item_condition[intval(${$model}['item_condition'])],
			'Product Discount'=>($item_discount===0 ? null : $item_discount),
			'Personal Discount'=>($user_discount===0 ? null : $user_discount),
			'Price'=>$oldPrice.' '.$server_currency,
			'Final Price'=>($oldPrice !== $newPrice ? $newPrice.' '.$server_currency : null),
			'Short Content'=>${$model}['short_content'],
			'Content'=>${$model}['content'],
			'Meta Title'=>${$model}['meta_title'],
			'Meta Description'=>${$model}['meta_description'],
			'Meta Keywords'=>${$model}['meta_keyword'],
			'Created'=>${$model}['created'],
			'Updated'=>${$model}['updated']
		));
		
		echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 
		?>
		</div>
	</div>
</div>
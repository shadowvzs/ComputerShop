<?php
	echo $this->Html->css('combine.php?combine='.implode(',', array('star-rating.min')), false, array('inline' => false));
	echo $this->Html->script('combine.php?combine='.implode(',', array('star-rating.min,comment')), false, array('inline' => false));
?>
<?php extract(${$model}); ?>
<br>
	<div class="panel panel-default" style="max-width: 500px;margin: auto;">
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
				
  		if (AuthComponent::user('id')) {
			echo "<div class='clearfix'>";
			echo "<input id='input-7-xs' class='rating rating-loading' value='2' data-productid='".${$model}['id']."' data-min='0' data-max='5' data-step='0.5' data-size='xs'><hr/>";
			echo "</div>";
		}
			
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
			'Name'=>${$model}['name'],
			'Score'=>"<span id='score'>".$Score."</span>",
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
	<?php if (AuthComponent::user('id')) { ?>
		<br><br>
		<div class="panel panel-default" style="max-width: 500px;margin: auto;">
			<div class="panel-heading text-center"> Feedbacks </div>
			<div class="panel-body">
				<div class="margin-10 text-left" id="commentsListDiv"></div>
				<div class="margin-10" id="commentsPager">pager</div>
				<textarea id="commentField" class="commentField"> </textarea>
				<input type="submit" id="commentSubmit">
			</div>
		</div>
	<?php } ?>
<br>

<script>
// i would declare insid of comments class but then not instantly because comments objct created aftr page loaded :D
var formData = (function(){
		var userId = parseInt("<?php echo $thisUser['id']; ?>", 10);
		var userName = "<?php echo $thisUser['first_name'].' '.$thisUser['last_name']; ?>";
		var userEmail = "<?php echo $thisUser['email']; ?>";
		var productId = parseInt("<?php echo $Product['id']; ?>", 10);					
	return {
		getUserId: function() { return userId; },
		getUserName: function() { return userName; },
		getUserEmail: function() { return userEmail; },
		getProductId: function() { return productId; }
	}
})();

//need declare globally
var comments;

$(document).ready(function(){

	comments = new CommentList(null);

	$('#commentSubmit').click(function(e){
		comments.addComment();
	});

	//-----------------------------
	$("#input-7-xs").rating("refresh", {showClear:false});

    $("#input-7-xs").rating().on("rating:change", function(event, value, caption) {
		var tis = $(this);
		var idata = {
			_method: 'POST',
			data: {
				Review : {
					product_id: tis.data('productid'),
					rate: tis.val(),
				}
			}
		};
			
		$.post("../../products/review", $.param( idata ), function(data) {
			if (data) {
				if (data == -1) {
					$.notify("You must login...");
					return;
				}
				tis.val(data);
				tis.rating("refresh");
				$("#score").html(data);
				$.notify("Added "+value+" point...", "success");
			}else{
				alert('eeee');
				$.notify("Sorry went wrong...", "warn");
			}
		});

		tis.rating("refresh", {disabled:true});	
    });

    $('#add-form').submit(function(e){
        e.preventDefault();
        var tis = $(this);
        $.post(tis.attr('action'), tis.serialize(), function(data){
			$.notify("Added into cart...", "success");
			$('#cart-counter').text(data);
			
        });
    });	

});

</script>
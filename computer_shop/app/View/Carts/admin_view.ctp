<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('Home', array('controller'=>'products', 'action'=>'index')); ?>
		</li>
		<li class="active">Cart</li>
	</ol>
</div>

 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
   <?php echo $this->Form->create('Cart',array('url'=>array('action'=>'update')));?>
   <?php echo $this->Form->submit('Update',array('class'=>'btn btn-warning', 'style'=>'position: absolute;top:-55px;right:0;','div'=>false)); ?>
	<table class="table">
		<thead>
			<tr>
				<th>Product Name</th>
				<th>Init Price</th>
				<th>Promo (%)</th>
				<th>Item Quantity</th>
				<th>Vat (<?php echo $vat; ?>%)</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php $final=0;?>
			<?php foreach ($products as $product) { $prod=$product['Product'];$disc=$product['Discount']; ?>
			<tr id="row_<?php echo $prod['id']; ?>">
				<td><?php echo $prod['name'];?></td>
				<td><?php echo $prod['price'];?></td>
				<td><?php 
						$prod_discount = $disc['price_modifier'] ? $disc['price_modifier'] : 0;
						if ($prod_discount > 0) {
							$time = time();
							$time1 = strtotime($disc['start_date']);
							$time2 = strtotime($disc['end_date']);
							if ($time<$time1 || $time>$time2) {
								$prod_discount = 0;
							}                                
						}
						echo $prod_discount; 
					?>
				</td>
				<td><div style='width:60px;'>
						<?php 
							echo $this->Form->hidden('product_id.',array('value'=>$prod['id']));
							echo $this->Form->input('count.',array('type'=>'number', 'label'=>false,
								'class'=>'form-control input-sm', 'value'=>$prod['count']));
							
							$unit_price_wo_vat = $prod['price']  - ($prod['price'] * ($user_discount+$prod_discount) / 100);
							$unit_price_wo_vat =  (round($unit_price_wo_vat * 100))/100;

							if ($vat > 0) {
								$unit_price_w_vat = $unit_price_wo_vat  + ($unit_price_wo_vat * $vat / 100);
								$unit_price_w_vat =  (round($unit_price_w_vat * 100))/100;
							}else{
								$unit_price_w_vat = $unit_price_wo_vat;
							}

							$stack_price_wo_vat = $unit_price_wo_vat * $prod['count'];
							$stack_price_w_vat = $unit_price_w_vat * $prod['count'];
						?>
					</div>
				</td>
				<td><?php echo ($stack_price_w_vat-$stack_price_wo_vat); ?> </td>
				<td>
					<?php 
					echo $stack_price_w_vat; 
					echo ' '.$this->Html->link($this->Icon->icon('delete','',true, 'red', '16px'), 'javascript:void(0)', array('onclick' => "$('#row_".$prod['id']."').remove();document.getElementById('CartUpdateForm').submit();", 'escape' => false, 'class'=>'pull-right', 'title'=>'Remove this item'));
					?> 
					
				</td>
			</tr>
			<?php 
				$final = $final + $stack_price_w_vat;
				$count=0;
			}
			?>
			<tr class="success">
				<td colspan=5><b>Discount: <?php echo $user_discount; ?>% </b></td>
				<td><?php echo '<b>'.((round($final * 100))/100).'</b> '.$server_currency; ?></td>
			</tr>
		</tbody>
	</table>
	<?php echo $this->Form->end();?>


	<div class="panel panel-default pull-right" style="min-wdth: 200px;max-width:400px;width:100%;">
		<div class="panel-heading"><strong>Order data</strong></div>
		<div class="panel-body">
		<?php 
			echo $this->Form->create('Cart',array('url'=>array('controller'=>'orders','action'=>'add','div'=>false)));

			$attributes = array(
				'legend' => false,
				'value' => '0',
				'label' => array('style'=>'margin: 5px 20px 5px 5px;')
			);
			
			echo $this->Form->radio('clientType',  array( '0' => __('Physical Person'), '1' => __('Corporation')), $attributes).'<br>';
			echo $this->Form->radio('paymentType',  array(  '0' => __('Post Payment'), '1' => __('Bank Transaction')), $attributes).'<br>';

			if (AuthComponent::user('id')) {
				echo $this->Form->submit('Order',array('class'=>'btn btn-success pull-right', 'style'=>'width: 100px;','div'=>false)); 
			}else{
				echo $this->Html->link('Login', array('controller'=>'users', 'action'=>'login'), array('class'=>'btn btn-info pull-right', 'style'=>'width: 100px;'));
			}
		?>            
		</div>
	</div>
</div>
	
<script>
	$('#menuMyCart').addClass('active');
</script>
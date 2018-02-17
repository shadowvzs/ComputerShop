<br>
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><h3><?php echo __('Order')." #".${$model}[$model]['id']; ?></h1></div>
		<div class="panel-body">
		
		<?php
		$order = ${$model}[$model];
		$orderedItems = ${$model}['OrdersProduct'];
		echo $this->Form->create($model);
	
		foreach ($orderedItems as $item){
			$item = $item['OrdersProduct'];
			echo "<div class='clearfix'>".$this->Form->input('order_id_'.$item['id'], array('class' => 'pull-right','style'=>'resize:none;','value'=>'','label' => array('class'=>'control-label','text'=>__($item['product_name']).':'), 'value'=>$item['amount'] ))."</div>";
		}

		$options = array(
			'div' => false,
			'label' => __('Save'),
			'class' => 'btn btn-primary text-center col-xs-4 col-xs-offset-4  col-sm-2 col-sm-offset-5 margin-top-20'
		);

		echo $this->Form->end($options);

		//echo $this->Html->link('Edit',array('controller'=>'orders','action' => 'edit', $order['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 
		?>
		</div>
	</div>
</div>
<br>
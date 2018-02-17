<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><h3><?php echo __('Order')." #".${$model}[$model]['id']; ?></h1></div>
		<div class="panel-body">
		
		<?php
		$order = ${$model}[$model];
		$orderedItems = ${$model}['OrdersProduct'];
		$active=['Inactive','Active'];
		$status = array ("on wait", "prepared", "at courier", "arrived", "returned");
		$updatedAt = " <i>(".$this->Time->niceShort($order['updated']).")</i>";
				
		echo $this->AdvHTML->rowGroup(array(
			'Active:'=>$active[intval($order['active'])],
			'Status:'=>$status[intval($order['status'])].$updatedAt,
			'Price [normal]:'=> $order['price_sub_total']." ".$server_currency,
			'Price [vat]:'=> $order['price_vat']." ".$server_currency,
			'Price [total]:'=> $order['price_total']." ".$server_currency,
		));

		$list_output["<font size='4'><u>Name</u></font>"] = "<font size='4'><b><u>Price</u></b></font>";
		
		foreach ($orderedItems as $item){
			$item = $item['OrdersProduct'];
			$col1 = $this->Html->link($item['product_name'], array('controller'=>'products', 'action'=>'index', null, "?"=>array("search"=>$item['product_name'])), array('escape'=>false));
			$col2 = $item['amount']." x <b>".$item['price']." ".$server_currency."</b>";
			$list_output[$col1] = $col2;
		}
		
		echo "<br><br>";		
		echo $this->AdvHTML->rowGroup($list_output);
		
		if ($order['status'] <= $editLevel) {
			echo $this->Html->link('Edit',array('controller'=>'orders','action' => 'edit', $order['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 
		}
		?>
		</div>
	</div>
</div>
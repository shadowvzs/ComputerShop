<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"> 
			<b>View Review:</b> #<?php echo ${$model}[$model]['id']; ?>
		</div>
		<div class="panel-body">
		<?php
		
		//create user and product link
		
		$feedback = ${$model}[$model];
		$user = ${$model}['User'];
		$product = ${$model}['Product'];

		$userLink = $this->Html->link($user['username'], array(
			'controller'=>'users',
			'action'=>'view',
			$user['id']
		));
		
		$productLink = $this->Html->link($product['name'], array(
			'controller'=>'products',
			'action'=>'view',
			$product['id']
		));
		
		$status=['Inactive','Active'];
		echo $this->AdvHTML->rowGroup(array(
			'Given Rate'=>$feedback['rate'],
			'Status'=>$status[intval($feedback['active'])],
			'User'=>$userLink,
			'Product'=>$productLink,
			'Created'=>$feedback['created'],
			'Updated'=>$feedback['updated']
		));
		
		?>
		</div>
	</div>
</div>
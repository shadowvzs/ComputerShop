<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">

		<?php
		$status=['Inactive','Active'];
		$discount = '- '.${$model}['price_modifier'].' %';
		echo $this->AdvHTML->rowGroup(array(
			'Name'=>${$model}['name'],
			'Status'=>$status[intval(${$model}['active'])],
			'Price Modifier'=>$discount,
			'Offer started'=>$this->Time->niceShort(${$model}['start_date']),
			'Offer End'=>$this->Time->niceShort(${$model}['end_date']),
		
			'Created'=>$this->Time->niceShort(${$model}['created']),
			'Updated'=>$this->Time->niceShort(${$model}['updated'])
		));
		

			echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 

		?>
		</div>
	</div>
</div>
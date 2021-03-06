<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">

		<?php
		$status=['Inactive','Active'];
		echo $this->AdvHTML->rowGroup(array(
			'Name'=>${$model}['name'],
			'Status'=>$status[intval(${$model}['active'])],
			'Content'=>${$model}['content'],
			'Language'=>${$model}['language'],
			'Address'=>${$model}['address'],
			'Phone'=>${$model}['phone'],
			'VAT'=>${$model}['vat'].'%',
			'Currency'=>${$model}['currency'],
			'Created'=>$this->Time->niceShort(${$model}['created']),
			'Updated'=>$this->Time->niceShort(${$model}['updated'])
		));
		

			echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 

		?>
		</div>
	</div>
</div>
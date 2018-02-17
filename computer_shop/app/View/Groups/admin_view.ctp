<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">
		<?php
		$status=['Inactive','Active'];
		echo $this->AdvHTML->rowGroup(array(
			'Name'=>${$model}['name'],
			'Status'=>$status[intval(${$model}['active'])],
			'Email'=>${$model}['email'],
			'Phone'=>${$model}['phone'],
			'Address'=>${$model}['address'],
			'Created'=>${$model}['created'],
			'Updated'=>${$model}['updated']
		));
		echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 
		?>
		</div>
	</div>
</div>
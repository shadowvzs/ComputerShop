<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo $user['username']; ?></div>
		<div class="panel-body">
		<?php
		$status=['Unconfirmed','Confirmed'];
		echo $this->AdvHTML->rowGroup(array(
			'Full name'=>$user['first_name'].' '.$user['last_name'],
			'Group'=>$groups[$user['group_id']],
			'Account'=>$status[intval($user['active'])],
			'Phone'=>$user['phone'],
			'Email'=>$user['email'],
			'Country'=>$country['name'],
			'Adress'=>$user['city'].($user['address'] ? ', '.$user['address']:'').($user['postal_code'] ? ', '.' ['.$user['postal_code'].']' : ''),
			'Company Name'=>$user['company_name'],
			'Discount'=>$user['discount'],
			'Created'=>$user['created'],
			'Updated'=>$user['updated']
		));
		echo $this->Html->link('Edit',array('controller'=>'users','action' => 'edit', $user['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 
		?>
		</div>
	</div>
</div>
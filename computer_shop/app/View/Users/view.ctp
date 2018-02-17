<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center">My Profile</div>
		<div class="panel-body">
		<?php
		$status=['Unconfirmed','Confirmed'];
		echo $this->AdvHTML->rowGroup(array(
			'Full name'=>$user['first_name'].' '.$user['last_name'],
			'Group'=>$user['group_id'] < 4 ? $groups[$user['group_id']] : null,
			'Account'=>$status[intval($user['active'])],
			'Phone'=>$user['phone'],
			'Email'=>$user['email'],
			'Country'=>$country['name'],
			'Adress'=>$user['city'].($user['address'] ? ', '.$user['address']:'').($user['postal_code'] ? ', '.' ['.$user['postal_code'].']' : ''),
			'Company Name'=>$user['company_name'],
		));
		echo $this->Html->link('Edit','/settings', array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 
		?>
		</div>
	</div>
</div>
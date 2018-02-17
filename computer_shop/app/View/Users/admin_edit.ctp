<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo $user['username']; ?></div>
		<div class="panel-body">
				
<?php 
	echo $this->Form->create('User');
	if (AuthComponent::user('id1') == $user['id']) {
		echo $this->Form->input(
					'group_id',
					array(
						'style'=>'width:150px;',
						'class' => 'pull-right',
						'label' => __('Group').':',
						'type' => 'select',
						'selected'=>$user['group_id'],
						'options' => $groups
		));
	}
	
	echo $this->AdvForm->selectOnOff('active',$user['active']);
	echo $this->Form->input('Country:',array('type'=>'select','style'=>'width: 200px;','selected'=>$user['country_id'],'name'=>'data[User][country_id]','class'=>'pull-right','options'=>$countries));
	
	echo $this->AdvForm->inputGroup(array(
		'first_name'=>'First name',
		'last_name'=>'Last name',
		'phone'=>'Phone number',
		'email'=>'Email',
		'city'=>'City',
		'address'=>'Address',
		'postal_code'=>'Postal code',
		'company_name'=>'Company name',
		'number_coc'=>'COC number',
		'number_vat'=>'VAT number',
		'bic'=>'BIC',
		'iban'=>'IBAN',
		'discount'=>'Discount'
	), $user);

	$options = array(
		'div' => false,
		'label' => __('Save'),
		'class' => 'btn btn-primary text-center col-xs-2 col-xs-offset-5 margin-top-20'
	);
	echo $this->Form->end($options);
	?>
		</div>
	</div>
</div>
<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading text-center">Settings</div>
		<div class="panel-body">
				
		<?php 
			echo $this->Form->create('User');

			echo '<div class="clearfix">'.$this->Form->input('Country:',array('type'=>'select','style'=>'width: 200px;','selected'=>$user['country_id'],'name'=>'data[User][country_id]','class'=>'pull-right','options'=>$countries)).'</div>';
			
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
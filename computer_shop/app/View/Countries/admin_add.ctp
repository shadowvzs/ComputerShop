<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo __('Create new '.$model); ?></div>
		<div class="panel-body">
				
		<?php 
			echo $this->Form->create($model);
			echo $this->AdvForm->selectOnOff('active',1);

			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
				'content'=>'Content',
				'language'=>'Language',
				'address'=>'Address',
				'phone'=>'Phone',
				'vat'=>'VAT',
				'currency'=>'Currency',
				'vat'=>'VAT (%)',
			), null);

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
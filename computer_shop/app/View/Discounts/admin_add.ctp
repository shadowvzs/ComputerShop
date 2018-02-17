<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo __('Create new '.$model); ?></div>
		<div class="panel-body">
				
		<?php 
			echo $this->Form->create($model);
			echo $this->AdvForm->selectOnOff('active',1);

			echo "<div class='clearfix'><span class='font-weight-bold'>Offer start at:</span>".$this->Form->text('start_date',array('type' => 'date', 'class' => 'control-label pull-right'))."</div>";
			echo "<div class='clearfix'><span class='font-weight-bold'>Offer end at:</span>".$this->Form->text('end_date',array('type' => 'date', 'class' => 'control-label pull-right'))."</div>";
			
			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
				'price_modifier'=>'Discount (%)',
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
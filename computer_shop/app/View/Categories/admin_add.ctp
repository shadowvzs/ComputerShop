<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo __('Create new '.$model); ?></div>
		<div class="panel-body">
				
		<?php 
			echo $this->Form->create($model, array('enctype' => 'multipart/form-data'));
			
			echo $this->Form->input(
						'parent_id',
						array(
							'style'=>'width:150px;',
							'class' => 'pull-right',
							'label' => __('Parent menu').':',
							'type' => 'select',
							'selected'=>0,
							'options' => array_merge(['No parent'], $categories)
			));
			
			echo $this->AdvForm->selectOnOff('active',1);
			
			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
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
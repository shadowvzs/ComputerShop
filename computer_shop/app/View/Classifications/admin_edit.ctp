<?php
	$assocModel=isset(${$model}[$assocModel]) ? ${$model}[$assocModel] : null;
	${$model}=${$model}[$model];
?>
<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12" style='min-width:300px;'>
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">
				
		<?php 
			echo $this->Form->create($model, array('enctype' => 'multipart/form-data'));
			echo $this->Form->input(
						'brand_id',
						array(
							'style'=>'width:150px;',
							'class' => 'pull-right',
							'label' => __('Brand').':',
							'type' => 'select',
							'selected'=>${$model}['brand_id'],
							'options' => $brands
			));

			echo $this->Form->input(
				'category_id',
				array(
					'style'=>'width:150px;',
					'class' => 'pull-right',
					'label' => __('Category').':',
					'type' => 'select',
					'selected'=>${$model}['category_id'],
					'options' =>  $categories
			));

			echo $this->AdvForm->selectOnOff('active',${$model}['active']);
			
			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
				'meta_title'=>'Meta Title',
				'meta_description'=>'Meta Description',
				'meta_keyword'=>'Meta Keywords',
			), ${$model});		
			$options = array(
				'div' => false,
				'label' => __('Save'),
				'class' => 'btn btn-primary text-center col-xs-4 col-xs-offset-4  col-sm-2 col-sm-offset-5 margin-top-20'
			);

			echo $this->Form->end($options);
		?>	
		</div>
	</div>
</div>
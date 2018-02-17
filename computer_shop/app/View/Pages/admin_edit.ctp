<?php
	${$model}=${$model}[$model];
?>
<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12" style='min-width:300px;'>
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">
				
		<?php 
		
			echo $this->Form->create($model, array('enctype' => 'multipart/form-data'));
			
			echo $this->AdvForm->selectOnOff('active',${$model}['active']);
			echo $this->AdvForm->selectOnOff('header',${$model}['header']);
			echo $this->AdvForm->selectOnOff('aside',${$model}['aside']);
			echo $this->AdvForm->selectOnOff('footer',${$model}['footer']);

			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
				'short_content'=>'Short content',
				'content'=>'Content',				
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
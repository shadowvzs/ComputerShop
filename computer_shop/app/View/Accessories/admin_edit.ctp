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

			echo "<div class='clearfix'>".$this->AdvForm->selectOnOff('active',${$model}['active'])."</div>";
			
			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
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
<div class="panel panel-default col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<div class="panel-heading panel-title font-weight-bold">
		<?php echo __($model.' list'); ?>
	</div>
	
	<div class="panel-body">
		<table class='table table-dark table-striped'>
		
			<?php 
			foreach (${$model} as $f) { 
				$feedback = $f[$model];
				echo $this->Html->tableCells(
				array(
					array(
						$this->Icon->isActive($feedback['comment'], $feedback['active']), 
						$this->Html->div('pull-right', $this->TimeDifference->fromNow($feedback['created'], true).'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->AdminAction->mixTool($feedback['id'], 9, $model, $feedback['active']))
					)
				));
			} ?>	
			
		</table>
		<?php
			echo $this->Paginator->numbers();
		?>
	</div>
</div>
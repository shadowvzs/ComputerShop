<div class="panel panel-default col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<div class="panel-heading panel-title font-weight-bold">
		<?php echo __($model.' list'); ?>
		<div class="pull-right"> 
			<?php echo $this->Html->link($this->Icon->icon('plus-square','',true,  'blue', '18px'), array('controller'=>$controller,'action' => 'add'), array('escape' => false)); ?> 
		</div>
	</div>
	
	<div class="panel-body">
		<table class='table table-dark table-striped'>
			
			<?php 
			foreach (${$controller} as $g) { $g=$g[$model];
				//($g['id'], 7, 'Brand', $g['active'], 'active')
				echo $this->Html->tableCells(
				array(
					array(
						$this->Icon->isActive($g['name'], $g['active']), 
						$this->Html->div('pull-right', $this->TimeDifference->fromNow($g['created'], true).'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->AdminAction->mixTool($g['id'], 15, $model, $g['active']))
					)
				));
			} ?>	
			
		</table>
		<?php
			echo $this->Paginator->numbers();
		?>
	</div>
</div>
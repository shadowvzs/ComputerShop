<div class="panel panel-default col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<div class="panel-heading panel-title font-weight-bold">
		<?php echo __($model.' list'); ?>
		<!-- here was option for add new group but honestly it is pointless to a client if he can't edit the rules for that group -->
	</div>
	
	<div class="panel-body">
		<table class='table table-dark table-striped'>
		
			<?php 
			$my = ($this->Session->read('Auth.User')); 
			$roleColors = array('default','red','purple','blue','default');

			foreach (${$controller} as $g) { $g=$g[$model];if (intval($g['id'])<intval($my['group_id'])){continue;} 
			
				echo $this->Html->tableCells(
				array(
					array(
						$this->Icon->isActive($g['name'], $g['active'], $roleColors[$g['id']]), 
						$this->Html->div('pull-right', $this->TimeDifference->fromNow($g['created'], true).'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->AdminAction->forUsers($g['id'], $model, $g['active']))
					)
				));
			} ?>	
			
		</table>
		<?php
			echo $this->Paginator->numbers();
		?>
	</div>
</div>
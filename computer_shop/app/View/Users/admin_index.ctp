	<div class="panel panel-default col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
		<div class="panel-heading panel-title font-weight-bold">
			User list 
			<div class="pull-right"> 
				<?php echo $this->Html->link($this->Icon->icon('user-plus','',true,  'blue', '18px'), array('controller' => 'users','action' => 'add'), array('escape' => false)); ?> 
			</div>
		</div>
		<div class="panel-body">
			<table class='table table-dark table-striped'>
				<?php foreach ($users as $user) { ?>
					<?php 
						$user = $user['User'];

						if (intval($user['group_id']) == 1) {
							continue;
						}
					?>
					<tr>
						<td><?php  echo  $this->Icon->isActive($user['username'], $user['active'], $user['group_id'] == 1 ? 'red' : 'default'); ?></td>
						<td style='width: 100px;'><div class='pull-right' title='<?php echo $user["created"]; ?>'><?php echo $this->Time->timeAgoInWords($user["created"],array('format' => 'F jS, Y', 'end' => '+1 year'));?></div></td>
						<td style='width: 80px;'>
							<div class='pull-right'>
								<?php 
									echo ($this->AdminAction->forUsers($user['id'], 'user', $user['active'])); 
								?>
							</div>
						</td>
					</tr>
				<?php } ?>	
			</table>
			<?php
				echo $this->Paginator->numbers();
			?>
		</div>
	</div>
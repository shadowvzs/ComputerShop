<div class="panel panel-default col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<div class="panel-heading panel-title font-weight-bold">Messages</div>
	<div class="panel-body">
		<table class='table table-dark table-striped'>
			<?php foreach ($contacts as $c){ $c=$c['Contact'];?>
			<tr>
				<td>
					<?php  echo  $this->Icon->isActive($c['email'], $c['active']); ?>
				</td>
				<td style='width: 100px;'><div class='pull-right' title='<?php echo $c["created"]; ?>'><?php echo $this->Time->timeAgoInWords($c["created"],array('format' => 'F jS, Y', 'end' => '+1 year')); ?></div></td>
				<td style='width: 80px;'>
					<div class='pull-right'>
					<?php
						echo ($this->AdminAction->forMessage($c['id'], 'contact', $c['active'])); 
					?>
					</div>
				</td>
			</tr>
			<?php } ?>	
		</table>		
	</div>
</div>
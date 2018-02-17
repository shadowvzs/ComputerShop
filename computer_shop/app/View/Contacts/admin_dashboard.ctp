<?php

//debug ($groups);

?>

<div class="panel panel-default">
	<a href="#messageList" data-toggle="collapse">
		<div class="panel-heading panel-title font-weight-bold">Last 10 Message</div>
	</a>
	<div class="panel-body collapse" id="messageList">
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

<div class="panel panel-default">
	<a href="#userList" data-toggle="collapse">
		<div class="panel-heading panel-title font-weight-bold">Last 10 User</div>
	</a>
	<div class="panel-body collapse" id="userList">
		<table class='table table-dark table-striped'>
			<?php foreach ($users as $u) { $u=$u['User']; if (intval($u['group_id'])==1){continue;}?>
			<tr>
				<td>
					<?php  echo  $this->Icon->isActive($u['username'], $u['active'], $u['group_id'] == 1 ? 'red' : 'default'); ?>
				</td>
				<td style='width: 100px;'><div class='pull-right' title='<?php echo $u["created"]; ?>'><?php echo $this->Time->timeAgoInWords($u["created"],array('format' => 'F jS, Y', 'end' => '+1 year')); ?></div></td>
				<td style='width: 80px;'>
					<div class='pull-right'>
					<?php 
						echo ($this->AdminAction->forUsers($u['id'], 'user', $u['active'])); 
					?>
					</div>
				</td>
			</tr>
			<?php } ?>	
		</table>
	</div>
</div>

<div class="panel panel-default">
	<a href="#orderList" data-toggle="collapse">
		<div class="panel-heading panel-title font-weight-bold">Last 10 Order</div>
	</a>
	<div class="panel-body collapse" id="orderList">
		<table class='table table-dark table-striped'>
			<?php foreach ($orders as $o) { $o=$o['Order']; ?>
			<tr>
				<td>
					<?php  echo  $this->Icon->isActive(__('Order').' #'.$o['id'], $o['active']); ?>
				</td>
				<td style='width: 100px;'><div class='pull-right' title='<?php echo $o["created"]; ?>'><?php echo $this->Time->timeAgoInWords($o["created"],array('format' => 'F jS, Y', 'end' => '+1 year')); ?></div></td>
				<td style='width: 80px;'>
					<div class='pull-right'>
					<?php 
						echo ($this->AdminAction->mixTool($o['id'], 3, 'order', $o['active'])); 
					?>
					</div>
				</td>
			</tr>
			<?php } ?>	
		</table>
	</div>
</div>

<div class="panel panel-default">
	<a href="#productList" data-toggle="collapse">
		<div class="panel-heading panel-title font-weight-bold">Last 10 Product</div>
	</a>
	<div class="panel-body collapse" id="productList">
		<table class='table table-dark table-striped'>
			<?php foreach ($products as $p) { $p=$p['Product']; ?>
			<tr>
				<td>
					<?php  echo  $this->Icon->isActive($p['name'], $p['active']); ?>
				</td>
				<td style='width: 100px;'><div class='pull-right' title='<?php echo $p["created"]; ?>'><?php echo $this->Time->timeAgoInWords($p["created"],array('format' => 'F jS, Y', 'end' => '+1 year')); ?></div></td>
				<td style='width: 80px;'>
					<div class='pull-right'>
					<?php 
						echo ($this->AdminAction->mixTool($p['id'], 3, 'order', $p['active'])); 
					?>
					</div>
				</td>
			</tr>
			<?php } ?>	
		</table>
	</div>
</div>

<div class="panel panel-default">
	<a href="#discountList" data-toggle="collapse">
 		<div class="panel-heading panel-title font-weight-bold">Last 10 Discount (after end date)</div>
	</a>
	<div class="panel-body collapse" id="discountList">
		<table class='table table-dark table-striped'>
			<?php foreach ($discounts as $d) { $d=$d['Discount']; ?>
			<tr>
				<td>
					<?php  
						$end_date = strtotime($d['end_date']);
						$active = ((time() < $end_date) && ($d['active'])) ? 1 : 0;
						echo  $this->Icon->isActive($d['name'].' ( -'.$d['price_modifier'].'%)', $active); 
					?>
				</td>
				<td style='width: 100px;'><div class='pull-right' title='<?php echo $d["end_date"]; ?>'><?php echo $this->Time->nice($d["end_date"]); ?></div></td>
				<td style='width: 80px;'>
					<div class='pull-right'>
					<?php 
						echo ($this->AdminAction->mixTool($d['id'], 3, 'order', $d['active'])); 
					?>
					</div>
				</td>
			</tr>
			<?php } ?>	
		</table>
	</div>
</div>

<script>
	$('#menuContact').addClass('active');
</script>
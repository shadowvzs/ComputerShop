<div class="panel panel-default col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" style="min-width: 300px;">
	<div class="panel-heading panel-title font-weight-bold clearfix" style="padding: 0;">
		<div style="padding: 10px 10px; display:inline-block;font-size: 20px;">
			<?php echo __($model.' list'); ?>
		</div>
		<div class='pull-right navbar-form'> 
			<?php 
				echo $this->Form->create('Order', array('url' => '','type' => 'post', 'class'=>''));
				echo $this->Form->input('order_id', array('class'=>'form-control','type'=>'text','placeholder'=>'Order Id: #4', 'style'=>'width:200px;','label'=>false,'div'=>false));
				echo $this->Form->end; 
			?> 
		</div>
	</div>
	
	<div class="panel-body">
		<table class='table table-dark table-striped'>
		
			<?php
			$active = array ("inactive", "active");
			$status = array ("on wait", "prepared", "at courier", "arrived", "returned");
			foreach (${$model} as $d) { $d=$d[$model];
				$linkText = "Order <i>".$d['price_total']." ".$server_currency."</i>";
				if ($d['active'] == '1')  { $linkText = "<b>".$linkText."</b>"; }
				//echo ($this->AdminAction->forUsers($u['id'], 'user', $u['active'])); 
				echo $this->Html->tableCells(
				array(
					array(
						$link = $this->Html->link($linkText, array('controller'=>'orders','action'=>'view', $d['id']), array ('escape'=>false)),
						"Status: <b>".$active[$d['active']]." - ".$status[$d["status"]]."</b>",
						$this->Html->div('pull-right', $this->Time->niceShort($d['created']))
					)
				));
			} ?>	
			
		</table>
		<?php
			echo $this->Paginator->numbers();
		?>
	</div>
</div>

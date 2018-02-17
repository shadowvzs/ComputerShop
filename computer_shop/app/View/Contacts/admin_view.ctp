<div class="col-md-5 col-md-offset-0 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
	<div class="panel panel-default">
		<div class="panel-heading text-center panel-title font-weight-bold"> 
			<?php 
				$msg = $messages['Contact'];
				$status=['Unsolved','Solved'];
				$msg['active']=intval($msg['active']);
				echo $msg['email'].' - '.__($status[$msg['active']]); 
			?>
		</div>
		<div class="panel-body">
			<?php
				echo $this->AdvHTML->rowGroup(array(
					'Name'=>$msg['name'],
					'Phone'=>$msg['phone'],
					'Email'=>$msg['email'],
					'Created'=>$msg['created'],
					'Solved'=>$msg['active']===1 ? $msg['created'] : $status[0],
					'Message'=>$msg['message']
				));
				echo ($this->AdminAction->forMessage($msg['id'], 'contact', $msg['active'],null,1)).' mark as '.$status[1-$msg['active']]; 
			?>
		</div>
	</div>
</div>
<div class="col-md-5 col-md-offset-0 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
	<div class="panel panel-default">
		<div class="panel-heading text-center panel-title font-weight-bold"> 
			<?php echo __('Send mail'); ?>
		</div>
		<div class="panel-body">
			<?php 
				echo $this->Form->create('Contact');
				echo $this->Form->input('email', array('label'=>false,'style'=>'width: 100%;','type' => 'email', 'value'=>$msg['email']));
				echo '<br>'.$this->Form->textarea(	'textarea',
					array('style'=>'width: 100%;height: 200px;resize: none;')
				).'<br>';
				$options = array(
					'div' => false,
					'label' => __('Save'),
					'class' => 'btn btn-primary text-center col-xs-2 col-xs-offset-5 margin-top-20',
				);
				echo $this->Form->end($options);			
			?>
		</div>
	</div>	
</div>
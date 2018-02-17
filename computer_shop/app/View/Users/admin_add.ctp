<div class="users form col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-">
	<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Create new account'); ?></legend>
        <?php 
			echo $this->Form->input('username', array('class'=>'form-control','label'=>__('Username')));
			echo $this->Form->input('password', array('class'=>'form-control','label'=>__('Password')));
			echo $this->Form->input('country',  array('class'=>'form-control','type'=>'select', 'name'=>'data[User][country_id]','label'=>__('Password'),'options'=>$countries));
			echo $this->Form->input('email',    array('class'=>'form-control','label'=>__('Email')));
		?>
    </fieldset>
	<?php 
		$options = array(
			'label' => __('Create'),
			'class' => 'btn btn-primary',
			'style' => 'margin: 0 auto;'
		);
		echo $this->Form->end( $options ); 

	?>
</div>
<br><br><br>
<div class="users form row col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2">
<?php echo $this->Form->create('User', array('url'=>'/login')); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your username and password'); ?>
        </legend>

		<?php 
			echo $this->Form->input('username', array('class'=>'form-control','label'=>__('Username')));
			echo $this->Form->input('password', array('class'=>'form-control','label'=>__('Password')));
		?>
    </fieldset>
	<div class="flex-container text-center" style="min-height:34px;">
	<?php 
		$options = array(
			'label' => __('Sign In'),
			'div' => false,
			'class' => 'btn btn-primary width-100 btn-expand',
			'style' => 'margin: 0 6px;display:inline-block;'
		);
		
		echo "<div style='display:inline-block;margin: 0;'>".$this->Form->end($options)."</div>"; 
		echo $this->Html->link( __('Recover'),'/recover', 
			array('class' => 'btn btn-primary width-100 btn-expand', 'style'=>'display:inline-block;margin: 6px;'));

		echo $this->Html->link( __('Activation'),'/activation', 
			array('class' => 'btn btn-primary width-100 btn-expand', 'style'=>'display:inline-block;margin: 6px;'));

		echo $this->Html->link( __('Sign Up'),'/signup',
			array('class' => 'btn btn-primary width-100 btn-expand', 'style'=>'display:inline-block;margin: 6px;'));
		echo $this->Form->end();
	?>
	</div>
	<br>
</div>
<script>
	$('#menuLogin').addClass('active');
</script>
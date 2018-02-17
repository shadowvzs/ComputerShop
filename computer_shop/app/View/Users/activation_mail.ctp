<br><br><br>
<div class="users form row col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Do you lost activation email'.'?<br>'); ?>
			<?php echo __('Please enter your username and email'); ?>
        </legend>

		<?php 
			echo $this->Form->input('username', array('class'=>'form-control','label'=>__('Username')));
			echo $this->Form->input('email', array('class'=>'form-control','label'=>__('Email')));
		?>
    </fieldset>
	
	<?php 
		$options = array(
			'label' => __('Resend'),
			'class' => 'btn btn-primary pull-left width-100 btn-expand'
		);

		echo $this->Form->end($options); 

		echo $this->Html->link( __('Back'),'/login',
		array('class' => 'btn btn-primary pull-right width-100 btn-expand'));
		
	?>
	</div>
</div>
<script>
	$('#menuLogin').addClass('active');
</script>
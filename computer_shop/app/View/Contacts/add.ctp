<section class="text-center">
	<h2>Contact Us</h2>
	<p>If you have any questions, please feel free to ask</p>
	<?php echo $this->Form->create('Contact', array('class'=>'form-contacts form-horizontal')); ?>
		<div class="col-md-6 col-md-offset-3">
				<?php echo $this->Form->input('name',    array('class'=>'form-control','placeholder'=>'Johnny English')); ?>
				<?php echo $this->Form->input('phone',   array('class'=>'form-control','placeholder'=>'+40741122333')); ?>
				<?php echo $this->Form->input('email',   array('class'=>'form-control','placeholder'=>'johnny007@gmail.com')); ?>
				<?php echo $this->Form->input('message', array('type' => 'textarea','class'=>'form-control','placeholder'=>'Description','rows'=>10)); ?>
		</div>
		<div class="clearfix"></div><br>
	<?php echo $this->Form->end(array('label' => __('Send Message'),'class' => 'btn btn-primary')); ?>
	<hr>
	<h3>Our Social Sites</h3>
	<ul class="list-inline banner-social-buttons">
		<li><a href="#" class="btn btn-default btn-lg"><i class="fa fa-twitter"> <span class="network-name">Twitter</span></i></a></li>
		<li><a href="#" class="btn btn-default btn-lg"><i class="fa fa-facebook"> <span class="network-name">Facebook</span></i></a></li>
		<li><a href="#" class="btn btn-default btn-lg"><i class="fa fa-youtube-play"> <span class="network-name">Youtube</span></i></a></li>
	</ul>
</section>

<script>$('#contacts').addClass('active');</script>

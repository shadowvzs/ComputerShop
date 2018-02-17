<?php 
	$orderBadge = "";
	if ((isset($badge['order']) && $badge['order'] > 0)) {
		$orderBadge = " <span class='badge' style='background-color:#c67605;'>".$badge['order']."</span>";
	}
	
	$contactBadge = "";
	if ((isset($badge['contact']) && $badge['contact'] > 0)) {
		$contactBadge = " <span class='badge' style='background-color:#c67605;'>".$badge['contact']."</span>";
	}

?>
<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				<?php echo $this->Icon->icon('archive',' Products',false,  'black', '16px'); ?></a>
			</h4>
		</div>
		<div id="collapse1" class="panel-collapse collapse">
			<div class="panel-body">
				<table class="table">
					<tr><td><?php echo $this->Html->link(__('Products'),  array('controller' => 'products', 'action' => 'index'), array('escape'=>false)); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Orders').$orderBadge,  array('controller' => 'orders', 'action' => 'index'), array('escape'=>false)); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Categories'),  array('controller' => 'categories', 'action' => 'index')); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Brands'),  array('controller' => 'brands', 'action' => 'index')); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Series'),  array('controller' => 'classifications', 'action' => 'index')); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Accessories'),  array('controller' => 'accessories', 'action' => 'index')); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Discounts'),  array('controller' => 'discounts', 'action' => 'index')); ?></td></tr>
				</table>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
					<?php echo $this->Icon->icon('id-card-o',' User Management',false,  'black', '16px'); ?>
				</a>
			</h4>
		</div>
		<div id="collapse2" class="panel-collapse collapse">
			<div class="panel-body">
				<table class="table">
					<tr><td><?php echo $this->Html->link(__('Users'),  array('controller' => 'users', 'action' => 'index')); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Groups'),  array('controller' => 'groups', 'action' => 'index')); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Contacts').$contactBadge,  array('controller' => 'contacts', 'action' => 'index'), array('escape'=>false)); ?></td></tr>
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
					<?php echo $this->Icon->icon('pie-chart',' Statistics',false,  'black', '16px'); ?>
				</a>
			</h4>
		</div>
		<div id="collapse3" class="panel-collapse collapse">
			<div class="panel-body">
				<table class="table">
					<tr><td><?php echo $this->Html->link(__('Feedbacks'),  array('controller' => 'feedbacks', 'action' => 'index'), array('escape'=>false)); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Reviews'),  array('controller' => 'reviews', 'action' => 'index')); ?></td></tr>
				</table>
			</div>
		</div>
	</div>	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
				<?php echo $this->Icon->icon('gear',' Settings',false,  'black', '16px'); ?></a>
			</h4>
		</div>
		<div id="collapse4" class="panel-collapse collapse">
			<div class="panel-body">
				<table class="table">
					<tr><td><?php echo $this->Html->link(__('Countries'),  array('controller' => 'countries', 'action' => 'index')); ?></td></tr>
					<tr><td><?php echo $this->Html->link(__('Pages'),  array('controller' => 'pages', 'action' => 'index')); ?></td></tr>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
	$current_controller = $this->request->params['controller'];
	$menu = [
		'products'=>1,
		'orders'=>1,
		'categories'=>1,
		'brands'=>1,
		'classifications'=>1,
		'accessories'=>1,
		'discounts'=>1,
		
		'users'=>2,
		'roles'=>2,
		'groups'=>2,
		'contacts'=>2,
		
		'feedbacks'=>3,
		'reviews'=>3,
		
		'countries'=>4,
		'pages'=>4
		];
	$accordionId = isset($menu[$current_controller]) ? $menu[$current_controller] : null;
	if (isset($accordionId)) {
		echo "<script>
			$('#collapse".$accordionId."').addClass('in');
		</script>";
	}
?>

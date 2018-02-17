<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>                        
		</button>
	  	<?php echo $this->Html->link(__('Computer Shop'), array('controller' => 'products', 'action' => 'index'), array('class' => 'navbar-brand')); ?>

    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo AuthComponent::user('id') ? AuthComponent::user('username') : 'My Account'; ?> <span class="caret"></span></a>
				<ul class="dropdown-menu">
				<?php 
					if (AuthComponent::user('id')) {
						echo $this->Html->tag('li', $this->Html->link(__('Dashboard'), array('controller' => 'contacts', 'action' => 'dashboard'))); 
						echo $this->Html->tag('li', $this->Html->link(__('User View'), '/'));					
						echo $this->Html->tag('li', $this->Html->link(__('Settings'), array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id'))));					
						echo $this->Html->tag('li', $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout')));					
					}
				?>
				</ul>
			</li>		
		</ul>
    </div>
  </div>
</nav>

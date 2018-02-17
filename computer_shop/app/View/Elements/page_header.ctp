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
		<ul class="nav navbar-nav">
			<?php foreach ($menu as $page_menu) {?>
				<li id="menuContact">
					<?php
					$menuName = ' '.$page_menu['Page']['name'];
					if ($page_menu['Page']['url'] == '') {
						echo $this->Html->link($this->Icon->icon('handshake-o', $menuName),
							array('controller' => 'pages', 'action' => 'view', $page_menu['Page']['slug']),
							array('escape' => false)
						);
					} else {
						echo $this->Html->link($this->Icon->icon('handshake-o', $menuName),
							$page_menu['Page']['url'],
							array('escape' => false)
						);
					}
					?>
				</li>
			<?php }?>		
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li id="menuMyCart">
				<?php
				if (AuthComponent::user('id')) {
					if (!$admin) {
						echo $this->Html->link($this->Icon->icon('shopping-cart', ' '.__('My Cart').' '.$this->Html->tag('span', $count, array('class' => 'badge', 'id'=>'cart-counter','style'=>'background-color:#'.($count > 0 ? 'f89406' : '3a87ad').';'))), array('controller'=>'carts', 'action'=>'view'), array('escape' => false)); 	
					}
				}else{
					echo $this->Html->link($this->Icon->icon('shopping-cart', ' '.__('My Cart').' '.$this->Html->tag('span', $count, array('class' => 'badge', 'id'=>'cart-counter','style'=>'background-color:#'.($count > 0 ? 'f89406' : '3a87ad').';'))), '/mycart', array('escape' => false)); 	
				}
				?>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo AuthComponent::user('id') ? AuthComponent::user('username') : 'My Account'; ?> <span class="caret"></span></a>
				<ul class="dropdown-menu">
				<?php 
					if (AuthComponent::user('id')) {
						if ($admin) {
							echo $this->Html->tag('li', $this->Html->link(__('Dashboard'), array('controller' => 'contacts', 'action' => 'dashboard'))); 
							echo $this->Html->tag('li', $this->Html->link(__('User View'), '/'));					
							echo $this->Html->tag('li', $this->Html->link(__('Settings'), array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id'))));					

						}else{
							if (AuthComponent::user('group_id')==1) {
								echo $this->Html->tag('li', $this->Html->link(__('Admin View'), array('controller' => $this->params['controller'], 'action' => $this->action, 'admin' => true)));					
							}
							echo $this->Html->tag('li', $this->Html->link(__('My Orders'), '/orders'));					
							echo $this->Html->tag('li', $this->Html->link(__('Settings'), '/profile'));	
						}
						echo $this->Html->tag('li', $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout')));					
					} else {
						echo $this->Html->tag('li', $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login')));					
						echo $this->Html->tag('li', $this->Html->link(__('Sign up'), array('controller' => 'users', 'action' => 'add')));					
					}
				?>
				</ul>
			</li>		
		</ul>
    </div>
  </div>
</nav>

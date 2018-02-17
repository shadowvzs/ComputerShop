<?php
	${$model}=${$model}[$model];
?>
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">

		<?php
		
		$productList = null;
			if (!empty(${$assocModel})) {
			$productList=["<ul class='list-inline list-unstyled'>"];
			$listStr = ["<li class='list-group-item' style='padding: 5px 10px;'>", "</li>"];
			foreach (${$assocModel} as $item_id=>$item_name){
				$productLink = $this->Html->link($item_name,array('controller'=>'products','action' => 'view', $item_id));
				$removeLink = $this->AdminAction->mixTool($item_id, 16, $assocModel,null, 'accessory_id');
				$productList[]=$listStr[0].$productLink." - ".$removeLink.$listStr[1];
			}
			$productList[]="</ul>";
		}

		$status=['Inactive','Active'];
		echo $this->AdvHTML->rowGroup(array(
			'Name'=>${$model}['name'],
			'Products'=> $productList ? implode(' ',$productList) : 'Not exist',
			'Status'=>$status[intval(${$model}['active'])],
			'Created'=>${$model}['created'],
			'Updated'=>${$model}['updated']
		));
		

			echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 

		?>
		</div>
	</div>
</div>
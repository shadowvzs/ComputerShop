<?php
	${$model}=${$model}[$model];
	$parent=isset(${$model.'_parent'}) ? ${$model.'_parent'} : null;
	$childs=isset(${$model.'_sub'}) ? ${$model.'_sub'} : null;
	$title = ($parent ? $parent['name'].' &minus; ' : '').${$model}['name'];
?>
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo $title; ?></div>
		<div class="panel-body">

		<?php
		$treeData = []; 
		$parentCat=null;
		
		if ($parent){
			//$parent=$parent[$model];
			$treeData['Parent menu'] = "<ul class='list-inline list-unstyled'><li class='list-group-item' style='padding: 5px 20px;'>".$this->Html->link($parent['name'],array('controller'=>'categories','action' => 'view', $parent['id']), array('escape' => false))."</li></ul>";
		}
		
		if ($childs) {
			if (count($childs)>0){
				$childCat=["<ul class='list-inline list-unstyled'>"];
				foreach  ($childs as $child){
					$id = $child['id']; 
					$name = $child['name'];
					$viewLink = $this->Html->link($name,array('controller'=>'categories','action' => 'view', $id), array('escape' => false));
					$removeLink = $this->AdminAction->mixTool($id, 16, $model,null, 'parent_id');
					$childCat[]="<li class='list-group-item' style='padding: 5px 20px;'>".$viewLink.' - '.$removeLink."</li>";
				
				}
				$childCat[]="</ul>";
			}
			$treeData['Sub menu']=implode(' ',$childCat);
		}
		
			
		$status=['Inactive','Active'];
		echo $this->AdvHTML->rowGroup(array_merge($treeData,array(
			'Name'=>${$model}['name'],
			'Status'=>$status[intval(${$model}['active'])],
			'Created'=>${$model}['created'],
			'Updated'=>${$model}['updated']
		)));
		

			echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 

		?>
		</div>
	</div>
</div>
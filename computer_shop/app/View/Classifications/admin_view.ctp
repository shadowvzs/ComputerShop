<?php
	$assocModel=${$model}[$assocModel];
	${$model}=${$model}[$model];
?>
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">

		<?php
		
		$parentBrand = 'Not exist';
		$parentCategory = 'Not exist';

		if ($assocModel['id']) {
			$parentBrand="<ul class='list-inline list-unstyled'><li class='list-group-item' style='padding: 5px 20px;'>".$this->Html->link( $assocModel['name'],array('controller'=>'brands','action' => 'view', $assocModel['id']), array('escape' => false))."</li></ul>";
		}

		if (isset($category['Category'])) {
			$parentCategory="<ul class='list-inline list-unstyled'><li class='list-group-item' style='padding: 5px 20px;'>".$this->Html->link( $category['Category']['name'], array('controller'=>'categories','action' => 'view', $category['Category']['id']), array('escape' => false))."</li></ul>";
		}
		$status=['Inactive','Active'];
		echo $this -> AdvHTML -> rowGroup(array(
			'Parent Category' => $parentCategory,
			'Parent Brand' => $parentBrand,
			'Name' => ${$model}['name'],
			'Status' => $status[intval(${$model}['active'])],
			'Meta Title' => ${$model}['meta_title'],
			'Meta Description' => ${$model}['meta_description'],
			'Meta Keywords' => ${$model}['meta_keyword'],			
			'Created' => ${$model}['created'],
			'Updated' => ${$model}['updated']
		));
		

			echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 

		?>
		</div>
	</div>
</div>
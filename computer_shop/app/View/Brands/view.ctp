<?php
	$assocModel=${$model}[$assocModel];
	${$model}=${$model}[$model];
?>
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">
		
		<?php
		$logoPath = ($assocModel['path']) ? 'brands/'.$assocModel['path'] : null;
		if ($logoPath) {
			echo $this->Html->image($logoPath, array('alt' => __($model.' '.'logo'), 'style'=>'width:100%;'));
		}

		$seriesList = [];
		foreach($series as $serie){
			$serie = $serie[$assocModel2];
			$viewLink = $this->Html->link($serie['name'],array('controller'=>'classifications','action' => 'view', $serie['id']), array('escape' => false));
			$removeLink = $removeLink = $this->AdminAction->mixTool($serie['id'], 16, $assocModel2, null, 'brand_id');
			$seriesList[] = "<li class='list-group-item'>".$viewLink.' - '.$removeLink."</li>";
		}
		$status=['Inactive','Active'];
		echo $this->AdvHTML->rowGroup(array(
			'Name'=>${$model}['name'],
			'Status'=>$status[intval(${$model}['active'])],
			'Series'=>empty($seriesList) ? 'No classification' : "<ul class='list-inline list-unstyled'>".implode(' ',$seriesList)."</ul>",
			'Short Content'=>${$model}['short_content'],
			'Content'=>${$model}['content'],
			'Term'=>${$model}['term'],
			'Meta Title'=>${$model}['meta_title'],
			'Meta Description'=>${$model}['meta_description'],
			'Meta Keywords'=>${$model}['meta_keyword'],
			'Created'=>${$model}['created'],
			'Updated'=>${$model}['updated']
		));
		echo $this->Html->link('Edit',array('controller'=>$controller,'action' => 'edit', ${$model}['id']), array('class' => 'btn btn-primary col-xs-2 col-xs-offset-5', 'escape' => false)); 
		?>
		</div>
	</div>
</div>
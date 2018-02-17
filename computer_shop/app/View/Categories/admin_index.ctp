<?php
	echo $this->Html->css('combine.php?combine='.implode(',', array('categories')), false, array('inline' => false));
	echo $this->Html->script('combine.php?combine='.implode(',', array('sortable')), false, array('inline' => false));
?>
<div class="panel panel-default col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" style='min-width: 300px;'>
	<div class="panel-heading panel-title font-weight-bold">
		<?php echo __($model.' list'); ?>
		<div class="pull-right"> 
			<?php echo $this->Html->link($this->Icon->icon('plus-square','',true,  'blue', '18px'), array('controller'=>$controller,'action' => 'add'), array('escape' => false)); ?> 
		</div>
	</div>
	
	<div class="panel-body">
	<?php 
		$maxCat = count(${$model});
		$maxSubCat = 0;
		$mainList = [];
		
		for ($m=0;$m<$maxCat;$m++) {
			
			$mainCat = ${$model}[$m][$model];
			$maxSubCat=is_array(${$model}[$m]['Child']) ? count(${$model}[$m]['Child']) : 0;
			$classes = [];
			if ($maxSubCat>0) { $classes[] ="hideList";}
			if ($mainCat['active']==0) { $classes[] ="inactive";}
			$endTag = $maxSubCat>0 ? '' : '</li>';
			$mainList[] = "<li data-id='".$mainCat['id']."' data-name='".$mainCat['name']."' class='".implode(' ',$classes)."' id='menu_".$mainCat['id']."'>".__($mainCat['name']).'<span class="pull-right adminTool">'.$this->AdminAction->mixTool($mainCat['id'], 15, $model, $mainCat['active'], 'active','18px').'</span>'.$endTag;
			
			if ($maxSubCat>0) {
				$subList = [];
				$subCatArray = ${$model}[$m]['Child'];
				for ($s=0;$s<$maxSubCat;$s++) {
					$classes = [];
					$subCat=$subCatArray[$s];
					if ($subCat['active']==0 || $mainCat['active']==0) { $classes[] ="inactive";}
					$subList[] = "<li data-id='".$subCat['id']."' data-name='".$subCat['name']."' id='menu_".$subCat['id']."' class='".implode(' ',$classes)."'>".__($subCat['name'])."<span class='pull-right adminTool'>".$this->AdminAction->mixTool($subCat['id'], 15, $model, $subCat['active'], 'active', '18px')."</span></li>";
				}
				$mainList[] = "<ol>".implode(' '.PHP_EOL, $subList)."</ol>".$endTag;
			}
		}
		
		$menu = "<span class='center-block' style='text-align:center;' ><ol class='products-menu' style='text-align:left;'>".implode( ''.PHP_EOL, $mainList)."</ol></span>";

	//the whole menu i write out here
	echo $menu;
			
	
	echo $this->Form->create($model, array('class'=>'col-xs-2 col-xs-offset-5'));
	
	$options = array(
			'div' => false,
			'label' => __('Save'),
			'class' => 'btn btn-primary formSubmitBTN margin-top-20'
	);

	echo $this->Form->input('order1', array('label' => false, 'div' => false, 'type'=>'hidden'));
	echo $this->Form->input('order2', array('label' => false, 'div' => false, 'type'=>'hidden'));
	
	echo $this->Form->end($options);
	echo $this->Html->script('categories');
	?>

	</div>
</div>

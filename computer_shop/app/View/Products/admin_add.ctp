<?php extract(${$model}); ?>
<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12" style='min-width:300px;'>
	<div class="panel panel-default">
		<div class="panel-heading text-center">Add new <?php echo $model; ?></div>
		<div class="panel-body">
				
		<?php 
	
			echo $this->Form->create($model, array('enctype' => 'multipart/form-data'));
			
			echo "<div class='clearfix'>".$this->Form->input('Category:',array('type'=>'select','style'=>'width: 200px;','value'=>0,'name'=>'data[Product][category_id]','class'=>'pull-right','options'=>$Category))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Brand:',array('type'=>'select','style'=>'width: 200px;','value'=>0,'name'=>'data[Product][brand_id]','class'=>'pull-right','options'=>$Brand))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Series:',array('type'=>'select','style'=>'width: 200px;','value'=>0,'name'=>'data[Product][classification_id]','class'=>'pull-right','options'=>$Classification))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Part of:',array('type'=>'select','style'=>'width: 200px;','value'=>0,'name'=>'data[Product][accessory_id]','class'=>'pull-right','options'=>$Accessory))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Discount:',array('type'=>'select','style'=>'width: 200px;','value'=>0, 'name'=>'data[Product][discount_id]','class'=>'pull-right','options'=>$Discount))."</div>";
			
			echo "<div class='clearfix'>".$this->AdvForm->selectOnOff('active',1)."</div>";
			echo "<div class='clearfix'>".$this->AdvForm->selectOnOff('condition',1, array('Used','New'))."</div>";
				
			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
				'price'=>'Price',
				'short_content'=>'Short Content',
				'content'=>'Content',
				'meta_title'=>'Meta Title',
				'meta_description'=>'Meta Description',
				'meta_keyword'=>'Meta Keywords',
			), null);		
			echo "<div class='clearfix'><b>Product Thumbnail:</b><div class='pull-right'><input type='file' name='data[".$model."][file][image]' id='FileImage' style='width:95px;' /></div></div>";
			
			$options = array(
				'div' => false,
				'label' => __('Save'),
				'class' => 'btn btn-primary text-center col-xs-4 col-xs-offset-4  col-sm-2 col-sm-offset-5 margin-top-20'
			);

			echo $this->Form->end($options);
		?>	
		</div>
	</div>
</div>
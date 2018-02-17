<?php extract(${$model}); ?>
<div class="container col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12" style='min-width:300px;'>
	<div class="panel panel-default">
		<div class="panel-heading text-center"><?php echo ${$model}['name']; ?></div>
		<div class="panel-body">
				
		<?php 
			echo "<div class='clearfix'>";
			echo $this->Form->create($model, array('enctype' => 'multipart/form-data','url' => '/products/image_upload/'.$Product['id']));
			echo "<input type='file' name='data[".$model."][file][image]' id='FileImage' class='btn btn-default pull-left'/>";
			
			$options = array(
					'div' => false,
					'label' => __('Upload'),
					'class' => 'btn btn-primary pull-right'
			);
			
			echo $this->Form->end($options);
			echo "</div><br>";

			echo $this->Form->create($model);
			
			echo "<div class='clearfix'>".$this->Form->input('Category:',array('type'=>'select','style'=>'width: 200px;','value'=>$Product['category_id'],'name'=>'data[Product][category_id]','class'=>'pull-right','options'=>$Category))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Brand:',   array('type'=>'select','style'=>'width: 200px;','value'=>$Product['brand_id'],'name'=>'data[Product][brand_id]','class'=>'pull-right','options'=>$Brand))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Series:',  array('type'=>'select','style'=>'width: 200px;','value'=>$Product['classification_id'],'name'=>'data[Product][classification_id]','class'=>'pull-right','options'=>$Classification))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Part of:', array('type'=>'select','style'=>'width: 200px;','value'=>$Product['accessory_id'],'name'=>'data[Product][accessory_id]','class'=>'pull-right','options'=>$Accessory))."</div>";
			echo "<div class='clearfix'>".$this->Form->input('Discount:',array('type'=>'select','style'=>'width: 200px;','value'=>$Product['discount_id'],'name'=>'data[Product][discount_id]','class'=>'pull-right','options'=>$Discount))."</div>";
			
			echo "<div class='clearfix'>".$this->AdvForm->selectOnOff('active', $Product['active'])."</div>";
			echo "<div class='clearfix'>".$this->AdvForm->selectOnOff('condition', $Product['item_condition'], array('Used','New'))."</div>";
			
			$imageList = [];
			
			foreach($ProductsImage as $key => $image){
				$image=$image['ProductsImage'];
				$deleteLink = ' '.$this->Html->link($this->Icon->icon('delete','',true, 'red', '14px'),  array('controller' => 'products','action' => 'delete_image', $image['id']), array('escape' => false, 'title'=>'Permanently delete', 'confirm' => 'Are you sure?'));
				$coverLink= ' - '.$this->Html->link($this->Icon->icon('window-maximize','',true, 'blue', '14px'),  array('controller' => 'products','action' => 'change_cover_image', $Product['id'],$image['id']), array('escape' => false, 'title'=>'Make default image for this product'));
				$selectImage = $Product['cover_image_id'] == $image['id'] ? 'font-style-underline blue-text-shadow': 'font-style-italic';
				$imageList[] = $this->Html->link('image'.$key, '/app/'.WEBROOT_DIR.'/img/products/'.$image['name'], array('class'=>$selectImage)).$coverLink.$deleteLink;
			}
			
			$image = empty($imageList) ? 'Not have uploaded image' : implode(', <br>', $imageList);
			
			echo "<div class='clearfix'><b>Images</b><div class='pull-right'>".$image."</div></div>";
			
			echo $this->AdvForm->inputGroup(array(
				'name'=>'Name',
				'price'=>'Price',
				'short_content'=>'Short Content',
				'content'=>'Content',
				'meta_title'=>'Meta Title',
				'meta_description'=>'Meta Description',
				'meta_keyword'=>'Meta Keywords',
			), $Product);		
			
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
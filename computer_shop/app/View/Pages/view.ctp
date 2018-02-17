<?php 
	echo $this->Element('page_'.$page['Page']['slug']); 
	echo "<script>$('#".$page['Page']['slug']."').addClass('active');</script>";
?>

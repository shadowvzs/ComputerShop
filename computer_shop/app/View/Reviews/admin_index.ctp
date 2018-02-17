<div class="panel panel-default">
	<a href="#messageList" data-toggle="collapse">
		<div class="panel-heading panel-title font-weight-bold"> Review List </div>
	</a>
	<div class="panel-body collapse" id="messageList">
		<table class='table table-dark table-striped'>
			<?php 
				foreach ($reviews as $review){ 
				$review = $review[$model];
			?>
			<tr>
				<td>
					<?php  echo  $this->Icon->isActive(__('Rate').': '.$review['rate'], $review['active']); ?>
				</td>
				<td style='width: 100px;'><div class='pull-right' title='<?php echo $review["created"]; ?>'><?php echo $this->Time->timeAgoInWords($review["created"],array('format' => 'F jS, Y', 'end' => '+1 year')); ?></div></td>
				<td style='width: 80px;'>
					<div class='pull-right'>
					<?php
						echo $this->AdminAction->mixTool($review['id'], 9, $model, $review['active']);
					?>
					</div>
				</td>
			</tr>
			<?php } ?>	
		</table>		
	</div>
</div>

<?php
echo "<script> var piePiece = []; </script>";
foreach($statistic as $data) {
	echo "<script> piePiece[piePiece.length] = ['Rate: ".$data['reviews']['rate']."', parseInt( '".$data[0]['count']."',10)]; </script>";
}

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'], ...piePiece
        ]);

        var options = {
          title: 'Overall reviews'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>

<div id="piechart" style="width: 900px; height: 500px;"></div>
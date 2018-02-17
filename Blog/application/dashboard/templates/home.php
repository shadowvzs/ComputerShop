<div class="middle">
    <div class="inbox">
        <img src="../public/img/black_bubble.png" alt="Inbox bubble"/>
        <p>Inbox</p>
        <div class="inbox_text">
            Want to see how your emails look in over 50+ desktop, mobile, and 
            webmail clients, including in plain text? Never forget to include plain text 
            as part of your next email campaign with Litmus Checklist.
        </div>
        <a href="#" class="read_more">Read more</a>
    </div>
    <!-- here need a foreach -->
    <?php foreach ($T['articles'] as $article): ?>
        <figure>
            <a href='?delete=<?= $article->id ?>' ><div class="delete">&times;</div></a>
            <a href='?page=article&id=<?= $article->id ?>' title='Open this article'>
                <img src="/public/img/articles/thumb_<?= intval($article->id) ?>.jpg" alt="article from DB" onerror="this.src='./public/img/default.jpg';" />
                <figcaption><?= htmlspecialchars_decode(strip_tags($article->title)) ?></figcaption>
            </a>
        </figure>    
    <?php endforeach; ?>
</div>
<div class="right_side">
    <div class="figure">
        <div class="frame">
            <img src="/public/img/white_bubble.png" alt="New Product" />
        </div>
		<div class="details">
			<h1><?= $T['commentCounter'] ?></h1>
			<p>Comments</p>
		</div>
    </div>
    
    <!-- View show how much view was total on articles what was posted by logged user -->
    <!-- Comment show how much comment was on articles what was posted by logged user -->
    <div class="figure">
        <div class="frame">
            <img src="/public/img/white_eye.png" alt="Copy of New Product" />
        </div>
		<div class="details">
			<h1><?= $T['views'] ?></h1><br/>
			<p>Views</p>
		</div>
    </div>
    <div id="donutchart"> </div>
</div>   
       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var statistics = JSON.parse('<?= $T['statistics'] ?>');
            var data = google.visualization.arrayToDataTable(statistics.data);
 
            var options = {
              title: 'How much comment per Article',
              titleTextStyle: {
                  fontSize: 13,
                  fontName:'arial'
              },
              legend: {textStyle: {fontSize: 13}},
              pieHole: 0.4,
              chartArea:{left:59,top:58, width: '230%', height: '230%'},
            };
    
            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
          }
        </script>        
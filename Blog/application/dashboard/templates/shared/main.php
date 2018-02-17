<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Blog - Dashboard </title>
        <link rel="stylesheet" href="/public/css/dashboard.css?f=<?= time() ?>" type="text/css"/>
        <link rel="stylesheet" href="/public/css/common.css?f=<?= time() ?>" type="text/css"/>
 
    </head>
    <body>
        <?php   if ($showUI===true) {require ("header.php");}   ?> 
        <?php   if ($showUI===true) {require ("sidebar.php");}   ?> 
        <div class="dashboard-message-box" id="flashBox">
          <a href="javascript::void(0);" onclick="document.getElementById('flashBox').style='opacity:0;';">
            <div class="close">&times;</div></a>  <?= isset($T['message']) ? $T['message'] : ''?>
        </div>
        <main>
            <?php      require ($templatePath);   ?>
        </main>
         <?php  if ($showUI===true) {require ("footer.php");}   ?> 
    </body>
</html>
<?php if (isset($T['message'])) { ?>
<script>
  setTimeout(()=>{
    document.getElementById('flashBox').style='opacity:1;';
    setTimeout(()=>{document.getElementById('flashBox').style='opacity:0;';},5000);
  }, 100);
</script>
<?php } ?>

<form action="?page=addprofile" method="POST" class="profUpload" name="profileImage" enctype="multipart/form-data">
    <input type="file" name="pimage" id="pimage" accept="image/jpeg" onchange="if (this.value) {};profileImage.submit();">
</form>

<div id="burgerMenu" class="burgerMenu">
    <div class="center">
        <a href="dashboard.php"> Dashboard</a>
        <a href="#">Widgets</a>
        <a href="#">Charts</a>
        <a href="#" class="selected">Tables</a>
        <a href="#" onclick="alert('Want a Alert? :D');">Alerts</a>
    </div>
</div>

<script type="text/javascript" src="/public/js/burger.js"></script>
<script>
    
    if (document.readyState === 'complete') {
    	burger();
      
     }
      
    document.onreadystatechange = function() {
      if (document.readyState === 'complete') {
    	  burger();
      }
    };    
</script>
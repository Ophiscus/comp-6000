<html>
  <head>
  <style>
body{
background-image: url("youngchef.jpg");
background-size: 500px;
background-color: #FFFDD0;
}
</style>

    <title>Video Player</title>
  </head>
  <body>
  <h1 style="font-family:verdana";>Training Videos</h1>

    <?php foreach($video as $v): ?>
      <video controls>
        <source src="<?php echo $v->location;?>" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    <?php endforeach; ?>
  </body>
</html>
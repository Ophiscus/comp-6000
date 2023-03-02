<html>
  <head>
  <style>
body{
background-image: url("youngchef.jpg");
background-size: 500px;
background-color: #FFFDD0;
}

table,th,td{
  border : 1px solid black; 
}
</style>

    <title>Video Player</title>
  </head>
  <body>
  <h1 style="font-family:verdana";>Training Videos</h1>

    <!--
      <video controls>
        <source src="" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    -->
    <table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Video</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($video as $v): ?>
        <tr>
            <td><?php echo $v->Title;?></td>
            <td><video src="<?php echo $v->location;?>" controls></video></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
  </body>
</html>
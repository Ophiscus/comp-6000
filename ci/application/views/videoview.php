<html>
  <head>
  <!-- Import the styleSheet-->
  <link rel="stylesheet" href="<?php echo base_url("assets/style.css") ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">
  <!-- Import the sidebar Script-->
  <script src="<?php echo base_url("assets/nav.js") ?>"></script>
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
  <?php include("assets/nav.html");?>

  <div id = "main">

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
            <td><?php echo $v['Title'];?></td>
            <td><video src="<?php echo base_url('uploads/'.$v['Title']);?>" controls></video></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
  <div>
  </body>
</html>
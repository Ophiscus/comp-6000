<html>
<head>

<!-- Import the styleSheet-->
<link rel="stylesheet" href="<?php echo base_url("assets/style.css") ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">
<!-- Import the sidebar Script-->
<script src="<?php echo base_url("assets/nav.js") ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
body{
background-image: url("youngchef.jpg");
background-size: 500px;
background-color: #FFFDD0;
}
    
table,th,td {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    background-color: #ffff66
}

table {
    width: 100%;
}

th {
    padding-top: 2vw;
    padding-bottom: 2vw;
    background-color: #228B22;
    color: white;
    text-transform: capitalize;
}
</style>
</head>
<body onload="checkManagerElements('<?php echo $this->session->userdata('role') ?>')">

<?php 
$alertMessage = $this->session->flashdata('success');
if (isset($alertMessage)) { ?>
    <script> alert("<?php echo $alertMessage ?>")</script>
<?php } ?>
<?php include("assets/nav.html");?>

<div id = "main">
<div id="manage_tools" class="manager">
	<div id="tools" onload="isManager(this.id, '<?php echo $this->session->userdata('role') ?>')">
	<?php echo $error;?>

<?php echo form_open_multipart('Resources/do_upload');?>

<h1 style="font-family:verdana";>Resources</h1>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Add file" />

<?php echo "</form>"?>
		
<table id = assignTable>
    <thead>
        <tr>
            <th>Document</th>
            <th>Assigned To</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($video as $v) {?>
            <tr>
                <td><video src="<?php echo base_url('uploads/'.$v['Title']);?>" controls></video></td>
                <td>
                <form action ="<?php echo base_url('index.php/Resources/assignTraining')?>" method="POST">
                    <?php 
                    $i = 0;
                    foreach ($team as $staff) { ?>
                    <input type ="checkbox" name='<?php echo $staff['StaffID'] ?>' value = <?php echo $staff['StaffID'] ?> 
                    <?php if ($i < count($assigned) and $assigned[$i]['StaffID'] == $staff['StaffID'] and $assigned[$i]['TrainingID'] == $v['TrainingID']) {
                        $i++; 
                        echo "checked";
                        } 
                    ?>>  
                    <label for <?php echo $staff['StaffID'] ?>> <?php echo $staff ['FirstName'] . ' ' . $staff['LastName'] ?> </label>
                    <?php } ?> 
                    <input type="submit" name='<?php echo $v['Title'] ?>' value="Assign To">
                </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>
</div>


 
  
    

</div>
</body>
</html>
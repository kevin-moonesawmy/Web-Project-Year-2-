<?php
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$email=$_POST['email'];
	$sql="SELECT firstname,lastname,gender,tel_no,specialisation FROM user_details u,coach c WHERE u.email=c.email AND u.email='$email'";
	$Result=$conn->query($sql);
	$row=$Result->fetch();
	?>
	<h3>Coach Informations:</h3>
	<label>Name:</label>
	<input class="input_info" type="" value="<?php echo $row['firstname'].' '.$row['lastname']; ?>"><br>
	<label>Speciality:</label>
	<input class="input_info" style="text-transform: capitalize;" type="" value="<?php echo $row['specialisation']; ?>"><br>
	<label>Gender:</label>
	<input class="input_info" style="text-transform: capitalize;" value="<?php echo $row['gender']; ?>"><br>
	<label>Tel No:</label>
	<input class="input_info" type="" value="<?php echo $row['tel_no']; ?>"><br>
	<a href="trainers.php" target="_blank">Know more about our coaches</a>
	<?php
?>
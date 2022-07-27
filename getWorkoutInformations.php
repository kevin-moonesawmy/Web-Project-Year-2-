<?php
	session_start();
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$email=$_SESSION['username'];
	$id=$_POST['id'];
	$_SESSION['workout_id']=$id;
	$sql="SELECT name,category,likes,firstname,lastname FROM workout_plans w,user_details u WHERE w.coach_mail=u.email AND workout_id='$id'";
	$Result=$conn->query($sql);
	$row=$Result->fetch();
	?>
	<h3>Workout Informations:</h3>
	<label>Name:</label>
	<input class="input_info" type="text" name="" value="<?php echo $row['name']; ?>"><br>
	<label>Category:</label>
	<input class="input_info" style='text-transform: capitalize;' type="text" value="<?php echo $row['category']; ?>"><br>
	<label>By Coach:</label>
	<input class="input_info" type="" value="<?php echo $row['firstname'].' '.$row['lastname']; ?> "><br>
	<label>Likes:</label>
	<input class="input_info" type="" value="<?php echo $row['likes']; ?>"><br>
	<a href="workout.php?referer=bookings" target="_blank">More Details</a>
	<?php
?>
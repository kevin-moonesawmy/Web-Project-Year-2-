<?php 
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$category=$_POST['category'];
	//$category='body building';
	$sql="SELECT * FROM workout_plans WHERE category='$category'";
	$Result=$conn->query($sql);
	?> <option value="" selected>Workout Name</option> <?php
	while ($row=$Result->fetch())
	{
		$id=$row['workout_id'];
		$name=$row['name'];
		?>
		<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
		<?php
	}

?> 

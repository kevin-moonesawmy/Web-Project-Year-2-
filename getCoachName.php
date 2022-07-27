<?php
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$category=$_POST['category'];
	$sql="SELECT u.email,lastname,firstname FROM user_details u,coach c WHERE u.email=c.email AND c.specialisation='$category'";
	$Result=$conn->query($sql);
	?> <option value="" selected>Coach Name</option> <?php
	while ($row=$Result->fetch())
	{
		$email=$row['email'];
		$name=$row['firstname']." ".$row['lastname'];
		?>
		<option value="<?php echo $email; ?>"><?php echo $name; ?></option>
		<?php
	}
?>
<?php
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$email='kevinMoo@gmail.com';
	$id=$_POST['id'];
	$sql='call insertSaveWorkout(:email,:id)';
	$stmt=$conn->prepare($sql);
	$stmt->bindParam(':email',$email);
	$stmt->bindParam(':id',$id);
	$result=$stmt->execute();
	if($result)
	{
		echo true;
	}
	else
	{
		echo false;
	}


?>
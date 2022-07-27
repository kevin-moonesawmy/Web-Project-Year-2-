<?php
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql='call insertBooking(:memail,:cemail,:workout_id,:day,:time)';
	$stmt=$conn->prepare($sql);
	$stmt->bindParam(":memail",$_POST['member_mail']);
	$stmt->bindParam(":cemail",$_POST['coach_mail']);
	$stmt->bindParam(":workout_id",$_POST['workout_id']);
	$stmt->bindParam(":day",$_POST['day']);
	$stmt->bindParam(":time",$_POST['time']);
	$stmt->execute();
?>
<?php
    session_start();
    require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $email=$_SESSION['username'];
    $coach_mail=$_POST['coach_mail'];
    $workout_id=$_POST['workout_id'];
    $date=$_POST['day'];
    $time_range=$_POST['time_range'];
    $sql="DELETE FROM bookings WHERE member_mail='$email' AND coach_mail='$coach_mail' AND workout_id='$workout_id' AND date='$date' AND time_range='$time_range'";
    $Result=$conn->query($sql);
?>
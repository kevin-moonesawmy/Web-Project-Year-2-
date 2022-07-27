<?php 
    session_start();
    $email=$_SESSION['username'];
    require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $coach_mail=$_POST['coach_mail'];
    $workout_id=$_POST['workout_id'];
    $day=$_POST['day'];
    $time_range=$_POST['time_range'];

    $sql="UPDATE bookings SET member_cancel='1' WHERE member_mail='$email' AND coach_mail='$coach_mail' AND workout_id='$workout_id' AND date='$day' AND time_range='$time_range'";
    $Result=$conn->query($sql);
?>
<?php 
    session_start();
    $coach_mail=$_SESSION['username'];
    require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $member_mail=$_POST['member_mail'];
    $date=$_POST['date'];
    $time_range=$_POST['time_range'];
    $sql="DELETE FROM bookings WHERE coach_mail='$coach_mail' AND member_mail='$member_mail' AND date='$date' AND time_range='$time_range'";
    $result=$conn->query($sql);
?>
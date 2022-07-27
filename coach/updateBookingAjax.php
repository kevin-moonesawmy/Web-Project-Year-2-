<?php 
    session_start();
    require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $coach_mail=$_SESSION['username'];
    $member_mail=$_POST['member_mail'];
    $date=$_POST['date'];
    $time_range=$_POST['time_range'];
    $msg=$_POST['message'];
    if($_POST['action']=='cancel')
    {
        $sql="UPDATE bookings SET coach_cancel='1',coach_message='$msg',status='rejected' WHERE coach_mail='$coach_mail' AND member_mail='$member_mail' AND date='$date' AND time_range='$time_range'";
        $conn->exec($sql);
    }
    if($_POST['action']=="reject")
    {
        $sql="UPDATE bookings SET coach_message='$msg',status='rejected' WHERE coach_mail='$coach_mail' AND member_mail='$member_mail' AND date='$date' AND time_range='$time_range'";
        $conn->exec($sql);
    }
    if($_POST['action']=="accept")
    {
        $sql="UPDATE bookings SET status='accepted'";
        if(!empty($msg))
        {
            $sql=$sql.",coach_message='$msg' ";
        }
        $sql=$sql." WHERE coach_mail='$coach_mail' AND member_mail='$member_mail' AND date='$date' AND time_range='$time_range'";
        $conn->exec($sql);
    }
?>
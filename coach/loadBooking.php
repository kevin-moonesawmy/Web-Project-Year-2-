<?php
session_start();
require_once "includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$name = $_SESSION['username'];
//$name="kevin@gmail.com";

$sQuery = "SELECT coaching.coaching_date,coaching.starting_time,user_details.lastname,user_details.firstname
FROM coaching,user_details
WHERE coaching.member_mail=user_details.email
AND coaching.coaching_date>=CURDATE()
AND coaching.coach_mail='".$name."'";
$Result = $conn->query($sQuery);
$array_result = $Result->fetchAll(PDO::FETCH_ASSOC);
    
    //var_dump($array_result);
    //die();
    header('Content-Type: application/json'); 
    echo json_encode($array_result);

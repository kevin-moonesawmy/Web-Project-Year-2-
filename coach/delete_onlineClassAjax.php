<?php
session_start();
require_once "includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$arr = explode("|",$_POST['txt_value']);
//echo $arr[2];
$Query = "DELETE FROM online_class
WHERE class_name='".$arr[0]."'
AND class_date='".$arr[1]."'
AND start_time='".$arr[2]."'";
$conn->exec($Query);
    
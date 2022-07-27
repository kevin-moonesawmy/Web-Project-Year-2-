<?php
session_start();
require_once "includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = 'CALL insertOnlineClass(:cName,:cDate,:sTime,:cDuration,:cMail,:cImage)';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':cName', $name);
$stmt->bindParam('cDate', $date);
$stmt->bindParam(':sTime', $time);
$stmt->bindParam(':cDuration', $duration);
$stmt->bindParam(':cMail', $email);
$stmt->bindParam(':cImage', $image);

$name = test_input($_POST["txt_class"]);

$date = $_POST["txt_date"];
$time = $_POST["txt_time"];
//$time = "13:00";
$duration = $_POST["txt_duration"];
$email = $_SESSION['username'];
//$email="kevin@gmail.com";
$image = " ";
if ((strtolower($name)) == "yoga") {
    $image = "images/Yoga.jpg";
}
if ((strtolower($name)) == "zumba") {
    $image = "images/Zumba.jpg";
}
$stmt->execute();
echo "Class Added";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

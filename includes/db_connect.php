<?php

$server_name = "localhost";
$user_name = "kevin";
$password = "1234";
$db_name = "extremefitness";
//$conn = mysqli_connect($server_name ,$user_name,$password , $db_name);
try
{
 $conn = new PDO("mysql:host=$server_name;dbname=$db_name", $user_name, $password);
}
catch(PDOException $e)
 {
    echo   "<br>" . $e->getMessage();
 }



?>
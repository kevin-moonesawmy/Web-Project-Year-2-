<?php 
    require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $workout_id=$_POST['id'];
    $name=$_POST['name'];
    $description=$_POST['description'];
    $body_part=$_POST["body_part"];
    $category=$_POST['category'];
    $comment=$_POST['comment'];
    $email="nat@gmail.com";
    $sql="INSERT INTO workout_plans VALUES('$workout_id','$name','$description','$body_part','$category','$category','$email',0)";
    $Result=$conn->query($sql);
?>
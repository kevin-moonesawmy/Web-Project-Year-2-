<?php 
    require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $workout_id=$_POST['workout_id'];
    $sql="SELECT * FROM workout_plans WHERE workout_id='$workout_id'";
    $Result=$conn->query($sql);
    $rowCount=$Result->rowCount();
    if($rowCount==0)
    {
        echo false;
    }
    else
    {
        echo true;
    }
?>
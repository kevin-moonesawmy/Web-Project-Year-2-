<?php 
    session_start();
    $coach_mail=$_SESSION['username'];
    require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql="SELECT b.*,u.firstname,u.lastname,w.name FROM bookings b,user_details u,workout_plans w WHERE b.member_mail=u.email AND b.coach_mail='$coach_mail' AND status='accepted' AND b.workout_id=w.workout_id AND coach_cancel='0' ORDER BY date,time_range";
    $Result=$conn->query($sql);
    if($Result->rowCount()>0)
    {
        $array_result=$Result->fetchAll(PDO::FETCH_ASSOC);
        $return_result['msg']='success';
        $return_result['data']=$array_result;
    }
    else
    {
        $return_result['msg']='fail';
        $return_result['data']='no data';
    }
    header('Content-Type: application/json'); 
    echo json_encode($return_result);
?>
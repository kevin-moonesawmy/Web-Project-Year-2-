<?php 
    session_start();
    use Opis\JsonSchema\{
        Validator, ValidationResult, ValidationError, Schema
    };
    require 'vendor/autoload.php';
	require_once "includes/db_connect.php";
    $coach_mail=$_SESSION['username'];
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql="SELECT b.*,u.firstname,u.lastname,w.name FROM bookings b,user_details u,workout_plans w WHERE b.member_mail=u.email AND b.coach_mail='$coach_mail' AND status='pending' AND b.workout_id=w.workout_id ORDER BY date,time_range";
    $Result=$conn->query($sql);
    $result_array=$Result->fetchAll(PDO::FETCH_ASSOC);
    $schema=Schema::fromJsonString(file_get_contents(__DIR__ . "/schemas/jsonSchemaBookingRequest.json"));
    $validator=new Validator();
    $data=json_encode($result_array,JSON_NUMERIC_CHECK);
    $data1=json_decode($data);
    $result=$validator->schemaValidation($data1,$schema);
    if($result->isValid())
    {
        header('Content-Type: application/json'); 
		echo json_encode($result_array);
    }
    else
    {
        $error = $result->getErrors();
	    echo '$data is invalid', PHP_EOL;
	    
	    foreach ($error as $key => $value) {
	    	# code...
	    	echo "Error: ", $value->keyword(), PHP_EOL;
	    	echo json_encode($value->keywordArgs(), JSON_PRETTY_PRINT), PHP_EOL;
        }
    } 
?>
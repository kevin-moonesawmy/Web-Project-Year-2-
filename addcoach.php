<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Extreme Fitness</title>
</head>
<body>
	<?php
		$submission["firstname"]=$submission["lastname"]=$submission["mail"]=$submission["dob"]=$submission["address"]=$submission["gender"]=$submission["tel"]=$submission["specialisationn"]=$submission["password"]="";
		if ($_SERVER['REQUEST_METHOD']=='POST')
		{
			$submission['firstname']=$_POST['txt_firstname'];
			$submission['lastname']=$_POST['txt_lastname'];
			$submission['mail']=$_POST['txt_email'];
			$submission['dob']=$_POST['txt_dob'];
			$submission['tel']=$_POST['txt_tel'];
			$submission['address']=$_POST['txt_address'];
			$submission['gender']=$_POST['txt_gender'];
			$submission['specialisation']=$_POST['txt_specialisation'];
			$submission['password']=$_POST['txt_password'];
			require_once "includes/db_connect.php";
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$sql = 'CALL insertUserDetails(:email,:lastname,:firstname,:dob,:address,:tel_no,:gender)';
			$stmt=$conn->prepare($sql);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':lastname',$lastname);
			$stmt->bindParam(':firstname',$firstname);
			$stmt->bindParam(':dob',$dob);
			$stmt->bindParam(':address',$address);
			$stmt->bindParam(':tel_no',$tel_no);
			$stmt->bindParam(':gender',$gender);
			$email=addslashes($submission['mail']);
			$lastname=($submission['lastname']);
			$firstname=($submission['firstname']);
			$dob=date("Y/m/d", strtotime($submission['dob']));
			$address=addslashes($submission['address']);
			$tel_no=$submission['tel'];
			$gender=($submission['gender']);
			$stmt->execute();

			$sql = 'CALL insertAccounts(:email,:password,:type)';
			$stmt=$conn->prepare($sql);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':password',$password);
			$stmt->bindParam(':type',$type);
			$password=password_hash($submission['password'], PASSWORD_DEFAULT);
			$type='coach';
			$stmt->execute();

			$sql = 'CALL insertCoach(:email,:type)';
			$stmt=$conn->prepare($sql);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':type',$type);
			$type=$submission['specialisation'];
			$result=$stmt->execute();

		}
	?>
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	<label>Email: </label>
	<input type="email" name="txt_email"><br>
	<label>First Name: </label>
	<input type="text" name="txt_firstname"><br>
	<label>Last Name: </label>
	<input type="text" name="txt_lastname"><br>
	<label>DOB: </label>
	<input type="date" name="txt_dob"><br>
	<label>address: </label>
	<input type="text" name="txt_address"><br>
	<label>tel: </label>
	<input type="tel" name="txt_tel"><br>
	<label>Gender: </label>
	Male<input type="radio" name="txt_gender" value="male">
	Female<input type="radio" name="txt_gender" value="female"><br>
	<label>Specialisation</label>
	<input type="text" name="txt_specialisation"><br>
	<label>Password: </label>
	<input type="password" name="txt_password"><br>
	<input type="submit">
	</form>
</body>
</html>
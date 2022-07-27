<?php
	session_start();
	require_once 'includes/db_connect.php' ;
	$email=$_SESSION['username'];
	$sQuery="SELECT * FROM accounts WHERE email='$email'";
	$Result=$conn->query($sQuery);
	$account=$Result->fetch();
	$old_pwd=$_POST['old_password'];
	$hashed_pwd=$account['password'];
	if (password_verify($old_pwd, $hashed_pwd))
	{
		echo true;
	}
	else
	{
		echo false;
	}
?>
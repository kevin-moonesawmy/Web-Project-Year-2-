<?php
session_start();

if (!isset($_GET['referer']))
{
	$_SESSION['email']="";
}
$error['username']=$error['password']="";
$submission['username'] = $submission['password']="";
$found=true;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty($_POST["txt_username"]))
    {
        $error['username']="Username is required";
    }
    else
    {
        $submission['username']=$_POST["txt_username"];
    }
    if(empty($_POST["txt_password"]))
    {
        $error['password']="Password is required";
    }
    else
    {
        $submission['password']=$_POST["txt_password"];
    }
    if($error['username']=="" && $error['password']=="")
    {
        require_once "includes/db_connect.php";
        $email=addslashes($submission['username']);
        $user_password=$submission['password'];
        $query = "SELECT * FROM accounts WHERE email='$email'";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result=$conn->query($query);
        $userResult=$result->fetch(PDO::FETCH_ASSOC);
        if($userResult['email'])//user exits
        {
        	$hashed_password=$userResult['password'];
            if(password_verify($user_password,$hashed_password))
            {
                $_SESSION['username']=$submission['username'];
                $_SESSION['password']=$submission['password'];
                if($userResult['acc_type']=='coach')
                {
                    header("Location:coach/home.php");
                    die();
                }
                if($userResult['acc_type']=='admin')
                {
                    header("Location:admin/index.php");
                    die();
                }
                $query = "SELECT * FROM user_details WHERE email='$email'";
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $result=$conn->query($query);
                $userResult=$result->fetch(PDO::FETCH_ASSOC);
                $_SESSION['firstname']=$userResult['firstname'];
                if (empty($_SESSION['redirectURL']))
                {
                    header('Location:home.php');
                }
                else
                {
                    header('Location: '.$_SESSION['redirectURL']);
                }
                //header("Location: home.php");
                die();
            }
            else
            {
                $found=false;
                $Msg= '<h4 style="color:red; text-align:left">Error: Wrong credentials.<br/> Try again or make sure you are a registered user!</h4>';
            }
        }
        else
        {
            $found=false;
            $Msg= '<h4 style="color:red; text-align:left">Error: Wrong credentials.<br/> Try again or make sure you are a registered user!</h4>';
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo time();?>">
	<title>Extreme Fitness</title>
	<style>
		button{
			width: 250px;
			height: 40px;
			font-size: 20px;
			background-color: #0736a6;
			border: none;
			color: white;
		    margin-top: 20px;
		    cursor: pointer;
            border-radius: 25px;
			}
		button:hover{
		    background-color: #000033;
		}
		::placeholder
		{
		    color: white;
		}
    </style>
</head>
<body class="loginstyle bodystyle">
	<?php
		$active_menu="login";
		include "includes/menu.php"; 
	?>
	<form class="formstyle" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" >
      <h1 style="margin-bottom: 30px; color:white;">LOG IN</h1>
      <input type="email" name="txt_username" value="<?php echo $_SESSION['email']; ?>" placeholder="Email address" class="inputstyle" <?php echo $submission['username'];?>required>
      <?php echo $error['username'];?>
      <input type="password" name="txt_password" placeholder="Password" class="inputstyle" <?php echo $submission['password'];?>required>
      <?php echo $error['password'];?>
      <?php if($found==false) echo $Msg; ?>
      <button  type="submit">Log In</button>
  </form>
  	<h4 style="color: white;">NOT A MEMBER YET?</h4>
      <a href="registration.php"><button type="submit">Create an account</button></a>


  	<br/><br/><br/><br/><br/><br/>
  <?php include 'includes/footer.php' ?>
</body>
</html>
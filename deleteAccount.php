<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtreme Fitness</title>
    <link rel="stylesheet" href="css/mystyle.css?v=<?php echo time(); ?>">
    <style>
        h2{
            color: white;
        }
        button{
                    width: 200px;
                    height: 50px;
                    margin: auto;
                    border-radius: 6px;
                    cursor: pointer;
                    font-size: 18px;
                    font-weight: bold;
                    color: white;
                    border: 1px solid rgb(6, 0, 255);
                    box-shadow: 0 0 5px rgb(6, 0, 255);
                    background: rgb(6, 0, 255,0.5);
                    position: relative;
                    top: -10px;
                    margin-top: 10px;
                }
        button:hover{
                    background: rgb(6, 0, 255,0.9);
                    transition: 1.5s;
                }
    </style>
</head>
<body class="bodystyle" style="font-family: sans-serif;">
    <?php
        $active_menu="login";
        include('includes/menu.php');
    ?>
    <br><br>
    <?php
    $email=$_SESSION['username'];
    $passwordErr="";
    $password="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(empty($_POST['txt_password']))
        {
            $passwordErr="Please enter your password";
        }
        else
        {
            $password=$_POST['txt_password'];
        }
        if($password==$_SESSION['password'])
        {
            require_once "includes/db_connect.php";
            $sQuery="DELETE FROM user_details WHERE email='$email'";
            $Result=$conn->exec($sQuery);
            if($Result)
            {
                echo "<h2>Your account has been successfully deleted!!!</h2>";
                echo '<a href="logout.php"><button>Back</button></a>';
            }
            else
            {
                echo "<h2>An error has occurred</h2>";
                echo '<a href="accont.php"><button>Back</button></a>';
            }
        }
        else{
            $passwordErr="Wrong password";?>
            <form class="formstyle" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <h1>Confirm Deletion</h1>
        <h3 style="color: white;">Your Password:</h3>
        <input type="password" name="txt_password"><br>
        <?php echo "<h4 style='color:red'>".$passwordErr."</h4>";?>
        <button type="submit">Confirm</button>
    </form>
    <a href="account.php"><button>Cancel</button></a>
        <?php }
        
    }
    else{
    ?>
    <form class="formstyle" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <h1>Confirm Deletion</h1>
        <h3 style="color: white;">Your Password:</h3>
        <input type="password" name="txt_password"><br>
        <?php echo "<h4 style='color:red'>".$passwordErr."</h4>";?>
        <button type="submit">Confirm</button>
    </form>
    <a href="accont.php"><button>Cancel</button></a>
    <?php
    }
        $count=1;
        while($count<=19)
        {
        echo "<br>";
        $count=$count+1;
        }
        include('includes/footer.php');
    ?>
</body>
</html>
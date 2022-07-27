<nav>
    <ul>
        <li><a href="home.php"><img class="logo" src="images/nav_bar_logo.png"></a></li>
        <li><a href="home.php" 
<?php

 if($active_menu == "home")
 {
   //echo "class=\"active\"";//escaping the double quotes
   echo "class='active'";//Toggle single and double quotes
   //echo 'class="active"';//Toggle single and double quotes
  
}//end if
?>	
>Appointment</a></li>
    <li><a href="add_workout.php"
    <?php
    if($active_menu=="workout")
    {
        echo "class='active'";
    }
    ?>
    >Workouts</a></li>
    <li><a href="add_onlineClass.php"
    <?php
    if($active_menu=="onlineClass")
    {
        echo "class='active'";
    }
    ?>
    >Online Classes</a></li>
    <li><a href="../logout.php">Logout</a></li>
    
    </ul>
</nav>
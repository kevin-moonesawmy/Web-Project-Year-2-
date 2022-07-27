<?php
require_once "includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT * FROM contact_us WHERE msg_read='0'";
$result=$conn->query($query);
$count=0;
while ($value=$result->fetch())
{
    $count++;
}    
?>
    <aside>
        <div class="top">
            <div class="logo">
                <img src="images/nav_bar_logo.png">
            </div>
        </div>

        <div class="sidebar">
            <a href="index.php" <?php
					if ($activemenu=="home")
					{
						echo "class='active'";
					} 
				?> ><span class="material-icons-sharp">home</span><h3>Home</h3></a>
            

            <a href="users.php" <?php
					if ($activemenu=="users")
					{
						echo "class='active'";
					} 
				?> ><span class="material-icons-sharp">manage_accounts</span><h3>Users</h3></a>
            

            <a href="coach.php" <?php
					if ($activemenu=="coach")
					{
						echo "class='active'";
					} 
				?> ><span class="material-icons-sharp">person_add</span><h3>Coach</h3></a>
            

            <a href="reviews.php" <?php
					if ($activemenu=="reviews")
					{
						echo "class='active'";
					} 
				?> ><span class="material-icons-sharp">reviews</span><h3>Reviews</h3></a>
            

            <a href="message.php" <?php
					if ($activemenu=="message")
					{
						echo "class='active'";
					} 
				?> ><span class="material-icons-sharp">mail_outline</span><h3>Message</h3>
            <span class="message-count"><?php echo $count;?></span>
        </a>
            

            <a href="../logout.php"><span class="material-icons-sharp">logout</span><h3>Logout</h3></a>  
        </div>
    </aside>

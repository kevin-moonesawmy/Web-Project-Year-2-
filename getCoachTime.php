<?php
	session_start();
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$user_mail=$_SESSION['username'];
	$email=$_POST['email'];
	$date=$_POST['date'];
	$selectedDay=explode(" ",$date);
	$sql="SELECT * FROM working_hours WHERE coach_mail='$email'";
	$Result=$conn->query($sql);
	$row=$Result->fetch();
	$days=explode("|",$row["working_day"]);
	$times=explode("|",$row['working_time']);
	$index=0;

	for($i=0;$i<sizeof($days);$i++)
	{
		if($days[$i]==$selectedDay[0])
		{
			$index=$i;
			break;
		}
	}
	$items=explode("-",$times[$index]);
	$start_time=explode(":",$items[0]);
	$end_time=explode(":",$items[1]);
	$count=1;
	$x=$start_time[0];
	$y=$end_time[0];
	for($j=$x;$j<$y;$j++)
	{
		$startRange="";
		if($start_time[0]<=9)
		{
			$startRange=$startRange."0".$start_time[0].":00";
		}
		else
		{
			$startRange=$startRange.$start_time[0].":00";	
		}
		$start_time[0]++;
		$end_range="";
		if($start_time[0]<=9)
		{
			$end_range=$end_range."0".$start_time[0].":00";
		}
		else
		{
			$end_range=$end_range.$start_time[0].":00";	
		}
		$full_range=$startRange."-".$end_range;
		?>
		<tr>
			<td><?php echo $startRange; ?></td>
			<td><?php echo $end_range; ?></td>
			<td><button type="button" class="slot_btn" <?php echo "id=slotBtn".$count; ?> onclick="select(<?php echo $count; ?>)"
			<?php
				$sql="SELECT * FROM bookings WHERE coach_mail='$email' AND date='$date' AND time_range='$full_range' AND status='pending' AND member_mail='$user_mail'";
				$Result=$conn->query($sql);
				$numrow=$Result->rowCount();
				if($numrow!=0)
				{
					echo " disabled>Pending";
				}
				else
				{
					$sql="SELECT * FROM bookings WHERE coach_mail='$email' AND date='$date' AND time_range='$full_range' AND status='accepted'";
					$Result=$conn->query($sql);
					$numrow=$Result->rowCount();
					if($numrow==0)
					{
						echo ">Select";
					}
					else
					{
						echo " disabled>Booked";
					}
				}
				 
			?>
			</button></td>
		</tr>
		<?php $count++;
	}
	?>

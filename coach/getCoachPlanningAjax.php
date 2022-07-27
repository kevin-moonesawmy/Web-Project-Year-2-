<?php 
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$email="nat@gmail.com";
	$sql="SELECT * FROM working_hours WHERE coach_mail='$email'";
	$Result=$conn->query($sql);
	$row=$Result->fetch();
	$days=explode("|",$row[1]);
	$buttonText="";
	$numDay=date('j');  //returns the day of the month 1-31
	$numWeekDay=date('N'); // 1-Monday 7-Sunday

	$checkDay=date('D')." ".date('d');
	$x=6;$y=6;
	
	?> 
    <h2>BOOKING TIMETABLE</h2>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <?php
                for($i=0;$i<7;$i++)
                {
                    while(!checkWorkingDay($days,$checkDay))
                    {
                        $checkDay=getNextDay($numWeekDay,$numDay);
                    }
                    $checkDay=getNextDay($numWeekDay,$numDay);
                    ?>
                    <th><?php echo $checkDay; ?></th>
                    <?php
                }
                ?>
            </tr>
        </thead>
    </table>
    <?php
	function checkWorkingDay($days,$day) //check whether the coach work on a certain day
	{
		foreach($days as $key)
		{
			$item=explode(" ",$day);
			if($key==$item[0])
			{
				return true;
			}
		}
		return false;
	}
	function getNextDay(&$day,&$numDay) 	//gets a textual day and returns its next day and date in the format 'Mon 03'
	{
		$nextDay="";
		if($day==1){
			$nextDay="Tue ";
		}
		else
		{
			if ($day==2)
			{
				$nextDay="Wed ";
			}
			else
			{
				if($day==3)
				{
					$nextDay="Thu ";
				}
				else
				{
					if($day==4)
					{
						$nextDay="Fri ";
					}
					else
					{
						if($day==5){
							$nextDay="Sat ";
						}
						else
						{
							if($day==6)
							{
								$nextDay="Sun ";
							}
							else
							{
								$nextDay="Mon ";
							}
						}
					}
				}
			}
		}
		if($numDay==28 && date('n')==2)
		{
			$newDay=0;
			if(date('L')==1)
			{
				$newDay=$numDay+1;
				$nextDay=$nextDay.$newDay;
			}
			else
			{
				$newDay=1;
				$nextDay=$nextDay."0".$newDay;

			}
		}
		else
		{
			if($numDay==30)
			{
				$c=date('n'); //current numeric month
				if($c==1 || $c==3 || $c==5 || $c== 7 || $c==8 || $c==10 || $c==12)
				{
					$newDay=31;
					$nextDay=$nextDay.$newDay;
				}
				else
				{
					$newDay=1;
					$nextDay=$nextDay."0".$newDay;				}
			}
			else
			{
				if($numDay==31)
				{
					$newDay=1;
					$nextDay=$nextDay."0".$newDay;
				}
				else
				{
					if($numDay<9)
					{
						$newDay=$numDay+1;
						$nextDay=$nextDay."0".$newDay;
					}
					else
					{
						$newDay=$numDay+1;
						$nextDay=$nextDay.$newDay;
					}
				}
			}
		}
		$numDay=$newDay;
		if($day==7)
		{
			$day=1;
		}
		else
		{
			$day++;
		}
		return $nextDay;
	}
?>
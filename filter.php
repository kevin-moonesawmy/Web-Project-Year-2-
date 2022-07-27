<?php
	sleep(1);
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql="SELECT * FROM workout_plans ";
	$email="kevinMoo@gmail.com";
	if(!empty($_POST['coach_name']))
	{
		$coach_email="";
		list($firstname,$lastname)=explode(" ", $_POST['coach_name']);
		$csql="SELECT email FROM user_details WHERE firstname='$firstname' AND lastname='$lastname'";
		$Result=$conn->query($csql);
		$result=$Result->fetch();
		$coach=$result["email"];
		$conn==null;
		$sql=$sql."WHERE coach_mail='$coach'";
	}
	if(!empty($_POST['category']))
	{
		$category=$_POST['category'];
		if(!empty($_POST['coach_name']))
		{
			$sql=$sql." AND category='$category'";
		}
		else
		{
			$sql=$sql." WHERE category='$category'";
		}
	}
	if(!empty($_POST['bodypart']))
	{
		$bodypart=$_POST['bodypart'];
		if(!empty($_POST['coach_name']) || !empty($_POST['category']))
		{
			$sql=$sql." AND body_part='$bodypart'";
		}
		else
		{
			$sql=$sql." WHERE body_part='$bodypart'";
		}
	}
	$order=$_POST['order'];
	$sql=$sql." ORDER BY likes ".$order;
	$Result=$conn->query($sql);
	$numrows=$Result->rowCount();
	if($numrows==0)
	{
		echo "<span class='error'>No results found.</span>";
	}
	else
	{
		$count=1;
		while($row=$Result->fetch())
		{
			$coach_mail=$row["coach_mail"];
			$sql="SELECT firstname,lastname FROM user_details WHERE email='$coach_mail'";
			$Result2=$conn->query($sql);
			$value=$Result2->fetch();
			$coach_name=$value['firstname']." ".$value["lastname"];
			?>
			<div class="list_element" <?php echo "id=item".$count; ?>>
				<h2 style="text-align: center; font-weight: bolder; margin-bottom: 20px; text-decoration: underline;"><?php echo $row["name"]; ?></h2>
				<label class="catLabel">Category: <span style="text-transform: capitalize;"><?php echo $row["category"]; ?></span></label>
				<label class="bodypartLabel">Body Part: <span style="text-transform: capitalize;"><?php echo $row["body_part"]; ?></span></label>
				<label class="coachLabel">By Coach: <?php echo $coach_name; ?></label>
				<br><br>
				<label class="commentLabel">Comment: <?php echo $row["comment"]; ?></label>
				<br><br>
				<label class="ratingLabel">Likes: <?php echo $row["likes"]; ?></label>
				<button class="item_btn more_btn" type="button" <?php echo "id=more_btn".$count; ?> onclick="display(<?php echo $count; ?>)">More<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
  								<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
								</svg>
							</button>
							<table class="descriTable" <?php echo "id=table".$count; ?>>
								<thead style="margin-bottom: 5px;">
									<th style="position: relative; right: 45px;">Exercise:</th>
									<th>Sets:</th>
									<th>Reps/Mins:</th>
								</thead>
								<tbody>
									 <?php
										$description=explode("|",$row["description"]);
										$size=sizeof($description);
										for ($i=0;$i<$size;$i++)
										{
											$item=explode(",",$description[$i]);
											$exercise=$item[0];
											$set=$item[1];
											$rep=$item[2];
											?>
											<tr>
											<td><?php echo $exercise; ?></td>
											<td><?php echo $set; ?></td>
											<td><?php echo $rep; ?></td>
											</tr>
											<?php 
										}
									?>  
								</tbody>
							</table>
							<button class="workout_btn save_btn" type="button" onclick="saveWorkout(<?php echo $count; ?>)"
								<?php
									echo " id=save_btn".$count;
									$workout_id=$row['workout_id'];
									$sql="SELECT * FROM save_workout WHERE member_mail='$email' AND workout_id='$workout_id'";
									$Result3=$conn->query($sql);
									$rows=$Result3->rowCount();
									if($rows>0)
									{
										echo " disabled>Saved";
									}
									else
									{
										echo ">Save Workout";
									}

								?>
							</button>
							<button class="workout_btn coach_btn" <?php echo "id=coach_btn".$count; ?> type="button">Coaching</button>
							<button class="workout_btn like_btn" type="button" onclick="likeWorkout(<?php echo $count; ?>)"
								<?php
									echo "id=like_btn".$count;
									 $workout_id=$row['workout_id'];
									$sql="SELECT * FROM like_workout WHERE member_mail='$email' AND workout_id='$workout_id'";
									$Result3=$conn->query($sql);
									$rows=$Result3->rowCount();
									if($rows>0)
									{
										echo " disabled>Liked";
									}
									else
									{
										echo ">Like Workout";
									}

								?>
							</button>
							<button style="position: relative; top:200px; left: 7px;" type="button" class="item_btn less_btn" <?php echo "id=less_btn". $count; ?> onclick="noDisplay(<?php echo $count; ?>)">Less<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
  								<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
								</svg>
							</button>
			</div>
			<?php $count++; }
	}

?>
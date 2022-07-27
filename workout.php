<?php 
	session_start();
	require_once "includes/db_connect.php";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
	$email='kevinMoo@gmail.com';
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo time();?>">
	<title>Xtreme Fitness</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$(".less_btn").hide();
			$(".descriTable").hide();
			$(".workout_btn").hide();
			$("#name_filter,#category_filter,#bodypart_filter,input[name='txt_order']").on('change', function() {
				filering();
			});
			
		});
		function filering()
		{
			var cname=$("#name_filter").val();
			var cat=$("#category_filter").val();
			var bpart=$("#bodypart_filter").val();
			var ord=$("input[name='txt_order']:checked").val();
			$.ajax({
				url:"filter.php",
				type: "POST",
				data: {coach_name: cname, category: cat, bodypart: bpart, order: ord},
				beforeSend:function(){
					$(".workout_list").html("<span class='error'>Working on it...</span>");
				},
				success:function(data){
					$(".workout_list").html(data);
					$(".less_btn").hide();
					$(".descriTable").hide();
					$(".workout_btn").hide();
				}

			});
		}
		function display(value)
		{
			var wid="#workout_id"+value;
			var workid=$(wid).val();
			$.ajax({
				url:"setWorkoutSession.php",
				method:"POST",
				data:{workout_id:workid},
				error:function(xhr)
				{
					alert(xhr.statusText);
				}

			});
			var itemid="#item"+value;
			var item=$(itemid);
		
			

			var morebtnid="#more_btn"+value;
			var more_btn=$(morebtnid);
			more_btn.hide();

			var tableid="#table"+value;
			var table=$(tableid);
			var height=table.height()+200;
			var divHeight="+="+height+"px";
			item.animate({height: divHeight});
			table.show();

			var savebtnid="#save_btn"+value;
			var save_btn=$(savebtnid);
			var coachbtnid="#coach_btn"+value;
			var coach_btn=$(coachbtnid);
			var likebtnid="#like_btn"+value;
			var like_btn=$(likebtnid);
			save_btn.show();like_btn.show();coach_btn.show();

			var lessbtnid="#less_btn"+value;
			var less_btn=$(lessbtnid);
			less_btn.show();
		}
		function noDisplay(value)
		{
			var itemid="#item"+value;
			var item=$(itemid);
			item.animate({height:"220px"});

			var lessbtnid="#less_btn"+value;
			var less_btn=$(lessbtnid);
			less_btn.hide();

			var savebtnid="#save_btn"+value;
			var save_btn=$(savebtnid);
			var coachbtnid="#coach_btn"+value;
			var coach_btn=$(coachbtnid);
			var likebtnid="#like_btn"+value;
			var like_btn=$(likebtnid);
			save_btn.hide();like_btn.hide();coach_btn.hide();

			var tableid="#table"+value;
			var table=$(tableid);
			table.hide();

			var morebtnid="#more_btn"+value;
			var more_btn=$(morebtnid);
			more_btn.show();
		}
		function saveWorkout(value)
		{
			var workout="#workout_id"+value;
			var workout_id=$(workout).val();
			$.ajax({
				url:"save_workout.php",
				type: "POST",
				data: {id:workout_id},
				success:function(data){
					var savebtnid="#save_btn"+value;
					var save_btn=$(savebtnid);
					save_btn.text("Saved");
					save_btn.prop("disabled",true);
				}

			});
			
		}
		function likeWorkout(value)
		{
			var workout="#workout_id"+value;
			var workout_id=$(workout).val();
			$.ajax({
				url:"like_workout.php",
				type: "POST",
				data: {id:workout_id},
				success:function(data){
					var likebtnid="#like_btn"+value;
					var like_btn=$(likebtnid);
					like_btn.text("Liked");
					like_btn.prop("disabled",true);
				}

			});
		}
	</script>
	<style>
		.workout_title{
			background: url(images/workout.jpg);
			background-position: center;
			background-size: cover;
			height: 400px;
			position: relative;
			margin-bottom: 10px;
		}
		.workout_title h2{
			color: white;
			position: absolute;
			left: 33%;
			top: 50%;
			font-family: sans-serif;
			font-size: 50px;
		}
		.start_text{
			width: 500px;
			height: 200px;
			margin: auto;
			margin-bottom: 5px;
		}
		.list_body{
			/*background: url(images/workout2.jpg);*/
			background-color: black;
			background-size: cover;
			background-position: center;
			height: 800px;
			width: 100%;
			padding: 0 10px;
		}
		fieldset{
			border: 2px solid;
			border-color: white;
			border-radius: 6px;
			margin: 20px 0;
			padding: 20px;
			height: 100%;
		}
		legend{
			font-weight: bold;
			color: white;
			margin: auto;
			padding: 0 20px;
			font-family: sans-serif;
			font-size: 25px;
			background: transparent;
		}
		.filters{
			border-bottom: 2px solid white;
			padding-bottom: 5px;
			margin-bottom: 10px;
		}
		.filters label{
			font-family: sans-serif;
			color: white;
			font-size: 18px;
		}
		#sort_label{
			margin-left: 80px;
			margin-right: 110px;
		}
		.filter_label{
			padding: 0 20px;
			margin-bottom: 10px;
		}
		.filter_select{
			position: relative;
			font-family: sans-serif;

		}
		.workout_list{
			color: white;
			font-family: sans-serif;
			height: 700px;
			padding: 0 10px;
			overflow: auto;
			overflow-x: hidden;
			scroll-behavior: smooth;
		}
		.list_element{
			padding: 1px;
			position: relative;
			height: 220px;
			overflow: hidden;
			background: rgb(6, 0, 255,0.5);
			border-radius: 6px;
			margin-bottom: 5px;
		}
		.list_element label{
			display: inline-block;
			padding-right: 10px;
			margin-bottom: 10px;
			position: absolute;
			font-size: 20px;
		}
		.coachLabel{
			left: 900px;
		}
		.bodypartLabel{
			left: 589px;
		}
		.catLabel{
			left: 200px;
		}
		.commentLabel,.ratingLabel{
			left: 470px;
		}
		.error{
			font-size: 25px;
			font-weight: bold;
			text-align: center;
			position: relative;
			left: 40%;
			top: 200px;
		}
		.item_btn{
			position: relative;
			top: 40px;
			left: 49%;
			font-size: 20px;
			background-color: transparent;
			outline: none;
			cursor: pointer;
			color: white;
			border: none;
		}
		.item_btn:hover{
			text-decoration:underline ;
		}
		.descriTable{
			position: relative;
			top: 90px;
			left: 8%;
			font-size: 20px;
			border-spacing: 170px 0;

		}
		thead{
			position: relative;
			right: 10px;
		}
		th{
			padding-bottom: 15px;
		}
		.workout_btn{
			position: relative;
			top: 140px;
			left: 50px;
			height: 40px;
			width: 200px;
			border-radius: 6px;
			border: 1px solid blue;
			font-weight: bold;
			cursor: pointer;
			background: transparent;
			color: white;
		}
		.workout_btn:hover{
			background: darkred;
		}
		.like_btn{
			position: relative;
			left: 47%;
		}
		.like_btn:disabled{
			background: darkgreen;
			cursor: default;
			border: 2px solid darkgreen;
		}
		.coach_btn{
			position: relative;
			left: 28%;
		}
		.save_btn{
			position: relative;
			left: 5%;
		}
		.save_btn:disabled{
			background: grey;
			cursor: default;
			border: 2px solid black;
		}
		
	</style>
</head>
<body>
	<div class="workout_title">
		<?php
			$active_menu="";
			include "includes/menu.php";
		?>
		<h2>WORKOUT PLANS</h2>
	</div>
	<div class="start_text"><h2 style="text-align: center; font-family: sans-serif; font-size: 200%;">WHERE TO START?</h2>
		<p style="color:#545454; font-size: 20px; text-align: center; font-family:Helvetica;">We have a variety of workout plans, personalised for different categories, designed by our coaches themselves and we think they will help get started in your journey!</p></div>
	<div class="list_body">
		<fieldset>
			<legend>Workout Plans</legend>
			<div class="filters">
				<label id="sort_label">Sort by:</label>
				<label class="filter_label">Coach:</label>
				<select name="txt_coach" class="filter_select" id="name_filter">
					<option value="" selected>Name</option>
					<?php
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql="SELECT firstname,lastname FROM user_details u,accounts a WHERE u.email=a.email AND acc_type='coach'";
						/*$stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
						$stmt->execute();*/
						$Result=$conn->query($sql);
						$conn==null;
						while($value=$Result->fetch())
						{
							$coach_name=$value['firstname']." ".$value["lastname"];
							?>
							<option value="<?php echo $coach_name; ?>"><?php echo $coach_name; ?></option>
						<?php }
					?>
				</select>
				<label class="filter_label">Category:</label>
				<select name="txt_category" class="filter_select" id="category_filter">
					<option value="" selected>All</option>
					<option value="yoga">Yoga</option>
					<option value="body building">Body-Building</option>
					<option value="circuit training">Circuit Training</option>
					<option value="weight loss">Weight Loss</option>
					<option value="body sculpturing">Body Sculpturing</option>
					<option value="recovery">Recovery</option>
					<option value="all rounder">All Rounder</option>
					<option value="cycling">Cycling</option>
					<option value="hiit">Hiit</option>
					<option value="cross fit">Cross Fit</option>
				</select>
				<label class="filter_label">Body Part:</label>
				<select name="txt_part" class="filter_select" id="bodypart_filter">
					<option value="" selected>All</option>
					<option value="upper">Upper Body</option>
					<option value="lower">Lower Body</option>
					<option value="full">Full Body</option>
				</select>
				<label class="filter_label">Likes:</label>
				<label>Asc</label>
				<input type="radio" name="txt_order" value="asc" >
				<label>Desc</label>
				<input type="radio" name="txt_order" value="desc" checked>DESC
			</div>
			<div class="workout_list">
				<?php
					if($_GET['referer']=="bookings")
					{
						$workid=$_SESSION['workout_id'];
						$sql="SELECT * FROM workout_plans WHERE workout_id='$workid'";
						$Result=$conn->query($sql);
						$workout=$Result->fetch();

						$coach_mail=$workout['coach_mail'];
						$sql="SELECT firstname,lastname FROM user_details WHERE email='$coach_mail'";
						$Result=$conn->query($sql);
						$coach=$Result->fetch();
						$coach_name=$coach['firstname']." ".$coach['lastname'];
				?>
						<div class="list_element" id="item1">
							<h2 style="text-align: center; font-weight: bolder; margin-bottom: 20px; text-decoration: underline;"><?php echo $workout["name"]; ?></h2>
						<input type="hidden" name="txt_id" id="workout_id1" value="<?php echo $workout['workout_id']; ?>">
						<label class="catLabel">Category: <span style="text-transform: capitalize;"><?php echo $workout["category"]; ?></span></label>
						<label class="bodypartLabel">Body Part: <span style="text-transform: capitalize;"><?php echo $workout["body_part"]; ?></span></label>
						<label class="coachLabel">By Coach: <?php echo $coach_name; ?></label>
						<br><br>
						<label class="commentLabel">Comment: <?php echo $workout["comment"]; ?></label>
						<br><br>
						<label class="ratingLabel">Likes: <?php echo $workout["likes"]; ?></label>
						<button class="item_btn more_btn" type="button" id="more_btn1" onclick="display(1)">More<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
  								<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
								</svg>
						</button>
						<table class="descriTable" id="table1">
							<thead style="margin-bottom: 5px;">
								<th style="position: relative; right: 45px;">Exercise:</th>
								<th>Sets:</th>
								<th>Reps/Mins:</th>
							</thead>
							<tbody>
								 <?php
									$description=explode("|",$workout["description"]);
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
						<button class="workout_btn save_btn" type="button" onclick="saveWorkout(1)" id="save_btn1"
								<?php
									$workout_id=$workout['workout_id'];
									$sql="SELECT * FROM save_workout WHERE member_mail='$email' AND workout_id='$workout_id'";
									$Result=$conn->query($sql);
									$rows=$Result->rowCount();
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
							<a href="bookings.php?referer=workout"><button class="workout_btn coach_btn" id="coach_btn1" type="button">Coaching</button></a>
							<button class="workout_btn like_btn" type="button" onclick="likeWorkout(1)" id="like_btn1"
								<?php
									 $workout_id=$workout['workout_id'];
									$sql="SELECT * FROM like_workout WHERE member_mail='$email' AND workout_id='$workout_id'";
									$Result=$conn->query($sql);
									$rows=$Result->rowCount();
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
							<button style="position: relative; top:200px; left: 7px;" type="button" class="item_btn less_btn" id="less_btn1" onclick="noDisplay(1)">Less<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
  								<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
								</svg>
							</button>
						</div>		
				<?php
					}
					else
					{

						$count=1;
						$sql="SELECT * FROM workout_plans ORDER BY likes DESC";
						$stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
						$stmt->execute();
						$conn==null;
						while($row=$stmt->fetch(PDO::FETCH_ASSOC))
						{
							$coach_mail=$row["coach_mail"];
							$sql="SELECT firstname,lastname FROM user_details WHERE email='$coach_mail'";
							$Result=$conn->query($sql);
							$value=$Result->fetch();
							$coach_name=$value['firstname']." ".$value["lastname"];
				?>
							<div class="list_element" <?php echo "id=item".$count; ?>>
							<h2 style="text-align: center; font-weight: bolder; margin-bottom: 20px; text-decoration: underline;"><?php echo $row["name"]; ?></h2>
							<input type="hidden" name="txt_id" <?php echo "id=workout_id".$count; ?> value="<?php echo $row['workout_id']; ?>">
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
									$Result=$conn->query($sql);
									$rows=$Result->rowCount();
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
							<a href="bookings.php?referer=workout"><button class="workout_btn coach_btn" <?php echo "id=coach_btn".$count; ?> type="button">Coaching</button></a>
							<button class="workout_btn like_btn" type="button" onclick="likeWorkout(<?php echo $count; ?>)"
								<?php
									echo "id=like_btn".$count;
									 $workout_id=$row['workout_id'];
									$sql="SELECT * FROM like_workout WHERE member_mail='$email' AND workout_id='$workout_id'";
									$Result=$conn->query($sql);
									$rows=$Result->rowCount();
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
				<?php 
						$count++; 
						}
					}	
				?>
			</div>
		</fieldset>
	</div>

</body>
</html>
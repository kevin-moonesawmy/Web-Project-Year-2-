<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo time();?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
	
	<title>Xtreme Fitness</title>
	<style>
		*{
			margin: 0;
			padding: 0;
		}
		body{
			background-image: url(images/reg_img3.jpg);
			background-position: center;
			background-size: cover;
			background-repeat: none;
			font-family: sans-serif;
		
		}
		.reg_form{
			margin: auto;
			width: 800px;
			background: rgb(255, 255, 255,0.7);
			padding: 10px;
			text-align: center;
			border-radius: 15px 15px 0 0;
			border: 1px solid black;
			border-bottom: none;
		}
		.reg_form h1{
			color: rgb(6, 0, 255);
		}
		.reg_form h4{
			color: red;
		}
		.main_form{
			width: 800px;
			margin: auto;
			padding: 10px;
			background: rgb(255, 255, 255,0.5);
			border: 1px solid black;
		}
		.form_label{
			display: block;
			margin-left: 20px;
			margin-top: 50px;
			font-size: 20px;
			font-weight: bold;
			position: relative;
		}
		.input_space{
			width: 650px;
			height: 30px;
			margin-left: 20px;
			border: none;
			outline: none;
			border-bottom: 1px solid black;
			background-color: transparent;
			padding: 0 10px 0 10px;
			font-size: 18px;
			position: relative;
			top: -30px;
		}
		.radio_label{
			position: relative;
			left: 250px;
			top: -20px;
			font-size: 18px;
		}
		.radio_btn{
			position: relative;
			left: 250px;
			top: -20px;
			margin-right: 10px;
		}
		.error_msg{
			color: red;
			font-weight: bold;
			display: block;
			margin-left: 20px;
			position: relative;
			top: -20px;
			font-size: 16px;
		}
		button{
			width: 200px;
			height: 50px;
			border: 1px solid rgb(6, 0, 255);
			box-shadow: 0 0 10px rgb(6, 0, 255);
			background-color: rgb(6, 0, 255,0.5);
			border-radius: 6px;
			cursor: pointer;
			margin: 20px;
			font-size: 20px;
			font-weight: bold;
			text-transform: uppercase;
			position: relative;
			left: 250px;
		}
		button:hover{
			background-color: rgb(6, 0, 255,0.9);
			transition: 1s;
		}
		button:disabled{
			background: grey;
			border: 2px solid black;
			box-shadow: none;
			cursor: default;
		}
		.pwd_icon{
			position: relative;
			top: -25px;
			left: 10px;
		}
		.membership_info{
			background-color: rgb(0, 0, 0,0.5);
			display: flex;
			width: 100%;
			border-top: 1px solid white;
			margin-top: 0;
			margin-bottom: 40px;
		}
		.monthly{
			margin-left: 250px;
		}
		.yearly{
			margin-left: 100px;
		}
		.yearly,.monthly{
			padding: 10px;
			color: white;
			font-size: 16px;
		}
		ul{
			margin-top: 5px;
		}
		li{
			font-size: 18px;
			margin: 10px 0;
		}

		
	</style>
<body>
	<?php
		if ($_SERVER['REQUEST_METHOD']=='POST')
		{
			function test_input($data) {
  			$data = trim($data);
  			$data = stripslashes($data);
  			$data = htmlspecialchars($data);
  			return $data;
  			}

			$submission["firstname"]=$submission["lastname"]=$submission["email"]=$submission["dob"]=$submission["address"]=$submission["gender"]=$submission["tel"]=$submission["type"]=$submission["password"]="";

			$submission['firstname']=test_input($_POST['txt_firstname']);
			$submission['lastname']=test_input($_POST['txt_lastname']);
			$submission['email']=test_input($_POST['txt_email']);
			$submission['dob']=test_input($_POST['txt_dob']);
			$submission['address']=test_input($_POST['txt_address']);
			$submission['gender']=test_input($_POST['txt_gender']);
			$submission['tel']=test_input($_POST['txt_tel']);
			$submission['type']=test_input($_POST['txt_type']);
			$submission['password']=test_input($_POST['txt_password']);

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

			$email=addslashes($submission['email']);
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
			$type='member';
			$stmt->execute();

			$sql = 'CALL insertMembership(:email,:type,:membership_end)';
			$stmt=$conn->prepare($sql);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':type',$type);
			$stmt->bindParam(':membership_end',$member_end);

			$type=$submission['type'];
			$result=$stmt->execute();
			if ($result)
			{
				$conn==null;
				$_SESSION['email']=$submission["email"];
				header("Location: login.php?referer=registration");
				die();
			}
			else
			{
				echo "Error infomations could not be saved";
			}

		}
		else
		{?>
	 <h1 style='text-align: center; font-weight: bold; background: rgb(0, 0, 0,0.5); color:white; padding: 5px 0;'>Type Of Membership:</h1>
	<div class="membership_info">
		<div class="monthly">
			<h2>Monthly</h2>
			<ul>
				<li>Renew your membership every month.</li>
				<li><b>Rs1149.00</b> charged per month.</li>
				<li>Membership are prepaid.</li>
				<li>Membership to be renewed 30 days following payment date.</li>
				<li>Payment can be made online or in cash.</li>
				<li>Recommended for those with a busy agenda but want to stay in shape.</li>
			</ul>
		</div>
		<div class="yearly">
			<h2>Yearly</h2>
			<ul>
				<li>Renew your membership every year.</li>
				<li><b>Rs1049.00</b> charged per month on a span of one year</li>
				<li>Membership are prepaid.</li>
				<li>Membership to be renewed 365 days following payment date.</li>
				<li>Amount payable per month will be direct debited from account.</li>
				<li>Recommended for those who are willing to commit the whole into achieving their goals.</li>
				<li><span style='color:cyan; font-weight:bold; text-decoration: underline;'>Amount will be debited from your account irrespective of your activity in our gym.</span></li>
			</ul>
		</div> 
	</div>
	<div class="reg_form">
		<h1>Become An Extremer</h1>
		<h4>Please fill out all fields</h4>
	</div>
	<form class="main_form"  method='post' action="<?php echo $_SERVER["PHP_SELF"];?>">
		<label class="form_label" id='email_label'>Email:</label>
		<input class="input_space" id='email_space' type='email' name='txt_email'><br>
		<span class="error_msg" id="email_error"></span>
		<label class="form_label" id='firstname_label'>Firstname(s):</label>
		<input class='input_space' id='firstname_space' type="text" name="txt_firstname"><br>
		<span class='error_msg' id='firstname_error'></span>
		<label class="form_label" id='lastname_label'>Lastname:</label>
		<input class='input_space' id='lastname_space' type="text" name="txt_lastname"><br>
		<span class='error_msg' id='lastname_error'></span>
		<label class="form_label" id='dob_label'>Date Of Birth:</label>
		<input class='input_space' id='dob_space' type="text" name="txt_dob" placeholder=""><br>
		<span class='error_msg' id='dob_error'></span>
		<label class="form_label" id='address_label'>Address:</label>
		<input class='input_space' id='address_space' type="text" name="txt_address"><br>
		<span class='error_msg' id='address_error'></span>
		<label class="form_label" id='tel_label'>Telephone No:</label>
		<input class='input_space' id='tel_space' type="text" name="txt_tel"><br>
		<span class='error_msg' id='tel_error'></span>
		<label class="form_label" style='display: inline-block;'>Gender:</label><br>
		<label class="radio_label">Male</label>
		<input type="radio" class='radio_btn' name="txt_gender" value='male'>
		<label class="radio_label">Female</label>
		<input type="radio" class='radio_btn' name="txt_gender" value='female'>
		<label class="radio_label">Other</label>
		<input type="radio" class='radio_btn' name="txt_gender" value='other'><br>
		<label class="form_label"style='display: inline-block;'>Subscription Type:</label><br>
		<label class="radio_label">Monthly</label>
		<input type="radio" class='radio_btn' name="txt_type" value='monthly'>
		<label class="radio_label">Yearly</label>
		<input type="radio" class='radio_btn' name="txt_type" value='yearly'><br>
		<label class="form_label" id='password_label'>Password:</label>
		<input class='input_space' id='password_space' type="password" name="txt_password"><br>
		<label class="form_label" id='confirm_password_label'>Confirm Password:</label>
		<input class='input_space' id='confirm_password_space' type="password" name="txt_confirm_password">
		<svg class='pwd_icon' id='error_icon' xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
  		<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
		</svg>
		<svg class="pwd_icon" id='correct_icon' xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
  		<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
		</svg>
		<br>
		<span class='error_msg' id='confirm_passsord_error'></span>
		<button id='reg_btn'>Register</button>
	</form>

<?php } ?>

	<br><br><br>
	<?php include "includes/footer.php"; ?>
</body>
 <script>
		$(document).ready(function(){

			//email space
			var email_error=true;
			$('#email_space').focus(function(){
				space_active($('#email_label'),$(this));
			});
			$($('#email_space')).blur(function(){
				var value=$(this).val();
				if (!value)
				{
					space_disactive($("#email_label"),$(this));
					$("#email_error").hide();
					email_error=true;
				}
				else
				{
					var pattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if (!pattern.test(value))
					{
						$("#email_error").text('Please enter the proper email format');
						$("#email_error").show();
						$(this).css("border-bottom",'1px solid red');
						email_error=true;
					}
					else
					{
						$(this).css("border-bottom",'1px solid rgb(6,0,225)');
						$("#email_error").hide();
						email_error=false;
					}
				}
			});

			//firstname spaces
			var firstname_error=true;
			$('#firstname_space').focus(function(){
				space_active($('#firstname_label'),$(this));
			});

			$('#firstname_space').blur(function(){
				var value=$(this).val();
				if (!value)
				{
					space_disactive($('#firstname_label'),$(this));
					$('#firstname_error').hide();
					firstname_error=true;
				}
				else
				{
					var pattern=/^([A-Z]([A-Z]*[a-z]*[\-]*[\']*))+( [A-Z]([A-Z]*[a-z]*[\-]*[\']*))*$/;
					if (!pattern.test(value))
					{
						$('#firstname_error').text("First Names may contain one or more words each starting with an upppercase and may contain other letters including characters like (') or (-)");
						$('#firstname_error').show();
						$(this).css('border-bottom','1px solid red');
						firstname_error=true;
					}
					else
					{
						$('#firstname_error').hide();
						$(this).css('border-bottom','1px solid rgb(6,0,255)');
						firstname_error=false;
					}
				}
			});
			//lastname space
			var lastname_error=true;
			$('#lastname_space').focus(function(){
				space_active($('#lastname_label'),$(this));
			});
			$('#lastname_space').blur(function(){
				var value=$(this).val();
				if (!value)
				{
					space_disactive($('#lastname_label'),$(this));
					$('#lastname_error').hide();
					lastname_error=true;
				}
				else
				{
					var pattern=/^[A-Z]([A-Z]*[a-z]*[\']*[\-]*)*$/;
					if (!pattern.test(value))
					{
						$(this).css("border-bottom",'1px solid red');
						$('#lastname_error').text("Lastname should contain only one word starting with an uppercase and may contain letters and characters like (') or (-)");
						$('#lastname_error').show();
						lastname_error=true;
					}
					else
					{
						$('#lastname_error').hide();
						$(this).css('border-bottom','1px solid rgb(6,0,255)');
						lastname_error=false;
					}
				}
			});

			//dob space
			var dob_error=true;
			$('#dob_space').focus(function(){
				space_active($('#dob_label'),$(this));
				$(this).prop("type","date");
			});
			$("#dob_space").blur(function() {
				var value=$(this).val();
				if (!value)
				{
					space_disactive($('#dob_label'),$(this));
					$('#dob_error').hide();
					$(this).prop("type","text");
					dob_error=true;
				}
				else
				{
					parts=value.split('-');
					var entered_date=new Date(parts[0],parts[1]-1,parts[2]); //creating date object with entered date from user
					var current_date=new Date(); //current date
					if (current_date<=entered_date)
					{
						$('#dob_error').text("Please enter an appropriate date");
						$("#dob_error").show();
						$(this).css("border-bottom",'1px solid red');
						dob_error=true;
					}
					else
					{
						$('#dob_error').hide();
						$(this).css("border-bottom",'1px solid rgb(6,0,255)');
						dob_error=false;
					}
				}
			});

			//address space
			var address_error=true;
			$("#address_space").focus(function(){
				space_active($('#address_label'),$(this));
			});
			$("#address_space").blur(function(){
				var value=$(this).val();
				if (!value)
				{
					space_disactive($("#address_label"),$(this));
					address_error=true;
				}
				else
				{
					address_error=false;
				}
			});

			//tel space
			var tel_error=true;
			$("#tel_space").focus(function(){
				space_active($("#tel_label"),$(this));
			});
			$("#tel_space").blur(function(){
				var value=$(this).val();
				if (!value)
				{
					space_disactive($('#tel_label'),$(this));
					$('#tel_error').hide();
					tel_error=true;
				}
				else
				{
					var pattern=/^[5][0-9]{7}$/;
					if (!pattern.test(value))
					{
						$("#tel_error").text("Telephone No should be in the following format 5(1234567)")
						$("#tel_error").show();
						$(this).css("border-bottom",'1px solid red');
						tel_error=true;
					}
					else
					{
						$('#tel_error').hide();
						$(this).css("border-bottom",'1px solid rgb(6,0,255)');
						tel_error=false;
					}
				}
			});

			//password space
			var password_error=true;
			$("#password_space").focus(function(){
				space_active($('#password_label'),$(this));
			});
			$("#password_space").blur(function(){
				var value=$(this).val();
				if (!value)
				{
					space_disactive($("#password_label"),$(this));
					password_error=true;
				}
				else
				{
					password_error=false;
				}
			});

			//confirm password space
			var confirm_password_error=true;
			$(".pwd_icon").hide();
			$("#confirm_password_space").focus(function(){
				space_active($("#confirm_password_label"),$(this));
			});
			$("#confirm_password_space").blur(function(){
				var value=$(this).val();
				if (!value)
				{
					space_disactive($("#confirm_password_label"),$(this));
					$('.pwd_icon').hide();
					confirm_password_error=true;
				}
			});
			$("#confirm_password_space").keyup(function(){
				var current_pwd=$('#password_space').val();
				var confirm_pwd=$(this).val();
				if(confirm_pwd!==current_pwd)
				{
					$("#correct_icon").hide();
					$("#error_icon").show();
					$(this).css("border-bottom",'1px solid red');
					confirm_password_error=true;
				}
				else
				{
					$("#error_icon").hide();
					$("#correct_icon").show();
					$(this).css("border-bottom",'1px solid rgb(6,0,255)');
					confirm_password_error=false;
				}

			});
			$("#reg_btn").click(function(){
				if(email_error)
				{
					alert("There is a problem with the email field");
				}
				else
				{
					if (firstname_error)
					{
						alert("There is a problem with the firstnames field");
					}
					else
					{
						if (lastname_error)
						{
							alert("There is a problem with the lastname field");
						}
						else
						{
							if (dob_error)
							{
								alert("There is a problem with the dob field");
							}
							else
							{
								if (address_error)
								{
									alert('Please enter your address');
								}
								else
								{
									if (tel_error)
									{
										alert("There is a problem with the Telephone field");
									}
									else
									{
										var gender=$("input[name='txt_gender']:checked").val();
										if (!gender)
										{
											alert("Please select a gender");
										}
										else
										{
											var type=$("input[name='txt_type']:checked").val();
											if (!type)
											{
												alert("Please select a type of subscription");
											}
											else
											{
												if (password_error)
												{
													alert("Please choose a password");
												}
												else
												{
													if (confirm_password_error)
													{
														alert("Please confirm your password and make sure they match");
													}
													else
													{
														$('form').submit();
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			});

			//when input fields are active
			function space_active(label,space)
			{
				label.animate({
					top: '-40px',
					fontSize: '16px'
				},'.5s');
				label.css('color','blue');

				space.css('border-bottom','1px solid rgb(6,0,255)');
			}

			//when input fields lose focus
			function space_disactive(label,space)
			{
				label.animate({
					top: '0',
					fontSize: '20px'
				},'.5s');
				label.removeAttr('style');
				space.removeAttr('style');
			}

		});
	</script>
</html>

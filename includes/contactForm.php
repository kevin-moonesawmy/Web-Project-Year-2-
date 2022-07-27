<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style>
		.error {color: #FF0000;}
            .container { 
                height: 20px;
                position: relative;
            }
            .button {
                background-color: #0736a6;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
            }           
	</style>
</head>
<body>
		<?php
	            $error['nameErr']=$error['emailErr']=$error['message']="";
	            $submission['name']=$submission['email']=$submission['number']=$submission['message']="";
	            if($_SERVER["REQUEST_METHOD"]=="POST")
	            {
	                if(empty($_POST["txt_name"]))
	                {
	                    $error['nameErr'] = "Name is required";
	                }
	                else
	                {
	                    $submission['name']=test_input($_POST["txt_name"]);
	                }
	                if(empty($_POST["txt_email"]))
	                {
	                    $error['emailErr'] = "Email is required";
	                }
	                else
	                {
	                    $submission['email']=test_input($_POST["txt_email"]);
	                }
	                if(!empty($_POST["txt_telephone"]))
	                {
	                    $submission['number'] = $_POST["txt_telephone"];
	                }
	                if(empty($_POST["txt_message"]))
	                {
	                    $error['message'] = "Message cannot be empty";
	                }
	                else
	                {
	                    $submission['message']=test_input($_POST["txt_message"]);
	                }
	                if($error['nameErr']=="" && $error['emailErr']=="" && $error['message']=="")
		            {
		                require_once "includes/db_connect.php";
		                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		                $sql = 'CALL insertmessage(:name,:email,:tel_no,:message,:message_read,:date_posted)';
		                $stmt = $conn->prepare($sql);
		                $stmt->bindParam(':name',$name);
		                $stmt->bindParam(':email',$email);
		                $stmt->bindParam(':tel_no',$tel_no);
		                $stmt->bindParam(':message',$message);
		                $stmt->bindParam(':date_posted',$date_posted);
		                $stmt->bindParam(':message_read',$message_read);

		                $name=($submission['name']);
		                $email=($submission['email']);
		                $tel_no=($submission['number']);
		                $message=($submission['message']);
		                $date_posted=strftime("%Y-%m-%d");
		                $message_read='0';
		                $stmt->execute();
		                $conn==null;
		            }
		            else
		            { ?>
		            	<h2 style="font-family:sans-serif;">WRITE US</h2>
	        			<p style="color: #545454;">Jot us a note and we'll get back to you as quickly as possible.</p>
	        			<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
			                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>YOUR NAME:<span class="error">*</span></b></p>
			                <input type="text" name="txt_name" size="50" value="<?php echo $submission['name']; ?>" pattern="[A-Z]*[a-z]+[-]*( [A-Z]*[a-z]+[-]*)*$" placeholder="YOUR NAME" required>
			                <?php echo $error['nameErr'];?>
			                <br/><br/>
			                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>EMAIL ADDRESS:<span class="error">*</span></b></p>
			                <input type="email" name="txt_email" size="50" value="<?php echo $submission['email']; ?>" placeholder="EMAIL ADDRESS"required>
			                <?php echo $error['emailErr'];?>
			                <br/><br/>
			                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>PHONE NUMBER (OPTIONAL):</b></p>
			                <input type="tel" name="txt_telephone" minlength="7" maxlength="8" value="<?php echo $submission['number']; ?>" pattern="[5]*[0-9]{7}" placeholder="PHONE NUMBER"/>
			                <br/><br/>
			                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>YOUR MESSAGE:<span class="error">*</span></b></p>
			                <textarea rows="10" cols="40" name="txt_message" placeholder="YOUR MESSAGE" required></textarea>
			                <?php echo $error['message']; ?>
			                <br/><br/>.
			                <div class="container">
			                    <input type="submit" value="SEND MESSAGE" class="button" style="cursor: pointer;"/>
			                </div>     
		        		</form>

		            <?php }
		            
	            }
	            function test_input($data) {
	                $data = trim($data);
	                $data = stripslashes($data);
	                $data = htmlspecialchars($data);
	                return $data;
	              }
	    ?>
	    	<h2 style="font-family:sans-serif;">WRITE US</h2>
	        <p style="color: #545454;">Jot us a note and we'll get back to you as quickly as possible.</p>
	        <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
	                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>YOUR NAME:<span class="error">*</span></b></p>
	                <input type="text" name="txt_name" size="50" value="" pattern="[A-Z]*[a-z]+[-]*( [A-Z]*[a-z]+[-]*)*$" placeholder="YOUR NAME" required>
	                <br/><br/>
	                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>EMAIL ADDRESS:<span class="error">*</span></b></p>
	                <input type="email" name="txt_email" size="50" value="" placeholder="EMAIL ADDRESS"required>
	                <br/><br/>
	                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>PHONE NUMBER (OPTIONAL):</b></p>
	                <input type="tel" name="txt_telephone" minlength="7" maxlength="8" value="" pattern="[5]*[0-9]{7}" placeholder="PHONE NUMBER"/>
	                <br/><br/>
	                <p style="font-family:sans-serif;text-align:left; font-size:70%;"><b>YOUR MESSAGE:<span class="error">*</span></b></p>
	                <textarea rows="10" cols="40" name="txt_message" placeholder="YOUR MESSAGE" required></textarea>
	                <br/><br/>.
	                <div class="container">
	                    <input type="submit" value="SEND MESSAGE" class="button" style="cursor: pointer;"/>
	                </div>     
	        </form>

	        
	       <!--  <?php
	           if ($_SERVER["REQUEST_METHOD"] == "POST" && $error['nameErr']=="" && $error['emailErr']=="" && $error['message']=="")
	            {
	                echo "<h2>Your input:</h2>";
	                echo "Name: ";
	                echo $submission['name'];
	                echo "<br>";
	                echo "Email: ";
	                echo $submission['email'];
	                echo "<br>";
	                echo "Phone number: ";
	                echo $submission['number'];
	                echo "<br>";
	                echo "Message: ";
	                echo $submission['message'];
	                echo "<br>";
	            }
	    	?> -->
	</body>
</html>
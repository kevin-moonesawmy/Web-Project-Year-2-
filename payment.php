<?php 
	session_start();
	$email='kevinMoo@gmail.com';
	require_once "includes/db_connect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
	<script>
		
	</script>
	<title>Extreme Fitness</title>
</head>
<body>
	<?php
		$sQuery="SELECT * FROM membership WHERE email='$email'";
		$Result=$conn->query($sQuery);
		$membership=$Result->fetch();
		$type=$membership['type'];	
	?>
	<h2 class='head'>Settle payment to continue.</h2>
	<div class="current_info">
		<form class='info'>
			<label class="info_label">Current Subscription Type:</label>
			<input type="text" name="txt_type" value='<?php echo $type ?>' disabled><br>
			<label class='info_label'>Expired On:</label>
			<input type="text" name="txt_expire" value='<?php echo $membership["membership_end"]; ?>' disabled><br>
			<label class="info_label">Monthly Payment:</label>
			<input type="text" name="" value=
				<?php
					if ($type=='monthly')
					{
						echo "'Rs 1149.00'";
					}
					else
					{
						echo "'Rs 1049.00'";
					} 
				?>
			 disabled><br>		
			<a class="change_type">Change Subscription Type</a>
		</form>
	</div>
	<br>
	<div class="payment">
		<?php
			if ($type=='monthly')
			{?>
				<h3>Payment can also be made in cash at counter.</h3>
				<form method='post' action='<?php echo $_SERVER["PHP_SELF"]?>'>
					<label class="payment_label">Account No:</label>
					<input type="text" name="" placeholder="1111-2222-3333-4444" required><br>
					<label class="payment_label">Amount:</label>
					<input type="text" name="" value='Rs 1149.00' disabled><br>
					<label class="payment_label">Pin:</label>
					<input type="password" name="" maxlength="4" required><br>
					<button>Confirm Payment</button>
				</form>
			<?php }
			else
			{?>
				<form method='get' action='<?php echo $_SERVER["PHP_SELF"]?>'>
					<h3>Rs 1049.00 will be debited monthly from this account</h3>
					<label class='payment_label'>Account No:</label>
					<input type="text" name="" placeholder="1111-2222-3333-4444" required><br>
					<label class="payment_label">Expiry Date:</label>
					<input type="text" name="" placeholder="mm/yy" required><br>
					<label class="payment_label">CVV:</label>
					<input type="text" name="" placeholder='123' required><br>
					<label class="payment_label">Amount:</label>
					<input type="text" name="" value='Rs 1149.00' disabled><br>
					<label class="payment_label">Pin: </label>
					<input type="text" name="" required><br>
					<button>Confirm Payment</button>
				</form>

			<?php } ?>	
	</div>
</body>
</html>
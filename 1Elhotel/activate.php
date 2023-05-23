<title>El Hotel • Activation</title>
   <!-- for web icon-->
   <link rel = "icon" href = "images/elhotel.png" type = "image/jpg">


<!-- <link rel="stylesheet" href="css/style.css"> -->
<?php
	include 'components/connect.php';
	
	
		// $conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE code=:code");
		$stmt->execute(['code'=>$_GET['code']]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			if($row['status']){
				echo '
					<center><div class="alert alert-danger">
		                <h4><i class="icon fa fa-warning"></i> Error!</h4>
		                Account already activated.
		            </div>
		            <h4>You may now Log in now <a href="login.php">Login</a>.</h4></center>
				';
			}
			else{
				try{
					$stmt = $conn->prepare("UPDATE users SET status=:status WHERE id=:id");
					$stmt->execute(['status'=>1, 'id'=>$row['id']]);
					echo '
						<center><div class="alert alert-success">
			                <h4><i class="icon fa fa-check"></i> Success!</h4>
			                Account activated - Email: <b>'.$row['email'].'</b>.
			            </div>
			            <h4>You may Log in now <a href="login.php">Login</a>.</h4></center>
					';
				}
				catch(PDOException $e){
					echo '
						<center><div class="alert alert-danger">
			                <h4><i class="icon fa fa-warning"></i> Error!</h4>
			                '.$e->getMessage().'
			            </div>
			            <h4>You may Login now <a href="home.php">Login</a>.</h4></center>
					';
				}

			}
			
		}
		else{
			 echo '
				<div class="alert alert-danger">
	                <h4><i class="icon fa fa-warning"></i> Error!</h4>
	                Cannot activate account. Wrong code.
	            </div>
	            <h4>You may <a href="register.php">Register</a> or back to <a href="home.php">Homepage</a>.</h4>
			';
		}

		// $pdo->close();
?>
<body>
<div>
  
</div>


</body>
</html>
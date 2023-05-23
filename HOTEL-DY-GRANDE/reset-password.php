<?php

session_start();

error_reporting(0);

include('includes/dbconnection.php');


if (isset($_SESSION['forrec_code'])) {

	if (isset($_POST['submit'])) 
	{
		$email=$_SESSION['forrec_email'];
		$ret="SELECT * FROM tbluser WHERE code='{$_SESSION['forrec_code']}' AND Email=:email";
		$query= $dbh -> prepare($ret);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query-> execute();

		if($query->rowCount() > 0) {		

			$newpassword=md5($_POST['newpassword']);

			$con="update tbluser set Password=:newpassword where code='{$_SESSION['forrec_code']}' AND Email=:email";

			$chngpwd1 = $dbh->prepare($con);

			$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);

			$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);

			$chngpwd1->execute();
				
			$code=md5(rand());

			$con2="update tbluser set code=:code where code='{$_SESSION['forrec_code']}'";

			$updatecode = $dbh->prepare($con2);

			$updatecode-> bindParam(':code', $code, PDO::PARAM_STR);

			$updatecode->execute();

			unset($_SESSION['forrec_code']);
			unset($_SESSION['forrec_email']);
			session_destroy();

			echo "<script>
			alert('Your Password succesfully changed');
			window.location.href='signin.php';
			</script>";
		}
		else 
		{
		echo "<script>
		alert('OTP sync is invalid.');
		window.location.href='index.php';
		</script>";
		}
	}
} 
else 
{
	header("Location: index.php");
}







?>

<!DOCTYPE HTML>

<html>

<head>

<title>Hotel Dy Grande | Hotel :: Forgot Password Page</title>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />



<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/bootstrap.js"></script>

<script src="js/responsiveslides.min.js"></script>

 <script>

    $(function () {

      $("#slider").responsiveSlides({

      	auto: true,

      	nav: true,

      	speed: 500,

        namespace: "callbacks",

        pager: true,

      });

    });

  </script>

<script type="text/javascript">

function valid()

{

if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)

{

alert("New Password and Confirm Password Field do not match  !!");

document.chngpwd.confirmpassword.focus();

return false;

}

return true;

}

</script>

</head>

<body>

		<!--header-->

			<div class="header head-top">

				<div class="container">

			<?php include_once('includes/header.php');?>

		</div>

</div>

<!--header-->

		<!--about-->

		

			<div class="content">

				<div class="contact">

				<div class="container">

					

					<h2>Reset Your Password.</h2>

					

				<div class="contact-grids">

					

						<div class="col-md-6 contact-right">

							<form method="post" name="chngpwd" onSubmit="return valid();">

								<h5>New Password</h5>

								<input type="password" placeholder="New Password" name="newpassword" required="true" class="form-control">

								<h5>Confirm Password</h5>

								<input type="password" placeholder="Confirm Password" name="confirmpassword" required="true" class="form-control">

								<br/>

								 <input type="submit" value="Reset" name="submit">

						 	 </form>



						</div>

						<div class="clearfix"></div>

					</div>

				</div>

			</div>

		<?php include_once('includes/getintouch.php');?>

			</div>

			<?php include_once('includes/footer.php');?>

</html>


<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>El Hotel • Forgot Password</title>
   <!-- for web icon-->
   <link rel = "icon" href = "images/elhotel.png" type = "image/jpg">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
    
    <?php
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\SMTP;
                    use PHPMailer\PHPMailer\Exception;
                   
                    function sendEmail($email,$reset_token){
                        require 'C:\xampp\htdocs\1Elhotel\PHPMailer\src\Exception.php';
                        require 'C:\xampp\htdocs\1Elhotel\PHPMailer\src\PHPMailer.php';
                        require 'C:\xampp\htdocs\1Elhotel\PHPMailer\src\SMTP.php';

                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'elhotel06@gmail.com';                     //SMTP username
                    $mail->Password   = 'dggqlbwqzjsitpsi';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('elhotel06@gmail.com', 'El Hotel');
                    $mail->addAddress($email);     //Add a recipient
                    // $mail->addAddress('ellen@example.com');               //Name is optional
                    // $mail->addReplyTo('info@example.com', 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Password Reset from El Hotel';
                    $mail->Body    = "We got a request from you to reset your password! <br>
                    Here's your Reset Code:<b>$reset_token</b> <br>
                    <a href='http://localhost/1Elhotel/forgot_pass_token.php?email=$email&reset_token=$reset_token'>Reset Password Here the link</a>";
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();

                    // echo 'Message has been sent';
                    return true;
                    } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    }
                    if(isset($_POST['reset_btn']))
                    {
                        $email = $_POST['email'];
                        $email = filter_var($email, FILTER_SANITIZE_STRING);

                        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
                        $select_user->execute([$email]);
                        $row = $select_user->fetch(PDO::FETCH_ASSOC);
                        if($row)
                        {
                            if($select_user->rowCount() > 0 == 1)
                        {
                            $reset_token = mt_rand(100000,999999); 
                            date_default_timezone_set('Asia/Manila');
                            $date=date("Y-m-d");

                            $select_user1 = $conn->prepare("UPDATE `users` SET `reset_token`='$reset_token',
                            WHERE email = '$_POST[email]'");
                            if($select_user1($_POST['email'], $reset_token) && sendEmail($_POST['email'],$reset_token))
                            {
                                echo  "<script>
                                alert('Password Reset Link Sent to Email');
                                window.location.href='login.php';
                                </script>";
                            }else
                            {//queryend
                            echo  "<script>
                            alert('Try Again later');
                            window.location.href='forgot.php';
                            </script>";
                            }
                        }else
                        {//mysqlinumrow end
                            echo  "<script>
                            alert('Not Exist user email');
                            window.location.href='forgot.php';
                            </script>";
                        }
                        }
                        else
                        {//$result End
                            echo  "<script>
                            alert('Cannot run query');
                            window.location.href='forgot.php';
                            </script>";
                        }
                    }
                    ?>
</head>	
<body>
    <!-- header section starts  -->
    <?php include 'components/user_header.php'; ?>
    <!-- header section ends -->


    <div class="body_image">
        <img src="img3.jpg" alt="" srcset="">
<div class="form-container">
    <form action="forgot.php" method="POST" class="form-wrap">
        <h2>Forgot Password</h2>
        <div class="form-box">
            <input type="text" placeholder="Enter Email"  required id="email" name="email"/>
        </div>
        <div class="form-submit">
            <input type="submit" value="Submit" id="reset_btn" name="reset_btn"/>
        </div>
    </form>
</div>
</div>
<video autoplay muted loop id="myVideo">
        <source src="images/vid-2.mp4" type="video/mp4">
   </video>
<section class="form-container">

   <form action="forgot.php" method="post">
      <h3>Forgot Password</h3>
      <input type="email" name="email" required placeholder="Enter your email" id="email" name="email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
       <input type="submit" value="Submit" id="reset_btn" name="reset_btn" class="btn"/>
   </form>

</section>



<?php include 'components/footer.php'; ?>






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
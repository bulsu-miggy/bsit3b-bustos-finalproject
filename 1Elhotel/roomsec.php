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
   <title>El Hotel • Room Section</title>
   <!-- for web icon-->
   <link rel = "icon" href = "images/elhotel.png" type = "image/jpg">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <script type="text/javascript" src="js/jquery-3.6.4.min.js"></script>
   <script type="text/javascript" src="js/hotelRoomScript.js"></script>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Our rooms</h3>
   <p><a href="home.php">Home</a> <span> / Rooms</span></p>
</div>

<!-- menu section starts  -->

<section class="rooms">

   <h1 class="title">Room & Suite</h1>

   <div class="container my-5">
      <div id="room-list" class="row">

      </div>
   </div>

   <div class="box-container col-4 pb-4 d-none" id="display-template-room">
      <?php
         /*$select_rooms = $conn->prepare("SELECT * FROM `rooms`");
         $select_rooms->execute();
         if($select_rooms->rowCount() > 0){
            while($fetch_rooms = $select_rooms->fetch(PDO::FETCH_ASSOC)){*/
      ?>
      <form action="" method="post" class="box">
         
         <div class="img-room-cover"><img class="room-img-top" id="card-img1" src="" /></div>

         <center><a href="" class="cat room-text"></a></center>
         <div class="name room-title"></div>
         <div class="flex">
            <div class="price room-subtitle">₱<span> per night</span></div>
         </div>
         <center><button type="submit" class="btn">View Room</button> </center>
      </form>
      <?php
           /* }
         }else{
            echo '<p class="empty">No rooms added yet!</p>';
         }*/
      ?>

   </div>

</section>



<!-- menu section ends -->
























<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
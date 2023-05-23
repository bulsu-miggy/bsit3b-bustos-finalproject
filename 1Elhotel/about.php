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
   <title>El Hotel • About</title>
   <!-- for web icon-->
   <link rel = "icon" href = "images/elhotel.png" type = "image/jpg">


   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>About us</h3>
   <p><a href="home.php">Home</a> <span> / About</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/hotel-img.svg" alt="">
      </div>

      <div class="content">
         <h3>El Hotel</h3>
         <p align="justify">
         Located in the center of Bulacan, 
         The El Hotel has set the benchmark for luxury and sophistication for over four decades.
          Known affectionately as the “Jewel in the Capital’s 
          Crown” for its legendary presence in the heart of the Philippines’ 
          primary business district, it is a luxurious haven of comfort, quality service and fine cuisine, 
          and is as much a favorite with discerning locals as it is with visitors from overseas. 
          For the second year, The El Hotel is awarded the coveted Forbes Travel Guide Five-Star rating – 
          the only hotel in the principal central business districts of Bulacan to receive the coveted ranking in the publisher’s 
          annual announcement of the world’s finest luxury hotels.
         </p>
         <a href="roomsec.php" class="btn">Our Rooms</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->



<!-- steps section ends -->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="title">customer's Feedbacks</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            if($select_messages->rowCount() > 0){
            while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
         ?>
         <div class="swiper-slide slide">
            <img src="images/default-avatar.png" alt="">
            <h3><?= $fetch_messages['name']; ?></h3>
            <p align="justify"><?= $fetch_messages['message']; ?></p>
            
           
         </div>
      <?php
            }
         }else{
            echo '<p class="empty">No reviews yet!</p>';
         }
      ?>
      
      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<!-- reviews section ends -->



















<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
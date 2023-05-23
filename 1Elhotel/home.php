<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>El Hotel • Homepage</title>

   <!-- for web icon-->
   <link rel = "icon" href = "images/elhotel.png" type = "image/jpg">

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <script type="text/javascript" src="js/jquery-3.6.4.min.js"></script>
   <script type="text/javascript" src="js/hotelDishScript.js"></script>
   <script type="text/javascript" src="js/hotelRoomScript.js"></script>
</head>
<body>

<?php include 'components/user_header.php'; ?>


<section class="home" id="home">

    <div class="content">
        <h3>Welcome to El Hotel</h3>
        <p>Come, stay and enjoy your day.</p>
    </div>

    <div class="controls">
        <span class="vid-btn active" data-src="images/vid-1.mp4"></span>
        <span class="vid-btn" data-src="images/vid-3.mp4"></span>
        <span class="vid-btn" data-src="images/vid-4.mp4"></span>
        <span class="vid-btn" data-src="images/vid-5.mp4"></span>
        <span class="vid-btn" data-src="images/vid-6.mp4"></span>
    </div>

    <div class="video-container">
        <video src="images/vid-1.mp4" id="video-slider" loop autoplay muted></video>
    </div>
</section>




<section class="category">

   <h1 class="title">food category</h1>

   <div class="box-container">

      <a href="category.php?category=fast food" class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fast food</h3>
      </a>

      <a href="category.php?category=main dish" class="box">
         <img src="images/cat-2.png" alt="">
         <h3>main dishes</h3>
      </a>

      <a href="category.php?category=drinks" class="box">
         <img src="images/cat-3.png" alt="">
         <h3>drinks</h3>
      </a>

      <a href="category.php?category=desserts" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>desserts</h3>
      </a>

   </div>

</section>



<!-- eto ang ieedit!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
<section class="products">

   <h1 class="title">Latest dishes</h1>

   <div class="container my-5">
      <div id="dish-list" class="row">

      </div>
   </div>

   <div class="box-container col-4 pb-4 d-none" id="display-template">

      <?php
         /*$select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){*/
      ?>
      <form action="" method="post" class="box">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         
         <div class="img-dish-cover"><img class="card-img-top" id="card-img1" src="" /></div>
         <a href="" class="cat card-text"></a>
         <div class="name card-title"></div>
         <div class="flex">
            <div class="price card-subtitle"><span>$</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
         /*   }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }*/
      ?>
   </div>

   <!--<div class="col-4 pb-4 d-none">
      <div class="card">
         <div class="img-dish-cover"></div>
         <div class="card-body">
               <h3 class="card-title"></h3>
               <h6 class="card-subtitle mb-2 text-muted"></h6>
               <p class="card-text"></p>
               <button class="btn btn-primary">View Details</button>
         </div>
      </div>
   </div>-->
   <!-- //////////////////////////////////////////////////////////////////////////// -->
   <div class="more-btn">
      <a href="menu.php" class="btn">veiw all</a>
   </div>

</section>






<section class="rooms">

   <h1 class="title">Rooms & Suite</h1>

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

   <div class="more-btn">
      <a href="roomsec.php" class="btn">Veiw all</a>
   </div>

</section>





<!-- gallery section -->
<section class="gal">

   <h1 class="title">Gallery</h1>

   <div class="box-container">

      <?php
       // $page = $_GET["page"];
       if (!isset($_GET['page'])  || $_GET['page'] == "1") 
       {
         $_GET['page'] = 0;

       }else
       {
         $_GET['page'] = ($_GET['page']*6)-6;
       }
         $select_gallery = $conn->prepare("SELECT * FROM `gallery` LIMIT 6");
         $select_gallery->execute();
         if($select_gallery->rowCount() > 0){
            while($fetch_gallery = $select_gallery->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
            <input type="hidden" name="rid" value="<?= $fetch_gallery['id']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_gallery['image']; ?>">
            <img src="gallery_upload/<?= $fetch_gallery['image']; ?>" alt="">
      </form>
      
      <?php
            }
         }else{
            echo '<p class="empty">No Picture added yet!</p>';
         }
      ?>
   </div>
         <div class="more-btn">
         <center><a href="gallerysec.php" class="btn">Veiw all</a></center>
         </div>
</section>

 
<!-- gallery section end -->


<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/vid.js"></script>

<script src="js/script.js"></script>


</body>
</html>

<div class="loader">
   <img src="images/loader.gif" alt="">
</div>
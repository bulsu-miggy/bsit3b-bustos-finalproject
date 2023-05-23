<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_picture'])){

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../gallery_upload/'.$image;

 
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_gallery = $conn->prepare("INSERT INTO `gallery`(image) VALUES(?)");
         $insert_gallery->execute([$image]);

         $message[] = 'New picture added!';
      }
   
   }


if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_gallery_image = $conn->prepare("SELECT * FROM `gallery` WHERE id = ?");
   $delete_gallery_image->execute([$delete_id]);
   $fetch_delete_image = $delete_gallery_image->fetch(PDO::FETCH_ASSOC);
   unlink('../gallery_upload/'.$fetch_delete_image['image']);
   $delete_gallery = $conn->prepare("DELETE FROM `gallery` WHERE id = ?");
   $delete_gallery->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:gallery.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>El Hotel • Gallery</title>
   <!-- for web icon-->
   <link rel = "icon" href = "../images/admin.png" type = "image/jpg">
   

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->
   <video autoplay muted loop id="myVideo">
        <source src="../images/vid-1.mp4" type="video/mp4">
   </video>
<section class="add-products">
   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Gallery</h3>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="Add picture" name="add_picture" class="btn">
   </form>
</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
   
      $show_gallery = $conn->prepare("SELECT * FROM `gallery`");
      $show_gallery->execute();
      if($show_gallery->rowCount() > 0){
         while($fetch_gallery = $show_gallery->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../gallery_upload/<?= $fetch_gallery['image']; ?>" alt="">
      <div class="flex-btn">
         
         <center><a href="gallery.php?delete=<?= $fetch_gallery['id']; ?>" class="delete-btn" onclick="return confirm('Delete this room?');">Delete</a></center>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No Picture added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
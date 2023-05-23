<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_rooms'])){

   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../room_upload/'.$image;

   $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE description = ?");
   $select_rooms->execute([$description]);

   if($select_rooms->rowCount() > 0){
      $message[] = 'room name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_rooms = $conn->prepare("INSERT INTO `rooms`(description, category, price, image) VALUES(?,?,?,?)");
         $insert_rooms->execute([$description, $category, $price, $image]);

         $message[] = 'new rooms added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_rooms_image = $conn->prepare("SELECT * FROM `rooms` WHERE id = ?");
   $delete_rooms_image->execute([$delete_id]);
   $fetch_delete_image = $delete_rooms_image->fetch(PDO::FETCH_ASSOC);
   unlink('../room_upload/'.$fetch_delete_image['image']);
   $delete_rooms = $conn->prepare("DELETE FROM `rooms` WHERE id = ?");
   $delete_rooms->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:rooms.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>El Hotel • Rooms</title>
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
      <h3>Add rooms</h3>
      <input type="text" required placeholder="Enter room description" name="description" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="Enter room price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>Select category --</option>
         <option value="Executive Suite">Executive Suite</option>
         <option value="Premiere Suite">Premiere Suite</option>
         <option value="El Hotel Suite">El Hotel Suite</option>
         <option value="Single Bed">Single Bed</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="Add rooms" name="add_rooms" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_rooms = $conn->prepare("SELECT * FROM `rooms`");
      $show_rooms->execute();
      if($show_rooms->rowCount() > 0){
         while($fetch_rooms = $show_rooms->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../room_upload/<?= $fetch_rooms['image']; ?>" alt="">
      <div class="flex">
         <div class="price"><span>₱</span><?= $fetch_rooms['price']; ?><span></span></div>
         <div class="category"><?= $fetch_rooms['category']; ?></div>
        
      </div>
      <div class="name"><?= $fetch_rooms['description']; ?></div>
      <div class="flex-btn">
         <a href="update_rooms.php?update=<?= $fetch_rooms['id']; ?>" class="option-btn">Update</a>
         <a href="rooms.php?delete=<?= $fetch_rooms['id']; ?>" class="delete-btn" onclick="return confirm('Delete this room?');">Delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No rooms added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
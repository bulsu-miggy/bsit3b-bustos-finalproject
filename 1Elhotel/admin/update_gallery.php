<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $gid = $_POST['gid'];
   $gid = filter_var($gid, FILTER_SANITIZE_STRING);
   // $description = $_POST['description'];
   // $description = filter_var($description, FILTER_SANITIZE_STRING);
   // $price = $_POST['price'];
   // $price = filter_var($price, FILTER_SANITIZE_STRING);
   // $category = $_POST['category'];
   // $category = filter_var($category, FILTER_SANITIZE_STRING);

   $update_rooms = $conn->prepare("UPDATE `rooms` SET description = ?, category = ?, price = ? WHERE id = ?");
   $update_rooms->execute([$description, $category, $price, $rid]);

   $message[] = 'gallery updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../room_upload/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'images size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `rooms` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $rid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../room_upload/'.$old_image);
         $message[] = 'image updated!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>El Hotel • Update Rooms</title>
   <!-- for web icon-->
   <link rel = "icon" href = "../images/admin.png" type = "image/jpg">
   

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts  -->
<video autoplay muted loop id="myVideo">
        <source src="../images/vid-1.mp4" type="video/mp4">
   </video>

<section class="update-product">

   <h1 class="heading">Update Rooms</h1>

   <?php
      $update_id = $_GET['update'];
      $show_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE id = ?");
      $show_rooms->execute([$update_id]);
      if($show_rooms->rowCount() > 0){
         while($fetch_rooms = $show_rooms->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="rid" value="<?= $fetch_rooms['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_rooms['image']; ?>">
      <img src="../room_upload/<?= $fetch_rooms['image']; ?>" alt="">
      <span>Update description</span>
      <input type="text" required placeholder="enter room description" name="description" maxlength="100" class="box" value="<?= $fetch_rooms['description']; ?>">
      <span>Update price</span>
      <input type="number" min="0" max="9999999999" required placeholder="Enter room price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_rooms['price']; ?>">
      <span>Update category</span>
      <select name="category" class="box" required>
         <option selected value="<?= $fetch_rooms['category']; ?>"><?= $fetch_rooms['category']; ?></option>
         <option value="Executive Suite">Executive Suite</option>
         <option value="Premiere Suite">Premiere Suite</option>
         <option value="El Hotel Suite">El Hotel Suite</option>
         <option value="Single Bed">Single Bed</option>
      </select>
      <span>Update image</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="rooms.php" class="option-btn">Go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">No room added yet!</p>';
      }
   ?>

</section>

<!-- update product section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
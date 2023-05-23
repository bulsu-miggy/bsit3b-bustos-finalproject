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
   <title>El Hotel • Gallery Section</title>
   <!-- for web icon-->
   <link rel = "icon" href = "images/elhotel.png" type = "image/jpg">

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
   <h3>Our Gallery</h3>
   <p><a href="home.php">Home</a> <span> / Gallery</span></p>
</div>

<!-- menu section starts  -->

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
         $select_gallery = $conn->prepare("SELECT * FROM `gallery` LIMIT $_GET[page],6");
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

</section>
<?php
					//PAGINATION
                  
						try {
                  $total = $conn->query('SELECT COUNT(*) FROM gallery')->fetchColumn();
                  
						$limit = 3;
						// GET LAST PAGE NUMBER
						$pages = ceil($total / $limit);
						
						$second_last = $total - 1; // total pages minus 1
						
						// GET FIRST PAGE
						$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' => array('default'   => 1,'min_range' => 1,),)));
						
						$lastpicindex = ($page - 1)  * $limit;

						$start = $lastpicindex + 1;
						$end = min(($lastpicindex + $limit), $total);		
			
						$stmt = $conn->prepare('SELECT	* FROM gallery LIMIT :limit OFFSET :lastpicindex');
						$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
						$stmt->bindParam(':lastpicindex', $lastpicindex, PDO::PARAM_INT);
						$stmt->execute();
						
						//IF ALREADY HAVE PRODUCTS
						if ($stmt->rowCount() > 0) {
							$stmt->setFetchMode(PDO::FETCH_ASSOC);
							$iterator = new IteratorIterator($stmt);

							// DISPLAY
							foreach ($iterator as $row) {
								
								
								// LAMAN NG HTML GALLERY MO
                        $image = (!empty($row['image'])) ? 'images/rooms/'.$row['image'] : 'images/noimage.jpg';
								echo 
                        "
                        
                        
                       
								";
							}

						} else {
							echo '<p>No results could be displayed.</p>';
						}
												
						// BACK BUTTON
						$prevlink = ($page - 1);

						// NEXT BUTTON
						$nextlink = ($page + 1);

					} catch (Exception $e) {
						echo '<p>', $e->getMessage(), '</p>';
					}
								
					?>
               <style>
						.pagination {
							display: inline-block;
							border-radius: 4px;	
							font-family:Microsoft Yi Baiti;
						}
						ol, ul {			
							margin-bottom: 10px;
						}
						.pagination>li {
						display: inline;
						color:#00A8F3;
						}

						.pagination>li>a:hover {
							background-color:#00A8F3;
							color:white;
						}
						
						.pagination>li:first-child>a, .pagination>li:first-child>span {
							margin-left: 0;
							border-top-left-radius: 4px;
							border-bottom-left-radius: 4px;
						}
						
						.pagination>li:last-child>a, .pagination>li:last-child>span {
							margin-left: 0;
							border-top-right-radius: 4px;
							border-bottom-right-radius: 4px;
						}
						
						.pagination>li>a, .pagination>li>span {
							position: relative;
							float: left;
							padding: 6px 12px;
							margin-left: -1px;
							line-height: 1.42857143;
							color: #337ab7;
							text-decoration: none;
							background-color: #fff;
							border: 1px solid #ddd;
						}
						a {
							color: #337ab7;
							text-decoration: none;
						}
						a {
							background-color: transparent;
						}
						</style>	
<center><div style="
   margin: auto;
	position:relative;
	top:-100px;
	margin-left:-55px;">
					<div style='display: table; margin: 0 auto;padding-left:50px;padding-bottom:10px;font-family:Microsoft Yi Baiti'>
					<strong>Page <?php echo $page." of ".$pages; ?></strong>	
					</div>
						<ul class="pagination" style="display: table;margin: 0 auto;">
						<?php if($page > 1){
						echo "<li><a href='?page=1'>First Page</a></li>";
						} ?>
							
						<li <?php if($page <= 1){ echo "class='disabled'"; } ?>>
						<a <?php if($page > 1){ echo "href='?page=$prevlink'";} ?>>Previous</a>
						</li>
						
						<?php
						
						if ($pages <= 10){  	 
							for ($counter = 1; $counter <= $pages; $counter++){
							if ($counter == $page) {
							echo "<li class='active'><a>$counter</a></li>";	
							}
							else{
								echo "<li><a href='?page=$counter'>$counter</a></li>";
							}
							}
						}
							elseif ($pages > 10){
								if($page <= 4) {			
						 for ($counter = 1; $counter < 8; $counter++){		 
							if ($counter == $page) {
							   echo "<li class='active'><a>$counter</a></li>";	
								}else{
								   echo "<li><a href='?page=$counter'>$counter</a></li>";
										}
						}
						echo "<li><a>...</a></li>";
						echo "<li><a href='?page=$second_last'>$second_last</a></li>";
						echo "<li><a href='?page=$pages'>$pages</a></li>";
						}
							}
							elseif($page > 4 && $page < $pages - 4) {		 
						echo "<li><a href='?page=1'>1</a></li>";
						echo "<li><a href='?page=2'>2</a></li>";
						echo "<li><a>...</a></li>";
						for (
							 $counter = $page - $adjacents;
							 $counter <= $page + $adjacents;
							 $counter++
							 ) {		
							 if ($counter == $page) {
							echo "<li class='active'><a>$counter</a></li>";	
							}else{
								echo "<li><a href='?page=$counter'>$counter</a></li>";
								  }                  
							   }
						echo "<li><a>...</a></li>";
						echo "<li><a href='?page=$second_last'>$second_last</a></li>";
						echo "<li><a href='?page=$pages'>$pages</a></li>";
						}						
						?>
							
						<li <?php if($page >= $pages){
						echo "class='disabled'";
						} ?>>
						
						<a <?php if($page < $pages) {
						echo "href='?page=$nextlink'";
						} ?>>Next</a>
						</li>

						<?php if($page < $pages){	
						echo "<li><a href='?page=$pages'>Last</a></li>";
						} 
						
						// $pdo->close();
						
						?>
						</ul>
</div></center>

<!-- menu section ends -->
























<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
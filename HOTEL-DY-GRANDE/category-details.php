<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Hotel Dy Grande | Hotel :: Single Rooms</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="css/lightbox.css">

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

</head>
<body>
		<!--header-->
			<div class="header head-top">
				<div class="container">
				<?php include_once('includes/header.php');?>
		</div>
</div>
<!--header-->
		<!--rooms-->
			<content class="content">
					<div class="room-section">
						<div class="container">
						<h2>Rooms Details</h2></br></br>
							<hotels class="room-grids">
								<?php
								$cid=intval($_GET['catid']);
$sql="SELECT tblroom.*,tblroom.id as rmid , tblcategory.Price,tblcategory.ID,tblcategory.CategoryName from tblroom 
join tblcategory on tblroom.RoomType=tblcategory.ID 
where tblroom.RoomType=:cid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':cid', $cid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{						
foreach($results as $row)
{               ?>													<hotel>
								<sampleImage class="col-md-5 room-grid" style="padding-bottom: 50px">
								
									<imageSize href="#" class="mask">

										<img src="admin/images/<?php echo $row->Image;?>" class=" mask img-responsive zoom-img" alt=""> </img>
									</imageSize>

								</sampleImage>
								<hotelInfo class="col-md-7 room-grid1">
									<h4> <?php  echo htmlentities($row->FacilityTitle);?> </h4></br>
									<shortDescription><?php  echo htmlentities($row->RoomDesc);?></shortDescription></br></br>
									<adult>Max Adult:<?php  echo htmlentities($row->MaxAdult);?></adult></br></br>
									<child>Max Child:<?php  echo htmlentities($row->MaxChild);?></child></br></br>
									<bedCount>No of Beds:<?php  echo htmlentities($row->NoofBed);?></bedCount></br></br>
									<facility>Room Facilities:<?php  echo htmlentities($row->RoomFacility);?></facility></br></br>
									<price>Price: <?php  echo htmlentities($row->Price);?></price></br></br>
									<button class="btn btn-success"><a href="book-room.php?rmid=<?php echo $row->rmid;?>">Book</a></button>
								</hotelInfo>
								<div class="clearfix"></div>							</hotel><?php $cnt=$cnt+1;}} ?>
						<div class="clearfix"></div>
						</hotels>
					</div>
				</div>
				<!--rooms-->
				<?php include_once('includes/getintouch.php');?>
			</content>
			<!--footer-->
				<?php include_once('includes/footer.php');?>
</body>
</html>

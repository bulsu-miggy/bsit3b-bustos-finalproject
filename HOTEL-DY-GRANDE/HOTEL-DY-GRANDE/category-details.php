<style>
.Rooms
{
	text-align:center;
	color: black;
	font-family: Rancho-Regular;
	font-size:70px;
}

.ID
{

	text-align:justify;
	color: black;
	font-family: sans-serif;
	
}

.text-center
{
	font-size:30px;
	text-align:center;
	margin: 60px 0;
}
</style>

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
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">-->

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
	<div class="Rooms"> Rooms Details </div><br>
		<!--Rooms-->
			<div class="row">

		<?php
				$xmlFile = 'xmlfiles/rooms.xml';

				// Check if the XML file exists
				if (file_exists($xmlFile)) {
					// Load the XML file
					$xml = simplexml_load_file($xmlFile);

					// Display the XML data
					
					foreach ($xml->room as $room) 
					{
						$ID = (string) $room->ID;
						$RoomType = (string) $room->RoomType;
						$RoomName = (string) $room->RoomName;
						$MaxAdult = (string) $room->MaxAdult;
						$MaxChild = (string) $room->MaxChild;
						$RoomDesc = (string) $room->RoomDesc;
						$NoofBed = (string) $room->NoofBed;
						$Image = (string) $room->Image;
						$RoomFacility = (string) $room->RoomFacility;

						?>
				
						<div class="col-lg-12 room">
							<div class="row">
								<div class="col-lg-4">
									<div class="room-img">
										<img src="/HOTEL-DY-GRANDE/HOTEL-DY-GRANDE/admin/images/<?php echo $room->Image ?>" style="margin: 0 auto; width: 500px; height: 300px;">
									</div>
								</div>

								<div class="col-lg-8">
									<div class="room-details">
										<div class = 'ID'><?php echo 'ID: '.$ID ?></div>
										<div class = 'ID'><?php echo 'RoomType: '.$RoomType ?></div>
										<div class = 'ID'><?php echo 'RoomName: '.$RoomName ?></div>
										<div class = 'ID'><?php echo 'MaxAdult: '.$MaxAdult ?></div>
										<div class = 'ID'><?php echo 'MaxChild: '.$MaxChild ?></div>
										<div class = 'ID'><?php echo 'RoomDesc: '.$RoomDesc ?></div>
										<div class = 'ID'><?php echo 'NoofBed: '.$NoofBed ?></div>
										<div class = 'ID'><?php echo 'RoomFacility: '.$RoomFacility ?></div>
										<button class="btn btn-success"><a href="<?php echo 'book-room.php?rmid='.$row->rmid;?>">Book</a></button>
									</div>
								</div>
							</div>
						</div>

						
					<?php

							
						
					}

					}

				else {
						echo "<div class='text-center my-5'><h1>XML file not found.</h1></div>";
					}
		?>

		</div>
		<!--Rooms-->

				<?php include_once('includes/getintouch.php');?>

			</content>

			<!--footer-->

				<?php include_once('includes/footer.php');?>

</body>

</html>


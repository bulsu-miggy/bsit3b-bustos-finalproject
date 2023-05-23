<?php
 $con = mysqli_connect("localhost", "root");

 mysqli_select_db($con,"food_db");

if(isset($_POST['submit'])){

    $name = $_POST['name'];
     $email = $_POST['email'];
     $guest = $_POST['number'];
     $in = $_POST['in'];
     $out = $_POST['out'];


$query = "INSERT INTO reservation (fullname, email, guest,checkin, checkout)
 VALUES ('$name', '$email', '$guest', '$in', '$out')";

if (mysqli_query($con, $query)) {
    echo "Data inserted successfully";
} else {
    echo "Error inserting data: " . mysqli_error($con);
}

mysqli_close($con);
}
    
?>


 <html>

 <head></head>
 <body>


 <div class="heading">
        <h5>RESERVATION FORM</h5>
        <h2>El Hotel</h2>
    </div>

    <div class="row">

        <form action="">
        <div class="inputBox">
                <h3>Full Name</h3>
                <input type="text" placeholder="Full Name">
            </div>
            <div class="inputBox">
                <h3>Email</h3>
                <input type="email" placeholder="Email">
            </div>
            <div class="inputBox">
                <h3>How many</h3>
                <input type="number" placeholder="Number of guests">
            </div>
            <div class="inputBox">
                <h3>Check-in</h3>
                <input type="Date">
            </div>
            <div class="inputBox">
                <h3>Check-out</h3>
                <input type="Date">
            </div>
            <input type="submit" class="btn" value="Book Now">
        </form>

    </div>

</section>

 </body>

 </html>


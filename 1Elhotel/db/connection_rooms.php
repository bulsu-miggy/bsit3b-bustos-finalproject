<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname= "rooms_db";

// // Create connection
// $conn = new mysqli($servername, $username, $password);

// // // Check connection
// // if ($conn->connect_error) {
// //   die("Connection failed: " . $conn->connect_error);
// // }

// // Check connection
// if (mysqli_connect_error()) {
//     die("Database connection failed: " . mysqli_connect_error());
//   }

// echo "Connected successfully";

try {
    $conn = new PDO("mysql:host=$servername;port=3307", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    // use exec() because no results are returned
    try {
        $conn->exec($sql);
    } catch (PDOException $th) {
        //echo "<br> Database Already Exists";
    }

    $sql = "use $dbname";
    $conn->exec($sql);
    //sql to create table
    $query = "CREATE TABLE IF NOT EXISTS rooms (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        category VARCHAR(100),
        room_description VARCHAR(500) NOT NULL,
        price VARCHAR(50),
        media TEXT,
        media_type VARCHAR(100),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    
    try {
        $conn->exec($query);
        echo "DB Created Successfully.";


        $data = [
            ['Excecutive Suite','Experience the pinnacle of luxury and comfort in our executive room, where elegance meets modern amenities to create a truly exceptional stay.','50000.00','executive.jpg','image'],
            ['Premiere Suite','Indulge in the epitome of luxury and sophistication in our premiere room, where lavish furnishings and exquisite design combine to offer an unforgettable experience.','39000.99','premiere.jpg','image'],
            ['El Hotel Suite','Escape to El Hotel and discover a world of elegance and refinement, where impeccable service, stunning decor, and luxurious amenities come together to create an unforgettable stay.','29000.99','el_hotel.jpg','image'],
            ['Single Bed','Relax and unwind in our cozy single bed room, featuring a comfortable bed, soothing ambiance, and all the essentials for a peaceful nights rest.','19000.99','single.jpg','image'],
        ];

        $query_i = $conn->prepare("INSERT INTO rooms (
            category,
            room_description,
            price,
            media,
            media_type
        ) VALUES (?,?,?,?,?)");

        try {
            $conn->beginTransaction();
            foreach ($data as $row)
            {
                $query_i->execute($row);
            }
            $conn->commit();
            echo "New record created successfully";
        }catch (Exception $e){
            $conn->rollback();
            throw $e;
        }
        
        $conn = null;
        exit();
    } catch (PDOException $th) {
        echo "Error in creating Table";
        echo $th;
        $conn = null;
        exit();
    }

    

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

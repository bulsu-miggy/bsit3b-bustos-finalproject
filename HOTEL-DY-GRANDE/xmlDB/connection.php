<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname= "hoteldygrande_db";

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
    $conn = new PDO("mysql:host=$servername", $username, $password);
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
    $query = "CREATE TABLE IF NOT EXISTS tblroom (
	ID int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  	RoomType int(10) DEFAULT NULL,
  	RoomName varchar(200) DEFAULT NULL,
 	MaxAdult int(5) DEFAULT NULL,
 	MaxChild int(5) DEFAULT NULL,
 	RoomDesc mediumtext DEFAULT NULL,
 	NoofBed int(5) DEFAULT NULL,
  	Image varchar(200) DEFAULT NULL,
  	RoomFacility varchar(200) DEFAULT NULL,
        Price varchar(200) DEFAULT NULL,
  	CreationDate timestamp NULL DEFAULT current_timestamp()
        )";
    
    try {
        $conn->exec($query);
        echo "\nTable tblroom Created Successfully.";


        $data = [
        [1, 'Single Room for one person', 1, 2, 'A single room is for one person and contains a single bed, and will usually be quite small', 1, '2870b3543f2550c16a4551f03a0b84ac1582975994.jpg', '24-Hour room service,Free wireless internet acces', 'P1000.00', '2020-02-29 11:33:14'],
		[2, 'Double Room', 2, 2, 'A double room is a room intended for two people, usually a couple, to stay in. One person occupying a double room has to pay a supplement.', 2, '74375080377499ab76dad37484ee7f151582982180.jpg', '24-Hour room service,Free wireless internet acces', 'P2000.00', '2020-02-29 11:35:47'],
		[3, 'triple room', 4, 2, 'A triple room is a hotel room that is made to comfortably accommodate three people. The triple room , simply called a triple, at times, may be configured with different bed sizes to ensure three hotel guests can be accommodated comfortably.', 3, '5ebc75f329d3b6f84d44c2c2e9764d4f1582976638.jpg', '24-Hour room service,Free wireless internet access,Laundry service,Babysitting on request,24-Hour doctor on call,Meeting facilities', 'P3000.00', '2020-02-29 11:43:58'],
		[4, 'Quad Room', 6, 3, 'A quad, when referring to hotel rooms, is a room that can accommodate four people. The quad room may be configured with different bed sizes to ensure four hotel guests can be accommodated comfortably:', 4, '0cdcf50ea65522a6e15d4e0ac383a30e1582976749.jpg', '24-Hour room service,Free wireless internet access,Laundry service,Tour & excursions,Airport transfers,Babysitting on request,24-Hour doctor on call,Meeting facilities', 'P4000.00', '2020-02-29 11:45:49'],
		[5, 'Queen Room', 2, 1, 'A room with a queen-size bed. It may be occupied by one or more people (Size: 153 x 203 cm). King:', 1, '7edd3d2f392c4a07d107f07cbe764fa51582977081.jpg', '24-Hour room service,Free wireless internet access,Laundry service,Tour & excursions,Airport transfers,Babysitting on request,24-Hour doctor on call,Meeting facilities', 'P5000.00', '2020-02-29 11:51:21'],
		[1, 'Single Room with Balcony', 1, 2, 'Each room is equipped with satellite TV, minibar and a tea/coffee maker. Ironing facilities are provided in all rooms.\r\n\r\nTreebo Select Royal Garden offers a well-equipped business centre. Guests can make travel arrangements at the tour desk.\r\n\r\nCheckers Restaurant serves a variety of Indian, Chinese and Continental dishes.', 1, 'ca3de1cf40a0af9351083d4b0e95736c1583047692.jpg', '24-Hour doctor on call', 'P6000.00', '2020-03-01 07:28:12']
		];

        $query_i = $conn->prepare("INSERT INTO tblroom (
            RoomType,
	    RoomName,
	    MaxAdult,
	    MaxChild,
	    RoomDesc,
            NoofBed,
  	    Image,
            RoomFacility,
	    Price,
            CreationDate
        ) VALUES (?,?,?,?,?,?,?,?,?,?)");

        try {
            $conn->beginTransaction();
            foreach ($data as $row)
            {
                $query_i->execute($row);
            }
            $conn->commit();
            echo " New record created successfully into the table tblroom";
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
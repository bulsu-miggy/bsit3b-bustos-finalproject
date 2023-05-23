<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname= "dishes_db";

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
    $query = "CREATE TABLE IF NOT EXISTS dishes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dish_name VARCHAR(100) NOT NULL,
        category VARCHAR(100),
        price VARCHAR(50),
        media TEXT,
        media_type VARCHAR(100),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    
    try {
        $conn->exec($query);
        echo "DB Created Successfully.";


        $data = [
            ['Stake','Main dish','30.00','stake.png','image'],
            ['Pizza','Fast food','29.99','pizza.png','image'],
            ['Juice','Drinks','29.99','drink.png','image'],
            ['Ice Cream','Deserts','30.00','dessert.png','image'],
            ['Spaghetti','','35.99','dish-1.png','image']
        ];

        $query_i = $conn->prepare("INSERT INTO dishes (
            dish_name,
            category,
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

<?php //require "connection.php"; ?>

<?php

/** create XML file */ 
$mysqli = new mysqli("127.0.0.1:3307", "root", "", "dishes_db");
/* check connection */
if ($mysqli->connect_errno) {
   echo "Connect failed ".$mysqli->connect_error;
   exit();
}

$query = "SELECT id,dish_name,category,price,media,media_type FROM dishes";
$dishesArray = array();
if ($result = $mysqli->query($query)) {
    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
       array_push($dishesArray, $row);
    }
  
    if(count($dishesArray)){
         createXMLfile($dishesArray);
     }
    /* free result set */
    $result->free();
}
/* close connection */
$mysqli->close();

function createXMLfile($dishesArray){
  
   $filePath = '../xmlfiles/dish.xml';
   
   if(!file_exists($filePath)){
      $dom     = new DOMDocument('1.0', 'utf-8');

      $dtd = new DOMImplementation();

      $dom->appendChild($dtd->createDocumentType('dishes', '', 'hotel_dish.dtd'));
      
      $root      = $dom->createElement('dishes'); 
      for($i=0; $i<count($dishesArray); $i++){
      
      $dishId                =  $dishesArray[$i]['id'];  
      $dishName              =  htmlspecialchars($dishesArray[$i]['dish_name']);
      $dishPrice             =  $dishesArray[$i]['price']; 
      $dishCategory          =  $dishesArray[$i]['category'];
      $dishMedia             =  $dishesArray[$i]['media'];
      $dishMediaType         =  $dishesArray[$i]['media_type'];
      
      //Start XML Generation
      $dish      = $dom->createElement('dish');
      $dish->setAttribute('category', $dishCategory);

      $id        = $dom->createElement('dishId', $dishId); 
      $dish->appendChild($id);

      $name      = $dom->createElement('dish_name', $dishName); 
      $dish->appendChild($name);

      $price     = $dom->createElement('price', $dishPrice); 
      $dish->appendChild($price);
      
      $media = $dom->createElement('media', $dishMedia); 
      $dish->appendChild($media);
      $media->setAttribute('type', $dishMediaType);
   
      $root->appendChild($dish);
      }

      $dom->appendChild($root); 
      $dom->save($filePath);

      echo "XML created Successfully!\n";
   } else {
      echo "XML file already exists!<br>";
   }
   
   validateXML($filePath);

 }

 /**
  * DTD Checker
  */
 function validateXML($xml){

   try{
      if(file_exists($xml)){
         $dom = new DOMDocument;
         $dom->load($xml);
         if ($dom->validate()) {
            echo "This document is valid!\n";
         } else {
            echo "This file is not valid. Check your DTD!";
         }
      } else {
         echo "Oops File not exists";
      }
   } catch(Exception $e){
      echo "Some Error in process occured". $e->getMessage();
   }

 }

 ?>
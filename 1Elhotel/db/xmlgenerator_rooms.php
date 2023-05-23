<?php //require "connection.php"; ?>

<?php

/** create XML file */ 
$mysqli = new mysqli("127.0.0.1:3307", "root", "", "rooms_db");
/* check connection */
if ($mysqli->connect_errno) {
   echo "Connect failed ".$mysqli->connect_error;
   exit();
}

$query = "SELECT id,category,room_description,price,media,media_type FROM rooms";
$roomsArray = array();
if ($result = $mysqli->query($query)) {
    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
       array_push($roomsArray, $row);
    }
  
    if(count($roomsArray)){
         createXMLfile($roomsArray);
     }
    /* free result set */
    $result->free();
}
/* close connection */
$mysqli->close();

function createXMLfile($roomsArray){
  
   $filePath = '../xmlfiles/room.xml';
   
   if(!file_exists($filePath)){
      $dom     = new DOMDocument('1.0', 'utf-8');

      $dtd = new DOMImplementation();

      $dom->appendChild($dtd->createDocumentType('rooms', '', 'hotel_room.dtd'));
      
      $root      = $dom->createElement('rooms'); 
      for($i=0; $i<count($roomsArray); $i++){
      
      $roomId                =  $roomsArray[$i]['id'];  
      $roomDescription       =  htmlspecialchars($roomsArray[$i]['room_description']);
      $roomPrice             =  $roomsArray[$i]['price']; 
      $roomCategory          =  $roomsArray[$i]['category'];
      $roomMedia             =  $roomsArray[$i]['media'];
      $roomMediaType         =  $roomsArray[$i]['media_type'];
      
      //Start XML Generation
      $room      = $dom->createElement('room');
      $room->setAttribute('category', $roomCategory);

      $id        = $dom->createElement('roomId', $roomId); 
      $room->appendChild($id);

      $name      = $dom->createElement('room_description', $roomDescription); 
      $room->appendChild($name);

      $price     = $dom->createElement('price', $roomPrice); 
      $room->appendChild($price);
      
      $media = $dom->createElement('media', $roomMedia); 
      $room->appendChild($media);
      $media->setAttribute('type', $roomMediaType);
   
      $root->appendChild($room);
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
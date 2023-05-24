<?php //require "connection.php"; ?>

<?php


$mysqli = new mysqli("localhost", "root", "", "hoteldygrande_db");

if ($mysqli->connect_errno) {
   echo "Connect failed ".$mysqli->connect_error;
   exit();
}


$query = "SELECT ID, RoomType, RoomName, MaxAdult, MaxChild, RoomDesc, NoofBed, Image, RoomFacility FROM tblroom";
$roomsArray = array();
if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
       array_push($roomsArray, $row);
    }
  
    if(count($roomsArray)){
         createXMLfile($roomsArray);
     }

    $result->free();
}

$mysqli->close();

function createXMLfile($roomsArray){
  
   $filePath = '../xmlfiles/rooms.xml';
   
   if(!file_exists($filePath)){
      $dom     = new DOMDocument('1.0', 'utf-8');

      $dtd = new DOMImplementation();

      $dom->appendChild($dtd->createDocumentType('rooms', '', 'AllRooms.dtd'));
      
      $root      = $dom->createElement('rooms'); 
      for($i=0; $i<count($roomsArray); $i++){
      
      $ID                =  $roomsArray[$i]['ID'];  
      $RoomType          =  htmlspecialchars($roomsArray[$i]['RoomType']);
      $RoomName          =  $roomsArray[$i]['RoomName']; 
      $MaxAdult          =  $roomsArray[$i]['MaxAdult']; 
      $MaxChild          =  $roomsArray[$i]['MaxChild']; 
      $RoomDesc          =  $roomsArray[$i]['RoomDesc'];
      $NoofBed           =  $roomsArray[$i]['NoofBed'];
      $Image             =  $roomsArray[$i]['Image'];
      $RoomFacility	 =  htmlspecialchars($roomsArray[$i]['RoomFacility']);
      
      //Start XML Generation
      $room      = $dom->createElement('room');

      $ID        = $dom->createElement('ID', $ID); 
      $room->appendChild($ID);

      $RoomType      = $dom->createElement('RoomType', $RoomType); 
      $room->appendChild($RoomType);

      $RoomName    = $dom->createElement('RoomName', $RoomName); 
      $room->appendChild($RoomName);

      $MaxAdult      = $dom->createElement('MaxAdult', $MaxAdult); 
      $room->appendChild($MaxAdult);

      $MaxChild     = $dom->createElement('MaxChild', $MaxChild); 
      $room->appendChild($MaxChild);
      
      $RoomDesc = $dom->createElement('RoomDesc', $RoomDesc); 
      $room->appendChild($RoomDesc);

      $NoofBed = $dom->createElement('NoofBed', $NoofBed); 
      $room->appendChild($NoofBed);

      $Image = $dom->createElement('Image', $Image); 
      $room->appendChild($Image);

      $RoomFacility = $dom->createElement('RoomFacility', $RoomFacility); 
      $room->appendChild($RoomFacility);
   
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
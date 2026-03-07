<?php
ob_start(); //Turns on output buffering
session_start();

date_default_timezone_set("America/Santo_Domingo");

try{
    $con = new PDO("mysql:dbname=YOUR_DB_NAME;host=YOUR_DB_HOST", "YOUR_DB_USER","YOUR_DB_PASSWORD");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}catch(PDOException $e){
    exit("Connection failed: " . $e->getMessage());
}
?>
<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "limeanteri";

$link = mysqli_connect($servername,$dBUsername,$dBPassword,$dBName);

if(!$link) {
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());       
    }
}
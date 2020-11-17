<?php

$dBName = "limeanteri";

include('../../tunnukset.php');

$local = in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','REMOTE_ADDR' => '::1'));

if (!$local) {
  $password = $db_pwd_azure;
  $user = $db_username_azure;
  $server = "localhost:49492";
  }
else {
  $password = $db_pwd_local;
  $user = $db_username_local;
  $server = "localhost";	
  }


$link = mysqli_connect($server,$user,$password,$dBName);

if(!$link) {
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());       
    }
}

?>
<?php
include_once 'header.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';


if (isset($_GET["resepti"])) {
    $id = $_GET["resepti"];
    naytaResepti($link, $id);
}    


include_once 'footer.php';
?>
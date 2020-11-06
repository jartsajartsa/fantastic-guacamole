<?php

    if (isset($_POST["submit"])) {
      
        $kayttajanimi = $_POST["kayttajanimi"];        
        $pwd = $_POST["pwd"];
        

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if (emptyInputLogin($kayttajanimi, $pwd) !== false) {
            header("location: ../rekisteroidy.php?error=emptyinput");
            exit();
        }

        loginUser($link, $kayttajanimi, $pwd);    


    } else {
        header("location: ../kirjaudu.php");
    }
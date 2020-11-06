<?php

    if (isset($_POST["submit"])) {

        $etunimi = $_POST["etunimi"];
        $sukunimi = $_POST["sukunimi"];
        $kayttajanimi = $_POST["kayttajanimi"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $pwdRepeat = $_POST["pwdrepeat"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if (emptyInputSignup($etunimi, $sukunimi, $kayttajanimi, $email, $pwd, $pwdRepeat) !== false) {
            header("location: ../rekisteroidy.php?error=emptyinput");
            exit();
        }

        if (invalidKayttajanimi($kayttajanimi) !== false) {
            header("location: ../rekisteroidy.php?error=invalidusername");
            exit();
        }
    
        if (invalidEmail($email) !== false){
            header("location: ../rekisteroidy.php?error=invalidemail");
            exit();
        }
    
        if (pwdMatch($pwd, $pwdRepeat) !== false){
            header("location: ../rekisteroidy.php?error=passwordsdontmatch");
            exit();
        }
    
        if (emailExists($link, $kayttajanimi, $email) !== false){
            header("location: ../rekisteroidy.php?error=email/usernametaken");
            exit();
        }
        
        createUser($link, $etunimi, $sukunimi, $kayttajanimi, $email, $pwd);


    } else {
        header("location: ../rekisteroidy.php");
    }
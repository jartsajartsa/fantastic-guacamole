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

        if (emptyInputSignup($etunimi, $sukunimi, $kayttajanimi, $email, $passwd, $passwdRepeat) !== false) {
            header("location: ../signup.php?error=emptyinput");
            exit();
        }

        if (invalidKayttajanimi($kayttajanimi) !== false) {
            header("location: ../signup.php?error=emptyinput");
            exit();
        }
    
        if (invalidEmail($email) !== false){
            header("location: ../signup.php?error=invalidemail");
            exit();
        }
    
        if (pwdMatch($pwd, $pwdRepeat) !== false){
            header("location: ../signup.php?error=passwordsdontmatch");
            exit();
        }
    
        if (emailExists($link, $kayttajanimi, $email) !== false){
            header("location: ../signup.php?error=emailkaytossa");
            exit();
        }
        
        createUser($link, $etunimi, $sukunimi, $kayttajanimi, $email, $pwd);


    } else {
        header("location: ../rekisteroidy.php");
    }
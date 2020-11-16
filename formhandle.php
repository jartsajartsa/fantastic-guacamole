<?php
include_once 'header.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';
require_once 'includes/mailer.inc.php';

if (isset($_POST["submitkirjaudu"])) {
      
        $kayttajanimi = $_POST["kayttajanimi"];        
        $pwd = $_POST["pwd"];
        

       
        if (emptyInputLogin($kayttajanimi, $pwd) !== false) {
            header("location: rekisteroidy.php?error=emptyinput");
            exit();
        }

        loginUser($link, $kayttajanimi, $pwd);

}


if (isset($_POST["submitrekisteroidy"])) {

    $etunimi = $_POST["etunimi"];
    $sukunimi = $_POST["sukunimi"];
    $kayttajanimi = $_POST["kayttajanimi"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

   

    if (emptyInputSignup($etunimi, $sukunimi, $kayttajanimi, $email, $pwd, $pwdRepeat) !== false) {
        header("location: rekisteroidy.php?error=emptyinput");
        exit();
    }

    if (invalidKayttajanimi($kayttajanimi) !== false) {
        header("location: rekisteroidy.php?error=invalidusername");
        exit();
    }

    if (invalidEmail($email) !== false){
        header("location: rekisteroidy.php?error=invalidemail");
        exit();
    }

    if (pwdMatch($pwd, $pwdRepeat) !== false){
        header("location: rekisteroidy.php?error=passwordsdontmatch");
        exit();
    }

    if (emailOrUsernameExists($link, $kayttajanimi, $email) !== false){
        header("location: rekisteroidy.php?error=email/usernametaken");
        exit();
    }
    
    createUser($link, $etunimi, $sukunimi, $kayttajanimi, $email, $pwd);

}

if (isset($_POST["submitchangepwd"])) {

    $email = $_SESSION["email"];
    $oldPwd = $_POST["oldPwd"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    if (emptyInputLogin($oldPwd,$pwd,$pwdRepeat) !== false) {
        header("location: profiili.php?error=emptyinput");
        exit();
    }

    if (pwdMatch($pwd, $pwdRepeat) !== false){
        header("location: profiili.php?error=passwordsdontmatch");
        exit();

    }

    changePwd ($link, $email, $oldPwd, $pwd);
    header("location: profiili.php?error=success");

}

if (isset($_POST["submitresetpwd"])) {

    $email = $_POST["email"];

    if (emptyInputReset($email) !== false) {
        header("location: forgotpwd.php?error=emptyinput");
        exit();
    }    
    
    posti ($email, resetPwd ($link, $email), "Salasanan resetointi onnistui");
    header("location: kirjaudu.php?error=success");
}
    else {
        header("location: index.php");
        exit();    
    }


if (isset($_POST["submitlisaa"])) {

    $reseptinimi = $_POST["reseptinnimi"];
    $kategoria = $_POST["kategoria"];
    // $kuva = $_POST["kuva"];    
    $user = $_SESSION["id"];
    $ohje = $_POST["ohje"];
    $maara = $_POST["maara"];
    $yksikko = $_POST["yksikko"];
    $ainesosa = $_POST["ainesosa"];



    $last_id = lisaaResepti($link, $reseptinimi, $kategoria, $user, $ohje);    
    lisaaAinesosa($link, $last_id, $maara, $yksikko, $ainesosa);    
    // paivitaKuva($link, $last_id,lataaKuva($last_id, $kuva));
    
    header("location: lisaaresepti.php?success=1");
}

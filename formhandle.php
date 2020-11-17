<?php
include_once 'header.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';
// require_once 'includes/mailer.inc.php';

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

// if (isset($_POST["submitchangepwd"])) {

//     $email = $_SESSION["email"];
//     $oldPwd = $_POST["oldPwd"];
//     $pwd = $_POST["pwd"];
//     $pwdRepeat = $_POST["pwdrepeat"];

//     if (emptyInputLogin($oldPwd,$pwd,$pwdRepeat) !== false) {
//         header("location: profiili.php?error=emptyinput");
//         exit();
//     }

//     if (pwdMatch($pwd, $pwdRepeat) !== false){
//         header("location: profiili.php?error=passwordsdontmatch");
//         exit();

//     }

//     changePwd ($link, $email, $oldPwd, $pwd);
//     header("location: profiili.php?error=success");

// }

// if (isset($_POST["submitresetpwd"])) {

//     $email = $_POST["email"];

//     if (emptyInputReset($email) !== false) {
//         header("location: forgotpwd.php?error=emptyinput");
//         exit();
//     }    
    
//     posti($email, resetPwd ($link, $email), "Salasanan resetointi onnistui");
//     header("location: kirjaudu.php?error=success");
// }


if (isset($_POST["submitlisaa"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $uploadOk = 1;

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    }
    
    if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }
    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }

    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    }

    $reseptinimi = $_POST["reseptinnimi"];
    $kategoria = $_POST["kategoria"];    
    $user = $_SESSION["id"];
    $ohje = $_POST["ohje"];    
    $ainekset = $_POST["ainekset"];    

    // print_r($ainekset);
    $last_id = lisaaResepti($link, $reseptinimi, $kategoria, $user, $target_file, $ohje);
    
    // lisaaAinesosa($link, $last_id, $maara, $yksikko, $ainesosa);
    lisaaAinekset($link, $last_id, $ainekset);
        
    header("location: lisaaresepti.php?success=1");
}

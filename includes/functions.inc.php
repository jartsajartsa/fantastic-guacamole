<?php

function emptyInputSignup($etunimi, $sukunimi, $kayttajanimi, $email, $pwd, $pwdRepeat) {
    $result;
    if (empty($etunimi) || empty($sukunimi) || empty($kayttajanimi) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;    
}

function invalidKayttajanimi($kayttajanimi) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $kayttajanimi)) {
        $result = true;        

    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;    
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;    
}

function emailExists($link, $kayttajanimi, $email) {
    $sql = "SELECT * FROM users WHERE kayttajanimi = ? OR email = ?;";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../rekisteroidy.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $kayttajanimi, $email);
    mysqli_stmt_execute($stmt);

    $resultdata = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultdata)) {
        return $row;

    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

}

function createUser($link, $etunimi, $sukunimi, $kayttajanimi, $email, $pwd) {
    $sql = "INSERT INTO users (etunimi, sukunimi, kayttajanimi, email, salasana) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../rekisteroidy.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $etunimi, $sukunimi, $kayttajanimi, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../rekisteroidy.php?error=none");
    exit();

}

function emptyInputLogin($kayttajanimi,$pwd) {
    $result;
    if (empty($kayttajanimi) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($link, $kayttajanimi, $pwd) {
    $emailExists = emailExists($link, $kayttajanimi, $kayttajanimi);

    if ($emailExists === false) {
        header("location: ../kirjaudu.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $emailExists["salasana"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../kirjaudu.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["etunimi"] = $emailExists["etunimi"];
        $_SESSION["sukunimi"] = $emailExists["sukunimi"];
        $_SESSION["kayttajanimi"] = $emailExists["kayttajanimi"];
        $_SESSION["email"] = $emailExists["email"];
        
        header("location: ../index.php");
        exit();
    }
}

// function get_random_word($min_length, $max_length) {
//     $word = "";
//     $dictionary = '/usr/dict/words';
//     $fp = @fopen($dictionary, 'r');
//     if(!$fp) {
//         return false;
//     }
//     $size = filesize($dictionary);

//     $rand_location = rand(0,$size);
//     fseek($fp,$rand_location);

//     while ((stlen($word) < $min_length) || (strlen($word) >$max_length) || (strstr($word, "'"))) {
//         if (feof($fp)) {
//             fseek($fp, 0);
//         }
//         $word = fgets($fp, 80);
//         $word = fgets($fp, 80);
//     }

//     $word = trim($word);
//     return $word;
// }

function emptyInputReset($email) {
    $result;
    if (empty($email)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function resetPwd($link, $email) {
    $emailExists = emailExists($link, $email, $email);
    if ($emailExists === false) {
        header("location: ../forgotpasswd.php?error=wrongemail");
        exit();
    }

    $newPwd = "changeMe!";
    // $new_password = get_random_word(6,13);

    // if($new_password == false) {
    //     $new_password = "changeMe!";
    // }

    $rand_number = rand(0,999);
    $newPwd .= $rand_number;
    $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);

    $result = $link -> query("UPDATE users SET passwd = '".$hashedPwd."' WHERE email = '".$email."'");

    if (!$result) {
        header("location: ../index.php");
    } else {
        
        return $new_pwd;
    }
}

function emptyChangePwd($old_pwd, $pwd, $pwdRepeat) {
    $result;
    if (empty($old_pw) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function changePwd ($link, $email, $oldPwd, $newPwd) {

    $emailExists = emailExists($link, $email);
    
    $pwdHashed = $emailExists["passwd"];
    $checkPwd = password_verify($oldPwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../profiili.php?error=wrongpw");
        exit();
    }

    $newPwdHashed = password_hash($newPwd, PASSWORD_DEFAULT);
    $result = $link -> query("UPDATE users SET salasana = '".$newPwdHashed."' WHERE email = '".$email."'");

    if (!$result) {
        header("location: ../profiili.php?error=couldntchangepw");
        exit();

    } else {
        return true;
    }

}
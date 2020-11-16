<?php

function emptyInputSignup($etunimi, $sukunimi, $kayttajanimi, $email, $pwd, $pwdRepeat) {
    
    if (empty($etunimi) || empty($sukunimi) || empty($kayttajanimi) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;    
}

function invalidKayttajanimi($kayttajanimi) {
    
    if (!preg_match("/^[a-zA-Z0-9]{3,}$/", $kayttajanimi)) {
        $result = true;        

    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;    
}

function pwdMatch($pwd, $pwdRepeat) {
    
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;    
}

function emailOrUsernameExists($link, $kayttajanimi, $email) {
    $sql = "SELECT * FROM users WHERE kayttajanimi = ? OR email = ?;";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: rekisteroidy.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $kayttajanimi, $email);
    mysqli_stmt_execute($stmt);

    $resultdata = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultdata);

    mysqli_stmt_close($stmt);

    if($row) {
        return $row;
    } else {
        return false;
    }    

}

function createUser($link, $etunimi, $sukunimi, $kayttajanimi, $email, $pwd) {
    $sql = "INSERT INTO users (etunimi, sukunimi, kayttajanimi, email, salasana) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: rekisteroidy.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $etunimi, $sukunimi, $kayttajanimi, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: rekisteroidy.php?error=none");
    exit();

}

function emptyInputLogin($kayttajanimi,$pwd) {    
    if (empty($kayttajanimi) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($link, $kayttajanimi, $pwd) {
    $emailExists = emailOrUsernameExists($link, $kayttajanimi, $kayttajanimi);

    if ($emailExists === false) {
        header("location: kirjaudu.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $emailExists["salasana"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: kirjaudu.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["id"] = $emailExists["id"];
        $_SESSION["etunimi"] = $emailExists["etunimi"];
        $_SESSION["sukunimi"] = $emailExists["sukunimi"];
        $_SESSION["kayttajanimi"] = $emailExists["kayttajanimi"];
        $_SESSION["email"] = $emailExists["email"];
        
        header("location: index.php");
        exit();
    }
}


function emptyInputReset($email) {    
    if (empty($email)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function resetPwd($link, $email) {
    $emailExists = emailOrUsernameExists($link, $email, $email);
    if ($emailExists === false) {
        header("location: forgotpasswd.php?error=wrongemail");
        exit();
    }

    $newPwd = "changeMe!";   

    $rand_number = rand(0,999);
    $newPwd .= $rand_number;
    $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);

    $result = $link -> query("UPDATE users SET salasana = '".$hashedPwd."' WHERE email = '".$email."'");

    if (!$result) {
        header("location: index.php");
    } else {
        
        return $newPwd;
    }
}

function emptyChangePwd($old_pwd, $pwd, $pwdRepeat) {    
    if (empty($old_pwd) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function changePwd ($link, $email, $oldPwd, $newPwd) {

    $emailExists = emailOrUsernameExists($link, $email, $email);
    
    $pwdHashed = $emailExists["salasana"];
    $checkPwd = password_verify($oldPwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: profiili.php?error=wrongpw");
        exit();
    }

    $newPwdHashed = password_hash($newPwd, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET salasana = ? WHERE email = ?;";
    $stmt = mysqli_stmt_init($link);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: profiili.php?error=1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $newPwdHashed, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

}


function haeUusimmat($link, $raja = 6) {

    $sql = "SELECT resepti_id, resepti_nimi, kuva FROM resepti
        ORDER BY luotu DESC LIMIT ?;";

    $stmt = mysqli_stmt_init($link);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: reseptit.php?error=1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $raja);
    mysqli_stmt_execute($stmt);

    
    $result = mysqli_stmt_get_result($stmt);

    if($result->num_rows >0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<div class='uusimmat'><a href='resepti.php?resepti=$row[0]'> $row[1] "." $row[2]</a></div>";
    
        }
    }
}

function etsiResepti($link, $search, $search1) {

    $sql = "SELECT DISTINCT r.resepti_id, r.resepti_nimi, r.kuva FROM resepti r
        INNER JOIN ainesosa a ON a.resepti_id = r.resepti_id
        WHERE r.resepti_nimi LIKE ?
        OR a.nimi LIKE ?;";

    $stmt = mysqli_stmt_init($link);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: reseptit.php?error=2");
        exit();
    }    

    mysqli_stmt_bind_param($stmt, "ss", $search, $search1);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $foundnum = mysqli_num_rows($result);
   
    if($result->num_rows >0) {
        echo "Hakuehdoilla löytyi: " . $foundnum .  " tulosta.";
        while ($row = mysqli_fetch_array($result)) {            
            echo "<div class='etsi'><a href='resepti.php?resepti=$row[0]'> $row[1] "." $row[2]</a></div>";
    }
    } else {
        echo "Hakuehdoilla ei löytynyt reseptejä";
    }

    mysqli_stmt_close($stmt);

}

function kategoriat($link){
    $sql = "SELECT * FROM kategoria;";
    $result = mysqli_query($link, $sql);
    
    if($result->num_rows >0) {
        while ($row = mysqli_fetch_array($result)) {            
            echo "<option value= $row[0]> $row[1]</option>";
    }
    }    
}

function kategoriatRadio($link){
    $sql = "SELECT * FROM kategoria;";
    $result = mysqli_query($link, $sql);
    
    if($result->num_rows >0) {
        while ($row = mysqli_fetch_array($result)) {            
            echo "<input type='radio' id=$row[1] name='kategoria' value=$row[0]><label for='$row[1]'>$row[1]</label><br>";
    }
    }
    
}

function etsiReseptitKategorialla($link, $search) {
    $sql = "SELECT r.resepti_id, r.resepti_nimi, r.kuva FROM resepti r
        INNER JOIN kategoria k ON r.kategoria_id = k.id
        WHERE k.id =  $search;";

    $result = mysqli_query($link, $sql);

    if($result->num_rows >0) {
        while ($row = mysqli_fetch_array($result)) {            
            echo "<div class='kategoria' . $row[0]><a href='resepti.php?resepti=$row[0]'> $row[1] "." $row[2]</a></div>";
    }
    }

}

function yksikot($link){
    $sql = "SELECT * FROM yksikko;";
    $result = mysqli_query($link, $sql);
    
    if($result->num_rows >0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value= $row[0]> $row[1]</option>";
    }
    }
   
}

function yksikotjs($link){
    $sql = "SELECT nimi FROM yksikko;";
    $result = mysqli_query($link, $sql);
    
    if($result->num_rows >0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
    
    }
    return $rows;
}
}


// define("KUVAT","../uploads/");
// define("KUVA_PREFIX","resepti");

// function lataaKuva($last_id, $kuva){
    
//     $target_dir = KUVAT;
//     $target_prefix = KUVA_PREFIX;           
//     $uploadOk = 1;
//     $tempName = basename($_FILES[$kuva]["name"]);
//     $imageFileType = strtolower(pathinfo($tempName,PATHINFO_EXTENSION));
//     $name = $target_prefix.$last_id.".$imageFileType";
//     $target_file = $target_dir . $name;

    
//     // Check if image file is a actual image or fake image
//     if(isset($_POST["submit"])) {
//     $check = getimagesize($_FILES[$kuva]["tmp_name"]);
//     if($check !== false) {        
//         $uploadOk = 1;
//     } else {
//         echo "File is not an image.";
//         $uploadOk = 0;
//     }
//     }

//     // Check if file already exists
//     if (file_exists($target_file)) {
//     echo "Sorry, file already exists.";
//     $uploadOk = 0;
//     }

//     // Check file size
//     if ($_FILES["kuva"]["size"] > 500000) {
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
//     }

//     // Allow certain file formats
//     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//     && $imageFileType != "gif" ) {
//     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//     $uploadOk = 0;
//     }

//     // Check if $uploadOk is set to 0 by an error
//     if ($uploadOk == 0) {
//     echo "Sorry, your file was not uploaded.";
//     // if everything is ok, try to upload file
//     } else {
//     if (move_uploaded_file($_FILES[$kuva]["tmp_name"], $target_file)) {
//         echo "The file ". htmlspecialchars( basename( $_FILES[$kuva]["name"])). " has been uploaded.";
//     } else {
//         echo "Sorry, there was an error uploading your file.";
//     }
//     }
//     return $target_file;
        
// }

function lisaaResepti($link, $reseptinimi, $kategoria, $user, $ohje){
    $sql = "INSERT INTO resepti (resepti_nimi, kategoria_id, users_id, ohje) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: lisaaresepti.php?error=1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siis", $reseptinimi, $kategoria, $user, $ohje);
    mysqli_stmt_execute($stmt);
    $last_id = $link->insert_id;
    mysqli_stmt_close($stmt);

    return $last_id;
}


function lisaaAinesosa($link, $last_id,$maara, $yksikko, $ainesosa) {
    $sql = "INSERT INTO ainesosa (nimi, resepti_id, maara, yksikko_id ) VALUES (?,?,?,?);";

    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: lisaaresepti.php?error=1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "siii", $ainesosa, $last_id, $maara, $yksikko);
    mysqli_stmt_execute($stmt);    
    mysqli_stmt_close($stmt);
}

function paivitaKuva($link, $last_id, $path) {
    $sql = "UPDATE resepti SET kuva = $path WHERE resepti_id = $last_id;";
    // $result = mysqli_query($link, $sql);
    
}

function naytaResepti($link, $id) {    

    $sql = "SELECT r.resepti_id, u.kayttajanimi, r.resepti_nimi, k.kategoria_nimi, r.ohje
        FROM resepti r            
        INNER JOIN kategoria k ON k.id = r.kategoria_id
        INNER JOIN users u ON u.id = r.users_id
        WHERE r.resepti_id = ?;";

        $stmt = mysqli_stmt_init($link);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: resepti.php?error=1");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);


        $result = mysqli_stmt_get_result($stmt);

    
    $sql2 = "SELECT r.resepti_id, a.nimi, a.maara, y.nimi FROM ainesosa a
        INNER JOIN resepti r ON r.resepti_id = a.resepti_id
        INNER JOIN yksikko y ON y.id = a.yksikko_id WHERE r.resepti_id = ?;";
        $stmt2 = mysqli_stmt_init($link);

        if (!mysqli_stmt_prepare($stmt2, $sql2)) {
            header("location: resepti.php?error=1");
            exit();
        }

        mysqli_stmt_bind_param($stmt2, "i", $id);
        mysqli_stmt_execute($stmt2);

        $result2 = mysqli_stmt_get_result($stmt2);       
    
        if($result->num_rows >0) {
            while ($row = mysqli_fetch_array($result)) {
                echo "<div class='kayttajanimi'> $row[1] </div>";
                echo "<div class='reseptinimi'>$row[2]</div>";
                echo "<div class='naytaresepti'>Kategoria: "." $row[3]"." <br>"." Ohjeet: "." <br> "." $row[4]</div>";                       
            }
        }

        if($result2->num_rows >0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                echo "<div class='reseptiainesosat'> $row2[1]"." $row2[2]"." $row2[3]</div>";
            }
        }    
      

}
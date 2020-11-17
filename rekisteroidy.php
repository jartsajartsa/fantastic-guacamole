<?php
    include_once 'header.php';
    require_once 'includes/dbh.inc.php';
?>


<div class="signup-form">
    <h2>Rekisteröityminen</h2>
        <form action="formhandle.php" method="post">
            <input type="text" name="etunimi" placeholder="Etunimi..." required>
            <input type="text" name="sukunimi" placeholder="Sukunimi..." required>
            <input type="text" name="kayttajanimi" pattern="[a-zA-Z0-9]{3,}" placeholder="Käyttäjänimi.." required>
            <input type="text" name="email" placeholder="E-mail.." required>            
            <input type="password" name="pwd" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Salasana.." required>
            <input type="password" name="pwdrepeat" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Salasana uudelleen.." required>
            <button type="submit" name="submitrekisteroidy">Rekisteröidy</button><br>
        </form>
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Täytä kaikki kentät</p>";
        }

        if ($_GET["error"] == "invalidusername") {
            echo "<p>Käyttäjänimi ei sallittu</p>";
        }

        else if ($_GET["error"] == "invalidemail") {
            echo "<p>Virhe email osoitteessa</p>";
        } 

        else if ($_GET["error"] == "email/usernametaken") {
            echo "<p>Email tai käyttäjänimi jo käytössä</p>";
        } 

        else if ($_GET["error"] == "passwordsdontmatch") {
            echo "<p>Salasanat eivät täsmää</p>";
        } 

        else if ($_GET["error"] == "stmtfailed") {
            echo "<p>Jokin meni vikaan</p>";
        }
        else if ($_GET["error"] == "none") {
            echo "<p>Rekisteröityminen onnistui!</p>";
        }
        
    }
?>
</div>

<?php
    include_once 'footer.php';
?>
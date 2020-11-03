<?php
    include_once 'header.php';

?>

<div class="signup-form">
    <h2>Rekisteröityminen</h2>
    <form action="includes/rekisteroidy.inc.php" method="post">
        <input type="text" name="etunimi" placeholder="Etunimi..." required>
        <input type="text" name="sukunimi" placeholder="Sukunimi..." required>
        <input type="text" name="email" placeholder="Email.." required>
        <input type="password" name="passwd" placeholder="Salasana.." required>
        <input type="password" name="passwdrepeat" placeholder="Salasana uudelleen.." required>
        <button type="submit" name="submit">Sign up</button>
    </form>
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Täytä kaikki kentät</p>";
        }

        else if ($_GET["error"] == "invalidemail") {
            echo "<p>Virhe email osoitteessa</p>";
        } 

        else if ($_GET["error"] == "emailtaken") {
            echo "<p>Email jo käytössä</p>";
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
</divn>

<?php
    include_once 'footer.php';

?>
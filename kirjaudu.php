<?php
    include_once 'header.php';
?>


<div class="signup-form">
    <h2>Kirjaudu sisään</h2>
        <form action="formhandle.php" method="post">
            <input type="text" name="kayttajanimi" placeholder="Käyttäjänimi tai e-mail.." required>
            <input type="password" name="pwd" placeholder="Salasana.." required>
            <button type="submit" name="submitkirjaudu">Kirjaudu</button><br>
            <a href="forgotpwd.php">Unohtuiko salasana?</a>
        </form>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Täytä kaikki kentät</p>";
        }
        else if ($_GET["error"] == "wronglogin") {
            echo "<p>Kirjautuminen epäonnistui</p>";
        }
        else if ($_GET["error"] == "success") {
            echo "<p>Salasana resetoitu</p>";
        }
    }

    ?>
</div>


<?php
    include_once 'footer.php';
?>
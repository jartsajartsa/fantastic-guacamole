<?php
    include_once 'header.php';

?>

<div class="signup-form">
    <h2>Kirjaudu sisään</h2>
    <form action="includes/kirjaudu.inc.php" method="post">
        <input type="text" name="email" placeholder="Email.." required>
        <input type="password" name="passwd" placeholder="Salasana.." required>
        <button type="submit" name="submit">Log in</button><br>
        <a href="forgotpasswd.php">Unohtuiko salasana?</a>
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
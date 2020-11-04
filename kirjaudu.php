<?php
    include_once 'header.php';
?>

<main>
<div class="signup-form">
    <h2>Kirjaudu sisään</h2>
        <form action="includes/kirjaudu.inc.php" method="post">
            <input type="text" name="email" placeholder="Käyttäjänimi tai email.." required>
            <input type="password" name="pwd" placeholder="Salasana.." required>
            <button type="submit" name="submit">Kirjaudu</button><br>
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
<main>

<?php
    include_once 'footer.php';
?>
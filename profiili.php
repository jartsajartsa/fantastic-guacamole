<?php
    include_once 'header.php';
?>


<div class="profiili">
    <h2>Profiili</h2>
    <?php
    echo "<p> Käyttäjänimi: " . $_SESSION['kayttajanimi'] . "</p>";
    echo "<p> Nimi: " . $_SESSION['etunimi'] . " " . $_SESSION['sukunimi'] . "</p>";
    echo "<p> Email: " . $_SESSION['email'] . "</p><br>";    
    ?>
</div>

<div class="signup-form">
    <h2>Vaihda salasana</h2>
    <form action="formhandle.php" method="post">
        <input type="password" name="oldPwd" placeholder="Vanha salasana.." required>
        <input type="password" name="pwd" placeholder="Uusi salasana.." required>
        <input type="password" name="pwdrepeat" placeholder="Uusi salasana toistamiseen.." required>
        <button type="submit" name="submitchangepwd">Vaihda salasana</button><br>
    </form>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Täytä kaikki kentät</p>";
        }
        else if ($_GET["error"] == "wrongpw") {
            echo "<p>Väärä salasana</p>";
        } 

        else if ($_GET["error"] == "couldntchangepw") {
            echo "<p>Salasanan vaihto ei onnistunut</p>";
        }

        else if ($_GET["error"] == "passwordsdontmatch") {
            echo "<p>Salasanat eivät täsmää</p>";
        }
    }
?>
</div>

<?php
    include_once 'footer.php';
?>
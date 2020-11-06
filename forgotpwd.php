<?php
    include_once 'header.php';
?>

<main>
<div class="signup-form">
    <h2>Unohtunut salasana</h2>
    <form action="includes/resetpwd.inc.php" method="post">
    <input type="text" name="email" placeholder="Email..">
    <button type="submit" name="submit">Lähetä</button><br>
    <a href="kirjaudu.php">Takaisin</a>
</form>
<?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "wrongemail") {
            echo "<p>Virheellinen email</p>";
        }
    }

 ?>

    </div>

</main>
<?php
    include_once 'footer.php';

?>
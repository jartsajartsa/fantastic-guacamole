<?php
    include_once 'header.php';
?>


<div class="signup-form">
    <h2>Unohtunut salasana</h2>
    <form action="formhandle.php" method="post">
    <input type="text" name="email" placeholder="E-mail..">
    <button type="submit" name="submitresetpwd">Lähetä</button><br>
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


<?php
    include_once 'footer.php';

?>
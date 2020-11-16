<?php
include_once 'header.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

?>
     
    <div class ="signup-form">
    <h2>Hae reseptejä</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">    
    <?php        
    kategoriatRadio($link);
    
    ?>
    <br>
    <button type="submit" name="submithaekategoria">Hae kategorialla</button><br>
    </div>
</form>

    <div class="signup-form">    
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">     
        <input type="text" placeholder="Etsi" name="search">
        <button type="submit" name="submithae">Etsi</button><br>
    </form>

    </div>
   
<?php

if (isset($_GET["submithae"])) {
    $search = $_GET['search'];
    etsiResepti($link, $search, $search);
    
}

if (isset($_GET["submithaekategoria"])) {
    $search = $_GET['kategoria'];
    etsiReseptitKategorialla($link, $search);
    
}


include_once 'footer.php';
?>
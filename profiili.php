<?php
    include_once 'header.php';
?>

<main>
    <div class="profiili">
        <h2>Profiili</h2>
        <?php
        echo "<p> Käyttäjänimi: " . $_SESSION['kayttajanimi'] . "</p>";
        echo "<p> Nimi: " . $_SESSION['etunimi'] . " " . $_SESSION['sukunimi'] . "</p>";
        echo "<p> Email: " . $_SESSION['email'] . "</p>";
        ?>
    </div>
</main>

<?php
    include_once 'footer.php';
?>
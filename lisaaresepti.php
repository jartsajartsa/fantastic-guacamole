<?php
    include_once 'header.php';
    include_once 'formhandle.php';
    include_once 'includes/functions.inc.php';
    include_once 'includes/dbh.inc.php';
?>

<script>
    window.data = <?php echo json_encode(yksikotjs($link), JSON_HEX_TAG); ?>;    
</script>

<div class="lisaaresepti">
<h2>Lisää resepti</h2><br>
<form action="formhandle.php" method="post" enctype="multipart/form-data">
    <input type="text" name="reseptinnimi"  placeholder="Reseptin nimi" required><br><br>
    <label>Kategoria:</label>
    <select name="kategoria" id="kategoria" required>    
    <?php
        kategoriat($link);
    ?>
    </select><br>
        <br><label>Lataa kuva</label>
        <input type="file" name="kuva" id="kuva"><br>
    <div id="ainekset">
    <div id="TextBoxDiv1">
        <label>Määrä #1 : </label><input type='textbox' name="maara" id='maara1' placeholder="5" required>        
        <select name="yksikko" id="yksikko1" required>
    <?php
        yksikot($link);
    ?>
    </select>
        <label>Ainesosa #1 : </label><input type='textainesosa' name="ainesosa" id='ainesosa1' placeholder="vettä" required>
    </div>
</div>
    <input type='button' value='Lisää Rivi' id='addButton'>
    <input type='button' value='Poista Rivi' id='removeButton'><br><br>

    <label>Ohje: </label><br>
    <textarea name="ohje" id="ohje" required> </textarea><br><br>
   
    <button type="submit" name="submitlisaa">Lisää resepti</button>
    </form>

</div>

<?php    
    include_once 'footer.php';

?>
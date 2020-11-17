<?php
    include_once 'header.php';
    require_once 'formhandle.php';
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';
?>

<script>
    var options = <?php echo json_encode(yksikotjs($link), JSON_HEX_TAG); ?>;
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
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <div id="ainekset">
    <div id="TextBoxDiv1">
        <label>Määrä #1 : </label><input type='textbox' name="ainekset[aines1][maara]" id='maara1' placeholder="5" required>        
        <select name="ainekset[aines1][yksikko]" id="yksikko1" required>
    <?php
        yksikot($link);
    ?>
    </select>
        <label>Ainesosa #1 : </label><input type='textainesosa' name="ainekset[aines1][ainesosa]" id='ainesosa1' placeholder="vettä" required>
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
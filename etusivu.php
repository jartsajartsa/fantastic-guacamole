<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';
?>
    <main>    
       
        <section class="banner">
            <h2>Maukkaat reseptit elämän joka tilanteeseen</h2>
            
        </section>
        
        <h2>Uusimmat reseptit: </h2>
        <?php
            haeUusimmat($link);
            ?>
        

    </main>

    
    
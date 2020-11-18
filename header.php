 <?php
    session_start();
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Limeanteri</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="includes/jsfunctions.inc.js"></script>
        
</head>
<body>
    <header>
        <a href="index.php" class="header-brand">Limeanteri</a>
        <section id="header_nav">
            <a class="icon" onclick="topnav()"><i class="fa fa-bars"></i></a><nav id="nav" class="header_nav">
            <ul>
                <li><a href="index.php">Etusivu</a></li>
                <li><a href="reseptit.php">Reseptit</a></li>
                <?php 
                    if (isset($_SESSION["kayttajanimi"])) {
                        echo "<li><a href='lisaaresepti.php'>Lisää resepti</a><li>";
                        echo "<li><a href='profiili.php'>Profiili</a><li>";
                        echo "<li><a href='includes/logout.inc.php'>Kirjaudu ulos</a><li>";
                    }
                    else {
                        echo "<li><a href='kirjaudu.php'>Kirjaudu</a><li>";
                        echo "<li><a href='rekisteroidy.php'>Rekisteröidy</a><li>";
                    }
                ?>
            </ul>
            </nav>
            </section>

        <?php        
        // if (isset($_SESSION["kayttajanimi"])) {
            
        //     echo "<div class='username'>" . $_SESSION["kayttajanimi"] . "</div>";
        // }       
        
        ?>
    </header>

    <div class="wrapper">

    
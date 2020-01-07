<?php
    @session_start();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Found in the Basement. Zespół rokowy założony w xxxx r. w Warszawie przez Marka Kotuszewskiego (wokal, gitara), Kubę Wiśniewskiego (gitara basowa, instrumenty klawiszowe) oraz Bartka Koazak (perkusja). Zapraszamy na stronę" />
    <meta name="keywords" content="Rock, muzyka, zespół, gitara, bas, wokal, koncert" />
    <meta name="author" content="Kacper Mitkowski" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Found in the Basement</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Righteous&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="css/fontello.css" type="text/css" />
    <link rel="shortcut icon" href="img/logo.ico"/>
    
    <script src="jquery-3.2.1.min.js"></script>
    <script src="scripts.js" type="text/javascript"></script>
    <script src="jquery.scrollTo.min.js" type="text/javascript"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body onload="zegar()">
    <aside>
        <?php
        if (!isset($_SESSION['udalo_sie_zalogowac_jako_fan']))
            echo '<div class="maly_div">Jesteś fanem? <a href="fun_log_outcome.php" id="link_log_above_logo">Zaloguj się</a></div>';
        else 
            echo '<div class="maly_div">Jesteś zalogowany jako <span style="color: green">'.$_SESSION['user'].'</span>. <a href="logout.php" id="link_log_above_logo">Wyloguj się</a></div>';

        if (!isset($_SESSION['udalo_sie_zalogowac_jako_admin']))
            echo '<div class="maly_div" style="text-align: right;">Jesteś adminem? <a href="adm_log_outcome.php" id="link_log_above_logo">Zaloguj się</a></div>';
        else 
            echo '<div class="maly_div" style="text-align: right;">Adminie - jesteś zalogowany jako <span style="color: yellow">'.$_SESSION['admin_name'].'</span>. <a href="logout.php" id="link_log_above_logo">Wyloguj się</a></div>';
        
        echo '<div style="clear: both;"></div>';
        ?>
    </aside>
    <header>
        <div id="logo"><a href="index.php" class="linkLogo">Found in the Basement</a></div>
    </header>
    <nav>
        <div class="topnav">
            <div id="center">
                <ol>
                    <li><a href="index.php" class="menuTopnavOption">Start</a></li>
                    <li><a href="sklad.php" class="hover_menu_option">O zespole</a>
                        <ul>
                            <li><a href="sklad.php" class="hover_menu_option">Skład</a></li>
                            <li><a href="paczatki.php" class="hover_menu_option">Początki</a></li>
                            <li><a href="inspiracje.php" class="hover_menu_option">Inspiracje</a></li>
                        </ul>   
                    </li>
                    <li><a href="plyty.php" class="hover_menu_option">Muzyka</a>
                        <ul>
                            <li><a href="plyty.php" class="hover_menu_option">Płyty</a></li>
                            <li><a href="concert.php" class="hover_menu_option">Koncerty</a></li>
                            <li><a href="galeria.php" class="hover_menu_option">Galeria</a></li>
                            <li><a href="przyszlosc.php" class="hover_menu_option">Przyszłość</a></li>
                        </ul>
                    </li>
                    <li><a href="funclub.php" class="menuTopnavOption">Fun Club</a></li>
                    <li><a href="kontakt.php" class="menuTopnavOption">Kontakt</a></li>
                    <li>Offtop
                        <ul>
                            <li><a href="#" class="menuTopnavOption">Wisielec</a></li>
                            <li><a href="pamiec.php" class="menuTopnavOption">Pamięć</a></li>
                        </ul>
                    </li>
                
                <?php
                    if (isset($_SESSION['udalo_sie_zalogowac_jako_admin']))
                    {
                        echo '<li class="admin_option"><a href="uzytkownicy.php" class="admin_link">Użytkownicy</a></li>';
                    }
                ?>

                </ol>
            </div>
        </div>
    </nav>


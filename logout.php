<?php

    session_start();

    session_unset();

    $_SESSION['czy_wylogowano'] = true;
    
    header("Location: unlogged.php");
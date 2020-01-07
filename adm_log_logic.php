<?php

    session_start();
    require_once "admin_connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($polaczenie->connect_errno != 0)
    {
        echo 'Błąd nr: '.$polaczenie->connect_errno;
    }

    else
    {
        $login_ad = $_POST['login_ad'];
        $login_ad = htmlentities($login_ad, ENT_QUOTES, "UTF-8");
        $haslo_ad = $_POST['haslo_ad'];
        $sql = "SELECT * FROM admins WHERE login='$login_ad'";

        if ($rezultat = $polaczenie->query($sql))
        {
            $ilu_adminow = $rezultat->num_rows;
            if ($ilu_adminow > 0)
            {   
                $wiersz = $rezultat->fetch_assoc();
                if (password_verify($haslo_ad, $wiersz['haslo']) == true)
                {
                    $_SESSION['numer_klikniecia_zarejestruj'] = 0;
                    $_SESSION['udalo_sie_zalogowac_jako_admin'] = true;
                    $_SESSION['czy_zalogowany_user'] = false;
                    $_SESSION['admin_name'] = $wiersz['login'];
    
                    $rezultat->close();
                    header("Location: adm_log_outcome.php");
                }
                else
                {
                    $_SESSION['admin_logging_error'] = '<div style="text-align: center; letter-spacing: 2px; font-size: 25px; margin-top: 40px;"><span style="color: #AB5564;">Dobry login ale złe hasło</span></div>';
                    header("Location: adm_log_outcome.php");
                }
            }

            else
            {
                $_SESSION['admin_logging_error'] = '<div style="text-align: center; letter-spacing: 2px; font-size: 25px; margin-top: 40px;"><span style="color: #AB5564;">Błędny login lub hasło</span></div>';
                header("Location: adm_log_outcome.php");
            }
            $polaczenie->close();
        }
    }

?>
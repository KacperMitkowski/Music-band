<?php
    session_start();
    require_once "fun_connect.php";

    // Próbujemy nawiązać połączenie z bazą danych
    $polaczenie = @new mysqli($host, $db_user, $db_pass, $db_name);

    // Jeśli jest błąd z połączenia z bazą danych
    if ($polaczenie->connect_errno != 0)
    {
        echo 'Błąd nr: '.$polaczenie->connect_errno;
    }

    // Jeśli nie ma błędu
    else
    {
        $login = $_POST['login'];
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $haslo = $_POST['haslo'];
        $sql = "SELECT * FROM registered_users WHERE login='$login'";

        // Jeśli zapytanie SQL OK
        if ($rezultat = $polaczenie->query($sql))
        {
            $ile_takich_userow = $rezultat->num_rows;

            // Jeśli login OK
            if ($ile_takich_userow > 0)
            {
                $wiersz = $rezultat->fetch_assoc();

                // Jeśli login i hasło OK
                if (password_verify($haslo, $wiersz['haslo']) == true)
                {
                    $_SESSION['numer_klikniecia_zaloguj'] = 0; // Do zmiany komunikatu gdy ktoś kliknie zaloguj gdy jest już zalogowany
                    $_SESSION['udalo_sie_zalogowac_jako_fan'] = true; // Do zmiany komunikatu gdy ktoś kliknie zaloguj gdy jest już zalogowany
                    $_SESSION['czy_zalogowany_admin'] = false; // Żeby admin nie mógł się zalogować
                    $_SESSION['user'] = $wiersz['login'];
                    $_SESSION['premium'] = $wiersz['premium'];

                    $rezultat->close();
                    header("Location: fun_log_outcome.php");
                }

            // Jeśli login OK, ale hasło złe
                else
                {
                    $_SESSION['fan_logging_error'] = '<div style="text-align: center; letter-spacing: 2px; font-size: 25px; margin-top: 40px;"><span style="color: #AB5564;">Dobry login ale złe hasło</span></div>';
                    header("Location: fun_log_outcome.php");
                }
            }

            // Jeśli nie znaleziono usera (Błędny login lub hasło)
            else
            {
                $_SESSION['fan_logging_error'] = '<div style="text-align: center; letter-spacing: 2px; font-size: 25px; margin-top: 40px;"><span style="color: #AB5564;">Błędny login lub hasło</span></div>';
                header("Location: fun_log_outcome.php");
            }
            $polaczenie->close();
        }
    }
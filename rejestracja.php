<?php

    require_once "beg.php";

    if (isset($_SESSION['udalo_sie_zalogowac_jako_fan']))
    {
        header("Location: fun_log_outcome.php");
        exit();
    }

    if (isset($_SESSION['udalo_sie_zalogowac_jako_admin']))
    {
        header("Location: adm_log_outcome.php");
        exit();
    }

    $_SESSION['numer_klikniecia_zarejestruj'] = 1;
    if (isset($_POST['login']))
    {
        $wszystko_ok = true;

        $nick = $_POST['login'];

        if (ctype_alnum($nick) == false)
        {
            $wszystko_ok = false;
            $_SESSION['e_nick'] = '<span style="color: #BA5966; font-size: 18px;">Nick zawiera niedozwolone znaki</span>';
        }

        if ((strlen($nick) < 4) || (strlen($nick) > 20))
        {
            $wszystko_ok = false;
            $_SESSION['e_nick'] = '<span style="color: #BA5966; font-size: 18px;">Nick musi zawierać od 4 do 20 znaków</span>';
        }

        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if ((strlen($haslo1) < 4) || (strlen($haslo1) > 20))
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] = '<span style="color: #BA5966; font-size: 18px;">Hasło musi zawierać od 4 do 20 znaków</span>'; 
        }

        if ($haslo1 != $haslo2)
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] = '<span style="color: #BA5966; font-size: 18px;">Hasła nie są jednakowe</span>'; 
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($email != $emailB))
        {
            $wszystko_ok = false;
            $_SESSION['e_email'] = '<span style="color: #BA5966; font-size: 18px;">Email zawiera niedozwolone znaki</span>'; 
        }

        if (!isset($_POST['regulamin']))
        {
            $wszystko_ok = false;
            $_SESSION['e_regulamin'] = '<span style="color: #BA5966; font-size: 18px;">Zaakceptuj regulamin</span>'; 
        }

        if (!isset($_POST['milosc']))
        {
            $wszystko_ok = false;
            $_SESSION['e_milosc'] = '<span style="color: #BA5966; font-size: 18px;">Musisz kochać zespół by się zarejestrować :)</span>'; 
        }

//        $sekret = "6LdRW6oUAAAAAAZPRQDvYza5cal0JkWMKyWvC7ds";
//        $sprawdz = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$sekret."&response=".$_POST['g-recaptcha-response']);
//        $odpowiedz = json_decode($sprawdz);
//
//        if ($odpowiedz->success == false)
//        {
//            $wszystko_ok = false;
//            $_SESSION['e_bot'] = '<span style="color: #BA5966; font-size: 18px;">Przejdź test jeszcze raz</span>';
//        }

        require_once "fun_connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try
        {
            $polaczenie = new mysqli($host, $db_user, $db_pass, $db_name);
            if ($polaczenie->connect_errno != 0) throw new Exception(mysqli_connect_errno()); // Jeśli nie udało się połączyć z bazą -> rzuć wyjątkiem

            else
            {
                $rezultat = $polaczenie->query("SELECT id FROM registered_users WHERE login='$nick'"); // Sprawdzenie czy istnieje już taki nick w bazie
                if (!$rezultat) throw new Exception($polaczenie->error); // Jeśli jest literówka w zapytaniu SQL

                $ile_takich_nickow = $rezultat->num_rows;
                if ($ile_takich_nickow > 0) // Jeśli jest taki nick
                {
                    $wszystko_ok = false;
                    $_SESSION['e_nick'] = '<span style="color: #BA5966; font-size: 18px;">Jest już użytkownik o takim nicku</span>';
                }

                $rezultat = $polaczenie->query("SELECT id FROM registered_users WHERE email='$email'"); // Sprawdzenie czy istnieje już taki email w bazie
                if (!$rezultat) throw new Exception($polaczenie->error); // Jeśli jest literówka w zapytaniu SQL

                $ile_takich_maili = $rezultat->num_rows; // Jeśli jest taki email
                if ($ile_takich_maili > 0)
                {
                    $wszystko_ok = false;
                    $_SESSION['e_email'] = '<span style="color: #BA5966; font-size: 18px;">Jest już konto przypisane do tego adresu email</span>'; 
                }

                if ($wszystko_ok == true)
                {
                    if ($polaczenie->query("INSERT INTO registered_users VALUES (NULL, '$nick', '$haslo_hash', '$email', now() + INTERVAL 30 DAY)"))
                    {
                        $_SESSION['udanarejestracja'] = true;
                        $_SESSION['numer_klikniecia_zarejestruj']++;
                        unset($nick);
                        unset($haslo1);
                        unset($haslo2);
                        unset($email);
                        unset($emailB);
                        unset($sekret);
                        unset($sprawdz);
                        unset($odpowiedz);
                    }
                    else // Jeśli literówka w zapytaniu SQL
                    {
                        throw new Exception($polaczenie->error);
                    }
                }
                $polaczenie->close();
            }
        }

        catch (Exception $e)
        {
            echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie</span><br />';
            echo 'Informacja deweloperska: '.$e;
        }
    }
?>

    <main>
        <article>
            <div id="content">

                <header>
                    <?php
                        if (!isset($_SESSION['udanarejestracja'])) // PIERWSZE WEJŚCIE oraz KOLEJNE WEJŚCIE PO REJESTRACJI

                            if (!isset($_SESSION['udanelogowanie'])) // PIERWSZE WEJŚCIE oraz KOLEJNE WEJŚCIE PO REJESTRACJI i NIEZALOGOWANY
                                echo '<div class="podnaglowek" style="margin-bottom: 20px;">Rejestracja</div>'; 

                            else // PIERWSZE WEJŚCIE oraz KOLEJNE WEJŚCIE PO REJESTRACJI I ZALOGOWANY
                                {
                                    echo '<div class="podnaglowek" style="margin-bottom: 20px;">Żeby się zarejestrować musisz najpierw wylogować się</div>';
                                    echo '<div style="text-align: center;"><a href="logout.php" id="link_log_above_logo" class="podnaglowek" style="font-size: 25px;">Wyloguj się</a></div>'; 
                                }

                        else // TYLKO PO UDANEJ REJESTRACJI
                            {
                                echo '<div class="podnaglowek" style="margin-bottom: 20px;">Udana rejestracja</div>';          
                                echo '<div style="text-align: center; font-size: 20px;">Możesz teraz się zalogować</div>';
                                echo '<br /><br />';
                                echo '<div style="text-align: center; font-size: 20px;"><a href="fun_log_outcome.php" id="link_log_above_logo" class="podnaglowek">Zaloguj się</a></div>';
                                unset($_SESSION['udanarejestracja']);
                            }
                    ?>                    
                </header>

                <?php
                    if (!isset($_SESSION['udanarejestracja']) && ($_SESSION['numer_klikniecia_zarejestruj'] == 1) && (!isset($_SESSION['udanelogowanie']))) 
                    // PIERWSZE WEJŚCIE oraz KOLEJNE WEJŚCIE PO REJESTRACJI i NIEZALOGOWANY
                        {
                ?>
                    <form method="post" id="formReg">
<!-- ################################################################################################################################## -->
<!-- LOGIN-->
                        <section>
                            <div class="optionReg"><label>Login: <input type="text" class="optionRegInput" name="login" /></label></div>
                            <?php
                                if (isset($_SESSION['e_nick']))
                                {
                                    echo '<div style="margin-bottom: 20px;">'.$_SESSION['e_nick'].'</div>';
                                    unset($_SESSION['e_nick']);
                                }
                            ?>
                        </section>
<!-- ################################################################################################################################## -->
<!-- HASŁO-->
                        <section>
                            <div class="optionReg"><label>Hasło: <input type="password" class="optionRegInput" name="haslo1" /></label></div>
                            <?php
                                if (isset($_SESSION['e_haslo']))
                                {
                                    echo '<div style="margin-bottom: 20px;">'.$_SESSION['e_haslo'].'</div>';
                                    unset($_SESSION['e_haslo']);
                                }
                            ?>
                        </section>

                        <section>
                            <div class="optionReg"><label>Powtórz hasło: <input type="password" class="optionRegInput" name="haslo2" /></label></div>    
                        </section>
<!-- ################################################################################################################################## -->
<!-- EMAIL-->

                        <section>
                            <div class="optionReg"><label>E-mail: <input type="text" class="optionRegInput" name="email"/></label></div>  
                            <?php
                                if (isset($_SESSION['e_email']))
                                {
                                    echo '<div style="margin-bottom: 20px;">'.$_SESSION['e_email'].'</div>';
                                    unset($_SESSION['e_email']);
                                }
                            ?>        
                        </section>
<!-- ################################################################################################################################## -->
<!-- REGULAMIN-->
                        <section>
                            <div class="optionReg" style="text-align: right; margin-bottom: 0px;"><label>Akceptuję regulamin: <input type="checkbox" name="regulamin"/></label></div>  
                            <?php
                                if (isset($_SESSION['e_regulamin']))
                                {
                                    echo '<div style="margin-bottom: 20px;">'.$_SESSION['e_regulamin'].'</div>';
                                    unset($_SESSION['e_regulamin']);
                                }
                            ?> 
                        </section>
<!-- ################################################################################################################################## -->
<!-- MIŁOŚĆ-->
                        <section>
                            <div class="optionReg" style="text-align: right; margin-bottom: 0px;"><label>Kocham FitB: <input type="checkbox" name="milosc" /></label></div>    
                            <?php
                                if (isset($_SESSION['e_milosc']))
                                {
                                    echo '<div style="margin-bottom: 20px;">'.$_SESSION['e_milosc'].'</div>';
                                    unset($_SESSION['e_milosc']);
                                }
                            ?> 
                        </section>
<!-- ################################################################################################################################## -->
<!-- RECAPTCHA-->
                        <section>
                            <div class="g-recaptcha" data-sitekey="6LekeIEUAAAAANIfoxj2l1oS3VCV54jW_aqBIFw5"></div>
                            <?php
                                if (isset($_SESSION['e_bot']))
                                {
                                    echo '<div style="margin-bottom: 20px;">'.$_SESSION['e_bot'].'</div>';
                                    unset($_SESSION['e_bot']);
                                }
                            ?> 
                        </section>
<!-- ################################################################################################################################## -->
<!-- SUBMIT BUTTON -->
                        <section>
                            <div><input type="submit" value="Zarejestruj się" style="margin-top: 50px;" id="przyciskReg" /></div>
                        </section>
                    </form>    
                    
                    <?php
                    }
                    ?>

            </div>
        </article>
    </main>



<?php
    require_once "end.php";
?>


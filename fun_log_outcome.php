<?php
    require_once "beg.php";
?>
    <main>
        <article>
            <div id="content">
<?php
                // Gdy admin chce zalogować się jako fan (konieczność wylogowania jako admin)
                if (isset($_SESSION['udalo_sie_zalogowac_jako_admin']))
                {
                    echo '<header>';
                    echo '<div class="podnaglowek"">Musisz się najpierw wylogować i zalogować jako fan</div>';
                    echo '</header>';
                    echo '<div style="text-align: center; margin-top: 50px; font-size: 25px;"><a href="logout.php" id="link_log_above_logo" class="podnaglowek" style="font-size: 25px;">Wyloguj się</a></div>';
                }   
                
                // To co widzi użytkownik przed zalogowaniem
                if (!isset($_SESSION['udalo_sie_zalogowac_jako_fan']))
                { 
                    // ten if wykona się gdy użytkownik nie jest fanem
                    if (!isset($_SESSION['czy_zalogowany_user']))
                    {       
                        echo '<header>';
                        echo '<div class="podnaglowek">Logowanie</div>';
                        echo '</header>';
                        echo '<section>';
                            echo '<form action="fun_log_logic.php" method="post" id="formLog">';
                            echo '<label>Login: <input type="text" placeholder="  Wprowadź login" name="login" class="login_in_login" /></label>';
                            echo '<label>Hasło: <input type="password" placeholder="  Podaj hasło" name="haslo" class="password_in_login"></label>';
                            echo '<input type="submit" value="Zaloguj się" id="log_przycisk" />';
                            echo '</form>';
                        echo '</section>';
                    }

                    // Jeżeli błąd podczas logowania
                    if (isset($_SESSION['fan_logging_error']))
                    {
                        echo $_SESSION['fan_logging_error'];
                        unset($_SESSION['fan_logging_error']);
                    }
                }

                // Strona udanego logowania
                else
                {         
                    // Strona załadowana po "pierwszym" zalogowaniu
                    $_SESSION['numer_klikniecia_zaloguj']++;
                    if ($_SESSION['numer_klikniecia_zaloguj'] == 1)
                    {
                        echo '<div class="podnaglowek">Udane logowanie!</div>';
                        echo '<div style="text-align: center; margin-top: 30px; font-size: 20px;">Możesz teraz korzystać z serwisu</div>';
                        echo '<div style="text-align: center; margin-top: 30px; color: green; font-size: 90px;"><i class="icon-ok"></i></div>';
                    }

                    // Odświeżona strona "logowania" (zmiana komunikatu dla fana)
                    else
                    {
                        echo '<div class="podnaglowek"">Przecież jesteś zalogowany/a jako: <span style="color: green;">'.$_SESSION['user'].'</span></div>';
                        echo '<div style="text-align: center; margin-top: 50px; font-size: 25px;">Chcesz zmienić konto?<i class="icon-right" style="color: #9C4528;"></i><a href="logout.php" id="link_log_above_logo" class="podnaglowek" style="font-size: 25px;">Wyloguj się</a></div>';
                    }
                }
?>
            </div>
        </article>
    </main>
<?php
    require_once "end.php";
?>


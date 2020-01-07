<?php
    require_once "beg.php";
?>
    <main>
        <article>
            <div id="content">
<?php
                // Gdy fan chce zalogować się jako admin (konieczność wylogowania jako fan)
                if (isset($_SESSION['udalo_sie_zalogowac_jako_fan']))
                {
                    echo '<header>';
                    echo '<div class="podnaglowek"">Musisz się najpierw wylogować i zalogować jako admin</div>';
                    echo '</header>';
                    echo '<div style="text-align: center; margin-top: 50px; font-size: 25px;"><a href="logout.php" id="link_log_above_logo" class="podnaglowek" style="font-size: 25px;">Wyloguj się</a></div>';
                }

                // To co widzi użytkownik przed zalogowaniem 
                if (!isset($_SESSION['udalo_sie_zalogowac_jako_admin']))
                {
                    // ten if wykona się gdy użytkownik nie jest adminem
                    if (!isset($_SESSION['czy_zalogowany_admin']))
                    {
                        echo '<header>';
                        echo '<div class="podnaglowek">Przejmij władzę</div>';
                        echo '</header>';
                        echo '<section>';
                            echo '<form action="adm_log_logic.php" method="post" id="formLog">';
                            echo '<label>Login: <input type="text" placeholder="  Wprowadź login" name="login_ad" class="login_in_login" /></label>';
                            echo '<label>Hasło: <input type="password" placeholder="  Podaj hasło" name="haslo_ad" class="password_in_login"></label>'; 
                            echo '<input type="submit" value="Zaloguj się" id="log_przycisk" />';
                            echo '</form>';
                        echo '</section>';
                    }

                    // Jeżeli błąd podczas logowania
                    if (isset($_SESSION['admin_logging_error']))
                    {
                        echo $_SESSION['admin_logging_error'];
                        unset($_SESSION['admin_logging_error']);
                    }
                }

                // Strona po udanym logowaniu
                else
                {
                    // Strona załadowana po "pierwszym" zalogowaniu
                    $_SESSION['numer_klikniecia_zarejestruj']++;
                    if ($_SESSION['numer_klikniecia_zarejestruj'] == 1)
                    {
                        echo '<div class="podnaglowek">Udane logowanie!</div>';
                        echo '<div style="text-align: center; margin-top: 30px; font-size: 20px;">Możesz teraz rządzić światem</div>';
                        echo '<div style="text-align: center; margin-top: 30px; color: green; font-size: 90px;"><i class="icon-ok"></i></div>';
                    }

                    // Odświeżona strona "logowania" (zmiana komunikatu dla admina)
                    else
                    {
                        echo '<div class="podnaglowek"">Adminie - jesteś zalogowany/a jako: <span style="color: green;">'.$_SESSION['admin_name'].'</span></div>';
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


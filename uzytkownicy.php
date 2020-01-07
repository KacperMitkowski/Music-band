<?php
    require_once "beg.php";
    require_once "fun_connect.php";

    if (!isset($_SESSION['udalo_sie_zalogowac_jako_admin']))
    {
        header("Location: index.php");
        exit();
    }
?>

    <main>
        <article>
            <div id="content">

                <header>
                    <div class="podnaglowek">Zarejestrowani użytkownicy</div>
                </header>
                
      
                    <?php
                        $polaczenie = @new mysqli($host, $db_user, $db_pass, $db_name);
                        if (mysqli_connect_errno())
                            echo "Wystąpił błąd połączenia z bazą";
                        else
                        {  
                            $wynik = mysqli_query($polaczenie, "SELECT * FROM registered_users");
                            $liczba_rekordow = $wynik->num_rows;

                            echo '<table border="2" rules="all" cellpadding="10">';
                            echo '<thead>';
                            echo '<tr><td colspan="4">Liczba użytkowników: '.$liczba_rekordow.'</td></tr>';
                            echo '<tr><td>Pozycja</td><td>Login</td><td>E-mail</td><td>Wygaśnięcie premium</td></tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($row = mysqli_fetch_array($wynik))
                            {
                                echo '<tr><td>'.$row['id'].'</td><td>'.$row['login'].'</td><td>'.$row['email'].'</td><td>'.$row['premium'].'</td></tr>';  
                            }
                            
                            mysqli_close($polaczenie);   
                            echo '</tbody>';  
                            echo '</table>';       
                        }             
                    ?>
            </div>
        </article>
    </main>



<?php
    require_once "end.php";
?>


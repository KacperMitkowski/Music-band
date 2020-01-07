<?php
    require_once "beg.php";
?>

    <main>
        <article>
            <div id="content">
                <header>
                    <div class="podnaglowek">Nasz dorobek</div>
                </header>

                <section>
                    <p>Aliquam a rutrum elit, vitae congue dui. Aliquam condimentum vel libero commodo feugiat. Etiam auctor pharetra magna sit amet posuere. Maecenas viverra pretium ornare. Donec at metus feugiat, varius nunc vitae, ullamcorper dolor. Nulla facilisi. Phasellus eget euismod enim, ac scelerisque odio. Nam eu elementum mauris. Nullam ac lobortis metus, quis molestie nisl.</p>
                </section>

                <section>
                    <div style="display: flex; justify-content: space-between; margin-top: 40px;">
                        <div class="song_list">Nazwa płyty
                            <div class="song" onclick="show_song(1)">Piosenka 1</div>
                            <div class="song" onclick="show_song(2)">Piosenka 2</div>
                            <div class="song" onclick="show_song(3)">Piosenka 3</div>
                            <div class="song" onclick="show_song(4)">Piosenka 4</div>
                            <div class="song" onclick="show_song(5)">Piosenka 5</div>
                            <div class="song" onclick="show_song(6)">Piosenka 6</div>
                            <div class="song" onclick="show_song(7)">Piosenka 7</div>
                            <div class="song" onclick="show_song(8)">Piosenka 8</div>
                            <div class="song" onclick="show_song(9)">Piosenka 9</div>
                            <div class="song" onclick="show_song(10)">Piosenka 10</div>
                        </div>

                        <div id="music_header">Wybierz piosenkę by posłuchać
                            <div id="music"></div>
                        </div>
           
                    </div>
                </section>




            </div>
        </article>
    </main>



<?php
    require_once "end.php";
?>


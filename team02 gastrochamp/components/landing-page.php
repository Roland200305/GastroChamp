<!DOCTYPE html>
<html lang="hu">
    <head>
        <?php
            require "functions.php";
            SetCharset("UTF-8");
            InitializeViewport();         
            MakeDevCredits();
            MakeSEOVisibility();
            SetSEOKeywords($kozos_seo_cuccok);
            MakePageDescription();

            CallCSS("../css/nav.css");
            CallCSS("../css/landing-page.css");

            MakePageIcon("../img/site/favicon.svg");
            MakePageTitle("GasztroChamp - A szakácsok közösségi oldala");
        ?>
    </head>
    <body>
        <header>
            <div class="logo">GasztroChamp</div>
            <a href="login.php?landed=1" class="register-btn">Regisztráció</a>
        </header>

        <div class="hero" style="background-image: url('../img/site/hero.png');">
            <div class="hero-content">
                <h1>Üdvözöljük a GasztroChamp-en!</h1>
                <p>A GasztroChamp egy egyedülálló közösségi platform szakácsoknak és főzni szeretőknek. Fedezze fel a kulináris világ titkait, ossza meg receptjeit, és fejlődjön szakácsként!</p>
            </div>
        </div>

        <div class="why-join">
            <h2>Miért éri meg csatlakozni a GasztroChamp-hez?</h2>
            <p>Mert nálunk nem csak recepteket találsz, hanem egy igazi gasztronómiai kalandban is részed lehet! Fejlődj lépésről lépésre, szerezz rangokat, és légy részese egy olyan közösségnek, ahol a főzés szeretete és a versenyszellem összeköt mindenkit!</p>
        </div>

        <div class="features">
            <div class="feature" onclick="showContent('navigation')">
                <h3>Navigáció</h3>
                <p>Egyszerű hozzáférés a profil, receptek és rangok kezeléséhez.</p>
            </div>
            
            <div class="feature" onclick="showContent('recipe-upload')">
                <h3>Receptfeltöltési rendszer</h3>
                <p>Receptek feltöltése hozzávalókkal, fotóval és leírással.</p>
            </div>
            
            <div class="feature" onclick="showContent('points')">
                <h3>Pontozási rendszer</h3>
                <p>Receptek értékelve 1-5 csillagig nehézség alapján.</p>
            </div>
            
            <div class="feature" onclick="showContent('ranks')">
                <h3>Rangrendszer</h3>
                <p>Fejlődési út kezdőtől mesterszakácsig pontgyűjtéssel.</p>
            </div>
            
            <div class="feature" onclick="showContent('admin')">
                <h3>Adminisztrációs rendszer</h3>
                <p>Tartalmak és felhasználók kezelése, moderálása.</p>
            </div>
            
            <div class="feature" onclick="showContent('recipes')">
                <h3>Receptek</h3>
                <p>Böngészhető receptgyűjtemény lépésenkénti elkészítési útmutatóval.</p>
            </div>
        </div>

        <div id="content-container" class="content-container">
            <div class="content-box" id="navigation-content">
                <h2>Navigáció</h2>
                <div class="content-text">
                    <p><strong>Profil</strong><br>
                    A navigáció ezen pontja a profil.php-ra vezet, amely a components mappában található. A profil oldalon megtekintheti a játékos a saját maga által feltöltött recepteket kronológiai sorrendben, vagy az általa megadott szűrők alapján szűrten is akár. Ugyanitt megnézheti, hányan kedvelték a receptjeit, hány pontot hozott ez neki, illetve hogy mennyi kell a következő rang eléréséhez.</p>

                    <p><strong>Mit főzzek ma?</strong><br>
                    Erre a menüpontra kattintva a rendszer ajánlhat a felhasználónak egy receptet, amelyet elkészíthet. Az így elkészített receptekért bónuszpontok is járnak az alapból is az elkészítésért jóváírtak mellett.</p>

                    <p><strong>Recept hozzáadása</strong><br>
                    A navigáció ezen pontja a components mappában található addrecipe.php-ra vezet, ahol a felhasználó feltölthet saját receptet a szükséges adatok bevitelével. A beviteli gomb megnyomása után megtörténik a validáció, amely siker esetén egy értesítést küld a felhasználónak, hogy sikeresen feltöltődött a recept, és a kiszámított nehézség alapján a pontokat is megkapja a felhasználó.</p>

                    <p><strong>Rangsor</strong><br>
                    A navigáció ezen pontja a components mappában lévő rankings.php-ra vezeti a felhasználót, ahol a felhasználó láthatja a legtöbb ponttal/elkészített recepttel/feltöltött recepttel rendelkező felhasználót, illetve a saját maga által elfoglalt pozícióról is képet kaphat ebben a rangsorolásban.</p>

                    <p><strong>Kedvencek</strong><br>
                    Erre a gombra kattintva a felhasználó megtekintheti azon recepteket, amely recepteket kedvelte azoknak megtekintése után. Fontos kiemelni hogy itt is szűrhet kedvére a felhasználó a receptek közt, hogy gyorsabbá, és kényelmesebbé tegye a célirányos keresést.</p>

                    <p><strong>Kezdőlap</strong><br>
                    Ezzel a gombbal navigálhat a felhasználó a kezdő oldalra ahol böngészhet szabadon az összes felhasználók által feltöltött recept közül.</p>

                    <p><strong>Az oldal törzse</strong><br>
                    A kezdőoldalon az oldal törzse a felhasználók által feltöltött ételeket láthatják, amelyeknek adatait az adatbázisból a foods nevű táblával kérdezi le a rendszer beágyazott SQL lekérdezéssel, ami aztán betöltődik egy modern design-nal rendelkező PHP sablonba.</p>
                </div>
            </div>

            <div class="content-box" id="recipe-upload-content">
                <h2>Receptfeltöltési rendszer</h2>
                <div class="content-text">
                    <p><strong>A recept feltöltéséhez szükséges adatok:</strong></p>
                    <ul>
                        <li>Hozzávalók listája</li>
                        <li>Szükséges eszközök listája</li>
                        <li>Fénykép az ételről</li>
                        <li>Leírás (Elkészítési folyamat)</li>
                        <li>Elkészítés költségei</li>
                        <li>Étel kategóriája (vegán, diétás, húsétel, stb.)</li>
                    </ul>
                </div>
            </div>

            <div class="content-box" id="points-content">
                <h2>Pontozási rendszer</h2>
                <div class="content-text">
                    <p><strong>Kritériumok, amelyeket használ az algoritmus:</strong></p>
                    <ul>
                        <li>Hozzávalók száma</li>
                        <li>Eszközök száma</li>
                        <li>Elkészítési idő</li>
                        <li>Lépések száma</li>
                    </ul>
                </div>
            </div>

            <div class="content-box" id="ranks-content">
                <h2>Rangrendszer</h2>
                <div class="content-text">
                    <p><strong>Rangok és ponthatárok:</strong></p>
                    <ul>
                        <li>Abszolút kezdő (0 pont)</li>
                        <li>Alapvető ismeretekkel rendelkező kezdő (30 pont)</li>
                        <li>Alapfokú receptek követője (75 pont)</li>
                        <li>Biztos alapokkal rendelkező szakács (150 pont)</li>
                        <li>Gyakorlott kezdő (300 pont)</li>
                        <li>Mesterszakács (3500 pont)</li>
                    </ul>
                </div>
            </div>

            <div class="content-box" id="admin-content">
                <h2>Adminisztrációs rendszer</h2>
                <div class="content-text">
                    <p><strong>Főbb funkciók:</strong></p>
                    <ul>
                        <li>Felhasználók kezelése</li>
                        <li>Receptek ellenőrzése</li>
                        <li>Moderálás</li>
                        <li>Rendszernapló vezetése</li>
                    </ul>
                </div>
            </div>

            <div class="content-box" id="recipes-content">
                <h2>Receptek</h2>
                <div class="content-text">
                    <p>A felhasználó egy adott ételre kattintva átnavigálásra kerül a recept.php-ra, ahol az adatbázis feltölti annak sablonját az ételhez azonosítóval csatolt receptből származó adatokkal. Ezen az oldalon megtekinthető a recept, és kedvencekhez adható is bármikor.</p>
                </div>
            </div>
        </div>

        <footer>
            <div class="footer-left">
                <p>© <b>GasztroChamp</b> minden jog fenntartva</p>
            </div>
            <div class="footer-right">
                <a href="#">Kezdőlap</a>
                <a href="#">Felhasználási feltételek</a>
                <a href="#">Adatvédelmi szabályzat</a>
            </div>
        </footer>
    </body>
</html>
<?php CallJS("../js/landingpage.js");?>


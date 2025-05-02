<?php
    require "../functions.php";
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <?php SetCharset("UTF-8");
        InitializeViewport();
        CallJS("https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js");
        CallCSS("../../css/termsofuse.css");
        MakePageTitle("Felhasználási feltételek");
        MakePageIcon("../../img/site/favicon.svg");
        ?>
    </head>
    <body>
        <header>
            <?php MakeNav(false); ?>    
        </header>
        <main>
            <h1>Felhasználási feltételek</h1>
            <div class="tou-text">
                <p><strong>Hatályos:</strong> 2025. április 24-től</p>
                <p><strong>Szolgáltató:</strong> GastroChamp fejlesztői csapata</p>
                <p><strong>Webcím:</strong> <a href="https://team02.project.scholaeu.hu/" target="_blank">https://team02.project.scholaeu.hu/</a></p>


                <h2>1. Általános rendelkezések</h2>
                <p>
                    A jelen Felhasználási Feltételek (a továbbiakban: „Feltételek”) a GastroChamp webalkalmazás (a továbbiakban: „Szolgáltatás” vagy „Weboldal”) használatára vonatkoznak. A Szolgáltatás használata regisztrációhoz kötött, és a regisztrációval, illetve a Weboldal bármely funkciójának használatával a felhasználó (a továbbiakban: „Felhasználó”) elfogadja a jelen Feltételekben foglaltakat.
                </p>

                <h2>2. A szolgáltatás célja és működése</h2>
                <p>
                    A GastroChamp egy közösségi platform, amely lehetőséget biztosít hobbiszakácsok számára receptek feltöltésére, megosztására, értékelésére, valamint a közösségi aktivitás mérésére pont- és rangrendszer segítségével. A platform célja, hogy támogassa a minőségi, inspiráló tartalmak megosztását, és ösztönözze a felhasználók aktivitását.
                </p>

                <h2>3. Regisztráció és felhasználói fiók</h2>
                <ul>
                    <li>A Szolgáltatás használata regisztrációhoz kötött. A regisztráció során a felhasználónak egyedi felhasználónevet, érvényes e-mail címet és jelszót kell megadnia.</li>
                    <li>Emellett a felhasználóról eltárol a böngésző egyfajta azonosítót, amely az alkalmazás működéséhez szükséges.</li>
                    <li>A felhasználó köteles valós adatokat megadni, és felelős a fiókja biztonságáért.</li>
                    <li>A jelszavak biztonságos, titkosított formában kerülnek tárolásra.</li>
                    <li>A felhasználó köteles a fiókjához tartozó jelszót titokban tartani, és minden, a fiókjával végzett tevékenységért felelősséggel tartozik.</li>
                </ul>

                <h2>4. Felhasználói szerepkörök</h2>
                <ul>
                    <li><strong>Egyszerű felhasználó:</strong> Alapvető funkciókhoz fér hozzá (receptek feltöltése, értékelése, kedvencek kezelése, rangsor).</li>
                    <li><strong>Adminisztrátor:</strong> Jogosult a beküldött receptek és próbálkozások elbírálására, admin jogkörök kiosztására, automata admin rendszer bővítésére. A felhasználási feltételek megszegése esetén az automata admin rendszer megfosztja ettől a rangtól az illetőt.</li>
                    <li><strong>Szuperadmin:</strong> Minden adminisztrátori jogkörrel rendelkezik, admin jogkör elvétele vagy kiosztása kizárólag számára lehetséges.</li>
                </ul>

                <h2>5. Felhasználói tartalom és moderáció</h2>
                <ul>
                    <li>A felhasználók kizárólag saját, eredeti tartalmat tölthetnek fel (receptek, képek).</li>
                    <li>A feltöltött képek csak meghatározott formátumokban (png, jpeg, jpg, gif, webp) engedélyezettek.</li>
                    <li>Tilos jogsértő, sértő, trágár, kártékony, vagy másokat bántó tartalom feltöltése.</li>
                    <li>A receptek feltöltése automatikus, majd manuális adminisztrátori ellenőrzésen megy keresztül. A szabályszegő tartalmakat a Szolgáltató eltávolíthatja, a szabályszegő felhasználókat figyelmeztetheti és büntetheti adott esetben pedig ideiglenesen vagy véglegesen letilthatja.</li>
                </ul>

                <h2>6. Pontozási és rangrendszer</h2>
                <ul>
                    <li>A felhasználók aktivitását algoritmus értékeli: a receptek összetettsége (hozzávalók, eszközök, elkészítési idő, lépések száma) alapján pontokat kapnak, amelyeket a rendszer automatikusan számol ki.</li>
                    <li>A pontok alapján a felhasználók különböző rangokat érhetnek el (Tanulóséf, Fakanálforgató, Bronz, Ezüst, Arany, Gyémánt, Mester, Nagymester).</li>
                    <li>A rangokhoz és kitüntetésekhez szükséges ponthatárok dinamikusan változnak a közösség aktivitásának függvényében.</li>
                </ul>

                <h2>7. Tiltott magatartások</h2>
                <ul>
                    <li>Tilos a szolgáltatás visszaélésszerű, automatizált, vagy a rendszer megkerülésére irányuló használata.</li>
                    <li>Tilos más felhasználók zaklatása, megtévesztése, vagy a közösség működésének szándékos zavarása.</li>
                    <li>Tilos pontszerzési vagy rangszerzési célból csalni, hamis adatot feltölteni, vagy a rendszer működését befolyásolni.</li>
                    <li>A rendszer automata admin modulja figyeli a szabálysértéseket, és büntetőpontokat oszt ki, amelyek felhalmozása ideiglenes vagy végleges tiltáshoz vezethet.</li>
                </ul>

                <h2>8. Adatvédelem</h2>
                <p>
                    A Szolgáltató a felhasználók személyes adatait a mindenkor hatályos jogszabályok, valamint a GastroChamp Adatvédelmi Szabályzata szerint kezeli. Az adatkezelés részleteit külön dokumentum tartalmazza.
                </p>

                <h2>9. Felelősségkorlátozás</h2>
                <ul>
                    <li>A Szolgáltató mindent megtesz a szolgáltatás biztonságos működéséért, de nem vállal felelősséget az esetleges adatvesztésért, üzemzavarért, vagy harmadik fél általi visszaélésért.</li>
                    <li>A Szolgáltató nem felel a felhasználók által feltöltött tartalmakért, azok jogszerűségéért, helyességéért vagy minőségéért.</li>
                </ul>

                <h2>10. Szellemi tulajdon</h2>
                <ul>
                    <li>A Weboldal, annak teljes tartalma, szerkezete, logója, designja, valamint a fejlesztett funkciók szerzői jogvédelem alatt állnak.</li>
                    <li>A felhasználók által feltöltött receptek és képek szerzői jogai a feltöltőnél maradnak, de a feltöltéssel a felhasználó nem kizárólagos, visszavonhatatlan felhasználási jogot ad a Szolgáltatónak a tartalom oldalán történő megjelenítésére.</li>
                </ul>

                <h2>11. A feltételek módosítása</h2>
                <ul>
                    <li>A Szolgáltató jogosult a Feltételeket egyoldalúan módosítani. A módosításról a felhasználókat az oldalon keresztül értesíti. A módosítás a közzététel napján lép hatályba. A felhasználó köteles a Feltételeket rendszeresen áttekinteni.</li>
                </ul>

                <h2>12. Jogorvoslat, panaszkezelés</h2>
                <ul>
                    <li>A felhasználók bármilyen panasszal, észrevétellel, vagy jogsértés gyanújával a Szolgáltatót az oldalon keresztül értesíthetik.</li>
                    <li>A Szolgáltató minden beérkező panaszt 30 napon belül kivizsgál, és választ ad a felhasználónak.</li>
                </ul>

                <h2>13. A szerződés megszűnése</h2>
                <ul>
                    <li>A felhasználó bármikor törölheti fiókját, ezzel a szerződés automatikusan megszűnik.</li>
                    <li>Súlyos szabálysértés esetén a Szolgáltató jogosult a felhasználói fiók azonnali törlésére.</li>
                </ul>

                <p>
                    A GastroChamp szolgáltatás használatával Ön elfogadja a fenti Felhasználási Feltételeket. Kérdés vagy jogvita esetén a Szolgáltatóval történő egyeztetés az elsődleges, jogvita esetén a magyar bíróságok illetékesek.
                </p>
                <p>
                    Jelen Felhasználási Feltételek 2025. április 24-én lépnek hatályba, és visszavonásig érvényesek.
                </p>
            </div>
        </main>
        <?php MakeFooter(false); ?>
    </body>
</html>

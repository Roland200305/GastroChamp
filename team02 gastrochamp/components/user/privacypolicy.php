<?php
    require "../functions.php";
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
		<?php
			MakePageIcon("../../img/site/favicon.svg");
		?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../../css/svg.css">
        <link rel="stylesheet" href="../../css/seged.css">
        <link rel="stylesheet" href="../../css/privacypolicy.css">
        <link rel="stylesheet" href="../../css/<?=$nav_and_colors?>">
        <title>Adatvédelmi szabályzat</title>
    </head>
    <body>
        <header>
            <?php MakeNav(false); ?>    
        </header>
        <main>
            <h1>Adatvédelmi szabályzat</h1>
            <div class="pp-text">
                <p>
                <strong>Hatályos:</strong> 2025. április 24-től
                </p>
                    A jelen Adatvédelmi Szabályzat célja, hogy részletesen ismertesse, hogyan kezeli a GastroChamp (elérhető: <a href="https://team02.project.scholaeu.hu/">https://team02.project.scholaeu.hu/</a>) webalkalmazás az Ön személyes adatait, hogyan gondoskodik azok védelméről, és milyen jogok illetik meg Önt a személyes adatai kapcsán.
                </p>
                <h2>1. Az adatkezelő adatai</h2>
                <ul>
                    <li>Adatkezelő neve: GastroChamp fejlesztői csapata</li>
                    <li>Elérhetőség: <a href="https://www.messenger.com/t/100012115091979/">Vezető fejlesztő</a> , <a href="https://www.messenger.com/t/100012115091979#">Társfejlesztő</a>
                    </li>
                    <li>Képviselő: Tóth Roland, Szabó Szebasztián</li>
                </ul>
                <h2>2. Az adatkezelés célja és jogalapja</h2>
                <p>
                    A GastroChamp kizárólag a szolgáltatás működtetéséhez, a felhasználói élmény biztosításához, a közösségi funkciók (receptfeltöltés, pontozás, rangrendszer, kedvencek, értesítések) működéséhez, valamint a jogszerűség és biztonság fenntartásához szükséges személyes adatokat kezeli. Az adatkezelés jogalapja az Ön önkéntes hozzájárulása (regisztráció során), illetve bizonyos esetekben az adatkezelő jogos érdeke (pl. visszaélések megelőzése, jogi kötelezettségek teljesítése).
                </p>
                <h2>3. A kezelt adatok köre</h2>
                <ul>
                    <li><strong>Regisztrációs adatok:</strong>
                        <ul>
                            <li>Egyedi felhasználónév</li>
                            <li>E-mail cím</li>
                            <li>Jelszó (hash-eléssel titkosítva tárolva)</li>
                        </ul>
                    </li>
                    <li><strong>Profiladatok:</strong>
                        <ul>
                            <li>Feltöltött receptek, képek (csak a felhasználó által önkéntesen megadott tartalom)</li>
                            <li>Kedvencek, pontok, rangok, kitüntetések</li>
                        </ul>
                    </li>
                    <li><strong>Technikai adatok:</strong>
                        <ul>
                            <li>Működéshez szükséges böngészőadatok (cookie-k)</li>
                            <li>Bejelentkezési időpontok, aktivitási naplók</li>
                        </ul>
                    </li>
                    <li><strong>Adminisztrációs adatok:</strong>
                        <ul>
                            <li>Moderációs tevékenységek, szankciók naplózása</li>
                        </ul>
                    </li>
                    <li><strong>Feltöltött fájlok:</strong>
                        <ul>
                            <li>Kizárólag képfájlok (.png, .jpeg, .jpg, .gif, .webp)</li>
                            <li>Feltöltött képek metaadatai (fájlméret, típus)</li>
                        </ul>
                    </li>
                </ul>
                <p>
                    A szolgáltatás nem kér és nem kezel különleges adatokat (pl. egészségi állapotra, vallásra, politikai véleményre utaló információkat).
                </p>
                <h2>4. Az adatkezelés módja és biztonsága</h2>
                <ul>
                    <li><strong>Adatbázis-védelem:</strong> Az adatok egy védett MySQL adatbázisban kerülnek tárolásra. Minden adatlekérdezés védett SQL Injection támadások ellen.</li>
                    <li><strong>Jelszótitkosítás:</strong> A jelszavakat soha nem tároljuk olvasható formában; minden jelszó hash-elve, titkosítva kerül mentésre.</li>
                    <li><strong>Fájlok szűrése:</strong> Csak képfájlok tölthetők fel, más típusú vagy potenciálisan káros fájlok feltöltése automatikusan tiltott.</li>
                    <li><strong>Automata Admin Rendszer:</strong> A rendszer automatikusan szűri a nem megfelelő szöveges tartalmakat, és visszaélés esetén büntetőpontokat oszt ki, illetve szükség esetén tiltja a fiókokat.</li>
                    <li><strong>Adminisztrátori hatáskör:</strong> Az adminok kizárólag a felhasználók által feltöltött tartalmakhoz férnek hozzá, illetve az automata admin rendszer által használt adatokhoz. Tevékenységük részletesen naplózova van.</li>
                </ul>
                <h2>5. Az adatok tárolásának időtartama</h2>
                <ul>
                    <li><strong>Felhasználói adatok:</strong> A regisztrációval létrejött adatokat a felhasználói fiók törléséig, vagy a szolgáltatás megszűnéséig tároljuk.</li>
                    <li><strong>Moderációs naplók, szankciók:</strong> Ezeket az adatokat a jogi kötelezettségek teljesítéséhez szükséges ideig, de maximum 5 évig őrizzük meg.</li>
                    <li><strong>Feltöltött képek:</strong> A képek a recept vagy próbálkozás törléséig, vagy a fiók megszűnéséig maradnak az adatbázisban.</li>
                </ul>
                <h2>6. Adattovábbítás, adatfeldolgozók</h2>
                <p>
                    A GastroChamp nem adja át a felhasználók személyes adatait harmadik félnek, kivéve jogszabályi kötelezettség vagy hatósági megkeresés esetén. Az adatokat kizárólag a szolgáltatás működtetéséhez szükséges technikai partnerek (pl. tárhelyszolgáltató) kezelik, akik szintén kötelesek betartani a jelen szabályzatban foglaltakat.
                </p>
                <h2>7. Felhasználói jogok</h2>
                <ul>
                    <li><strong>Hozzáférés joga:</strong> Tájékoztatást kérhet az Önről tárolt adatokról.</li>
                    <li><strong>Helyesbítés joga:</strong> Kérheti a pontatlan adatok javítását.</li>
                    <li><strong>Törléshez való jog:</strong> Kérheti adatai törlését ("elfeledtetéshez való jog"), kivéve, ha jogszabály másként rendelkezik.</li>
                    <li><strong>Adatkezelés korlátozása:</strong> Kérheti az adatkezelés korlátozását bizonyos esetekben.</li>
                    <li><strong>Tiltakozás joga:</strong> Jogos érdeken alapuló adatkezelés ellen tiltakozhat.</li>
                    <li><strong>Adathordozhatóság:</strong> Kérheti adatai géppel olvasható formátumban történő kiadását.</li>
                </ul>
                <p>
                    A jogok gyakorlásához kérjük, vegye fel a kapcsolatot az adatkezelővel a fenti elérhetőségek valamelyikén.
                </p>
                <h2>8. Sütik (cookie-k) és követés</h2>
                <p>
                    A GastroChamp csak a működéshez elengedhetetlen technikai sütiket használja (pl. munkamenet-azonosító), amelyek nélkülözhetetlenek a bejelentkezéshez és az oldal megfelelő működéséhez. Harmadik féltől származó, marketing vagy analitikai célú sütiket nem alkalmazunk.
                </p>
                <h2>9. Kiskorúak adatainak védelme</h2>
                <p>
                    A szolgáltatás használata 16 éven aluliak számára csak szülői vagy törvényes képviselői hozzájárulással engedélyezett. Amennyiben tudomásunkra jut, hogy 16 éven aluli személy adatait szülői hozzájárulás nélkül kezeltük, azokat haladéktalanul töröljük.
                </p>
                <h2>10. Adatvédelmi incidensek kezelése</h2>
                <p>
                    Az adatkezelő minden tőle elvárhatót megtesz az adatok biztonsága érdekében. Adatvédelmi incidens esetén haladéktalanul értesítjük az érintetteket és a hatóságokat a jogszabályoknak megfelelően.
                </p>
                <h2>11. Jogorvoslat</h2>
                <p>
                    Amennyiben Ön úgy véli, hogy az adatkezelés nem felel meg a jogszabályoknak, panasszal élhet az illetékes Nemzeti Adatvédelmi és Információszabadság Hatóságnál (NAIH), vagy bírósághoz fordulhat.
                </p>
                <h2>12. Szabályzat módosítása</h2>
                <p>
                    Az adatvédelmi szabályzatot az adatkezelő bármikor jogosult módosítani. Jelentős változás esetén a felhasználókat előzetesen értesítjük.
                </p>
                <p>
                    Kérdés, észrevétel vagy joggyakorlás esetén kérjük, vegye fel velünk a kapcsolatot az oldalon keresztül!
                </p>
                <p>
                    Jelen szabályzat a GastroChamp működésére és adatkezelésére vonatkozik, és megfelel a magyar és európai uniós (GDPR) adatvédelmi előírásoknak.
                </p>
                <br>
            </div>
        </main>
        
        <?php MakeFooter(false); ?>
    </body>
</html>

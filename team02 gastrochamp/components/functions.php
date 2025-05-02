<?php
    //-------------------Adatbázis------------------//
    //Adatbázis bekötés
    $conn=new mysqli("localhost","team02","yh5K9tgnXISSjJWMUwkJ","team02");
    if($conn->connect_error){
        die("Hiba"+$conn->connect_error);
    }


    function DBSafeSearch($table, $where = '', $params = []) {
        global $conn;
        // Feltételes WHERE rész
        $sql = "SELECT * FROM `$table`";
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lekérdezés hiba: " . $conn->error);
        }
    
        // Típusok automatikus meghatározása a paraméterek alapján
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i'; // integer
                } elseif (is_double($param) || is_float($param)) {
                    $types .= 'd'; // double
                } elseif (is_string($param)) {
                    $types .= 's'; // string
                } elseif (is_null($param)) {
                    $types .= 's'; // kezeljük a NULL-ot is
                }
            }
            $stmt->bind_param($types, ...$params); // Paraméterek kötése a típusokkal
        }
    
        $stmt->execute();
        return $stmt->get_result();// 0 ha nem talál semmit, minimum egy rekord esetén pedig 1.
    }

    function DBSafeInsert($table, $values) {
        global $conn;
    
        if (!is_array($values)) {
            throw new Exception("A bemeneti adatokat indexelt tömbként kell megadni.");
        }
    
        $placeholders = implode(", ", array_fill(0, count($values), "?"));
        $sql = "INSERT INTO $table VALUES ($placeholders)";

        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Hiba a lekérdezés előkészítésekor: " . $conn->error);
        }
    
        // Típusok meghatározása
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_double($value)) {
                $types .= 'd';
            } elseif (is_null($value)) {
                // NULL is stringként lesz kezelve, különben hibát dobhat
                $types .= 's';
            } else {
                $types .= 's'; // default: string
            }
        }
    
        // bind_param csak referenciákat fogad, így készítsük el a referenciák tömbjét
        $bindParams = [];
        $bindParams[] = $types;
        foreach ($values as &$val) {
            $bindParams[] = &$val;
        }
    
        call_user_func_array([$stmt, 'bind_param'], $bindParams);
    
        $stmt->execute();
        $stmt->close();
    }

    function DBSafeUpdate($table,  $set = '',$where = '', $params = []) {
        global $conn;
    
        $sql = "UPDATE `$table`";
        if (!empty($set)) {
            $sql .= " SET $set";
        }
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
    
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lekérdezés előkészítési hiba: " . $conn->error);
        }
    
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_double($param) || is_float($param)) {
                    $types .= 'd';
                } elseif (is_string($param)) {
                    $types .= 's';
                } elseif (is_null($param)) {
                    $types .= 's';
                }
            }
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        // 0 ha nem változott egy rekord sem, ellenkező esetben a megváltoz rekordok száma
        return $stmt->affected_rows; 
    }

    function DBSafeDelete($table, $where='', $params=[]){
        // Feltételes WHERE rész
        global $conn;
        $sql = "DELETE FROM `$table`";
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lekérdezés hiba: " . $conn->error);
        }
    
        // Típusok automatikus meghatározása a paraméterek alapján
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i'; // integer
                } elseif (is_double($param) || is_float($param)) {
                    $types .= 'd'; // double
                } elseif (is_string($param)) {
                    $types .= 's'; // string
                } elseif (is_null($param)) {
                    $types .= 's'; // kezeljük a NULL-ot is
                }
            }
            $stmt->bind_param($types, ...$params); // Paraméterek kötése a típusokkal
        }
    
        $stmt->execute();
        return $stmt->affected_rows;
    }

    function DBSearch($where){global $conn; return $conn->query("SELECT * FROM $where");}
    //------------------!Adatbázis------------------//
   
    //------------------Sütik kezelése--------------//

    function CancelCookie($cookiename){setcookie("$cookiename","",time()-1000,"/"); }//süti törlése

    function MakeCookie($cookiename, $cookievalue,$time){

    }
    function CheckCookie($cookie, $value){

    }

    //------------------!Sütik kezelése---------------//



    //------------------Globális változók-----------//
    $jelenlegi_ido=date("Y-m-d H:i:s",time());
    $rangok=array("Tanulóséf" => 0 , "Fakanálforgató" => 5, "Serpenyőmágus" => 10, "Konyhatündér" => 15, "Ízmester"=> 20, "Konyhafőnök" => 25, "Gasztroguru"=>50, "Legendás"=> 100 );
    $kozos_seo_cuccok = "GastroChamp, receptek, főzés, egyszerű vacsora receptek, gyors ebéd ötletek, olcsó egytálételek, húsmentes receptek, rakott ételek, házi sütemények, mentes receptek, mit főzzek ma";
        $elfogadott_formatumok=["image/jpg", "image/jpeg", "image/png", "image/gif", "image/webp"];

    if(isset($_COOKIE["dark_mode_enabled_by"]) && $_COOKIE["dark_mode_enabled_by"]==$_COOKIE["id"]){
        $nav_and_colors="nav-darkmode.css";
    }
    else{ $nav_and_colors="nav.css";}
    
    $rate=5;//az algoritmusok által a csillagozáshoz használt hányados
    $kategoriamennyiseg=mysqli_num_rows(DBSafeSearch("categories","",[]));
    $oszto=$kategoriamennyiseg/2;
    //A kategóriák számával arányosan nő egy egy adott rang alsó és felső ponthatára
    $novekedesi_szorzo=intval(($kategoriamennyiseg/$oszto)*$kategoriamennyiseg);
    //-----------------!Globális változók-----------//

    //-----------------Head felépítése-----------------//
    function MakeDevCredits(){ echo "<meta name='author' content='Tóth Roland, Szabó Szebasztián'>"; }

    function MakeSEOVisibility(){ echo"<meta name='robots' content='index, follow'>"; }

    function SetSEOKeywords($keywords){ echo"<meta name='keywords' content='$keywords'>"; }

    function MakePageDescription(){ echo"<meta name='description' content='Több száz gyors, egyszerű és házias recept egy helyen. Főzz velünk a GastroChamp oldalán!'>"; }

    function SetCharset($charset){ echo "<meta charset='$charset'>"; }

    function InitializeViewport(){ echo"<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; }

    function MakePageIcon($path){ echo"<link rel='icon' type='image/x-icon' href='$path'>"; }

    function CallCSS($css_path){ echo "<link rel='stylesheet' type='text/css' href='$css_path'>"; }
    
    function CallJS($text){ echo'<script src="'.$text.'"></script>'; }

    function MakePageTitle($title){ echo"<title>$title</title>"; } 
    //-----------------!Head felépítése, külső elemek behívása-----------------//

    //------------Képernyőolvasó kompatibilitás---------------------------//
    function MakeAccessibilityTag($text){
        return "aria-label='$text'";
    }
    //-----------!Képernyőolvasó kompatibilitás---------------------------//

    //------------SVG-k-----------//
    function MakeIcon($text){
        $ikon=DBSafeSearch("icons", "name=?", [$text])->fetch_assoc();
        if($ikon["description"]=="echo"){
            echo $ikon["svgcode"];
        }
        else{
           return $ikon["svgcode"];
        } 	
    }
    //------------!SVG-k-----------//

    function WhoIsIt($id){return DBSafeSearch("users","id = ?",[$id])->fetch_assoc();}
     
    //---------------------JS értesítés------------------------------//
    function Message($text){echo'<script>alert("'.$text.'")</script>';}
    //--------------------!JS értesítés------------------------------//

    function Validate($isindex){
        //Felhasználó bejelentkezett és nincs e rá kiszabott tiltás érvényben
        if(isset($_COOKIE["id"]) && !CheckForUserBans($_COOKIE["id"])){
            UpdateUserRank($_COOKIE["id"],null);
            return $_COOKIE["id"];
            
        }

        else{
            if($isindex){
                header("Location: components/login.php");    
            }
            else{
                header("Location: ../login.php");
            }
        }
    }
    //---------------------Csillagos szűrők-------------------------//
    function MakeStars(){
        for($i=1; $i<6;$i++) {
            echo"<div ".MakeAccessibilityTag("$i csillagos receptek")." class='szurok s'>$i ".MakeIcon("Star")."</div>";
        }
    }
    //--------------------!Csillagos szűrők-------------------------//

    function AddNotificationAnimation($elem,$what){
        $szam=mysqli_num_rows(DBSafeSearch("notifications", "userid=? AND seen=?", [$_COOKIE["id"],0]));
        
        
    }
    function MakeAdminButtons(){
        
    }

    //-----------------------------Felhasználói navigációs menü------------------------//
    function MakeNav($isindex){
        global $conn;
        $user=DBSafeSearch("users","id = ?",[$_COOKIE["id"]])->fetch_assoc();
        $random=rand(1,mysqli_num_rows(DBSafeSearch("recipe","ok = ?", [1])));
        //Az indexről vagy a user mappából navigálást segítő változók
        $index = $isindex ? "" : "../../";
        $toComponents = $isindex ? "components/user/" : "";
        $imglink = $isindex ? "img/site/" : "../../img/site/";
        
        //Jött e értesítés?
        echo
                '<nav>
                    <a id="profile" '.MakeAccessibilityTag("Profil").' href="'.$toComponents.'profile.php?userid=' . $_COOKIE["id"] . '">
                        <div class="profile-photo"  style="background-image: url('.$imglink.'' . $user["pic"] . ');"></div>
                        <span><span style="margin-top: -2px;">' . $user["username"] . '</span>
                        <span style="font-size: .8em; text-align: start;">' . $user["rank"] . ' <br> ' . $user["points"] . ' pont</span></span>
                    </a>
                    <a href="'.$toComponents.'savedrecipes.php" class="right" id="liked"'.MakeAccessibilityTag("Mentett receptek").'>' . MakeIcon("Favourite") . '<span>Kedvencek</span></a>
                    <a href="'.$toComponents.'addrecipe.php" id="add" class="add-new"'.MakeAccessibilityTag("Recept hozzáadása").'>' . MakeIcon("Add") . '</a>
        
                    <a href="'.$toComponents.'rankings.php?userid='.$_COOKIE["id"].'" class="right" id="rankings"'.MakeAccessibilityTag("Rangsor").'>' . MakeIcon("Ranking") . '<span>Rangsor</span></a>
                    <a href="'.$index.'index.php" class="right" id="home"'.MakeAccessibilityTag("Kezdőlap").'>' . MakeIcon("House") . '<span>Kezdőlap</span></a>
                </nav>';
    }
    //-----------------------------!Felhasználói navigációs menü------------------------//

    //--Csillagos értékelések betöltése--//
    function Rating($num){
        global $rate;
        for($i=0; $i<intval($num/$rate);$i++){
           echo MakeIcon("Star");
        }
    }
    //-!Csillagos értékelések betöltése--//
   
    function MakeTag($text){
        echo "<li class='szurok'>$text</li>";
    }
    function MakeTagSelector($text, $id, $name){
        global $conn;
        if($name=="ingredients[]"){
            $class="in";    
        }
        else if($name=="tools[]"){
            $class="to";
        }
        else{
            $class="t";
        }
        if($name!="tagek[]"){echo"<div class='selector $class' style='width: min-content'>";}
        echo"<input type='checkbox' value='$text' name='$name' id='$id' class='hidden-cb'>";
        echo"<label class='szurok' for='$id'>$text</label>";
        if($name=="ingredients[]"){
            
            $osszetevo=DBSafeSearch("ingredients", "name =?", [$text])->fetch_assoc();
            $margo=65+strlen($osszetevo["scale"])*9;
            echo"<div class='mennyisegek'><input type='number' length='4' min='0' name=scales[$text]><label style='width:min-content; margin-right: -".$margo."px;'class='scale' for='num-$text'>$osszetevo[scale]</label></div>";
        }
        if($name!="tagek[]"){echo"</div>";}
    }
    function MakeFooter($isindex){
        $index = $isindex ? "" : "../../";
        $egyeb = $isindex ? "components/user/" : "";
        echo'
        <footer>
            <a href="'.$index.'index.php" class="footer">Kezdőlap</a>
            <a href="'.$egyeb.'termsofuse.php" class="footer">Felhasználási feltételek</a>
            <a href="'.$egyeb.'privacypolicy.php" class="footer">Adatvédelmi szabályzat</a>    
        </footer>';
    }

    function MakeAdmin($userid){
        $user=WhoIsIt($userid);
        Validate(false);
        if($user["isadmin"] != 0 && isset($_GET["adminid"])){
            setcookie("adminid",$user["id"], time()+86400,"/");
        }
        else{
            IsAdmin();  // => components/functions.php (184)
        }

    }
    // Adminjog elvétele
    function RemoveFromAdmins($userid,$remover){
        $admin=DBSafeSearch("users", "id = ?", [$userid])->fetch_assoc();
        if($admin["adminid"]!=1){
            DBSafeUpdate("users", "isadmin=? ", "id =?", [0,$userid]);
        }
        DBSafeInsert("logs", [NULL, $remover, "admin downgrade", "$jelenlegi_ido",$userid, "Lefokozva adminról egyszerű felhasználóvá"]);
    }
    function Isadmin(){
        if(!isset($_COOKIE["adminid"])){
            header("Location: ../../index.php");
        }   
    }
    function MakeAdminNav(){
        global $conn;
        $user=DBSafeSearch("users","id = ?",[$_COOKIE["id"]])->fetch_assoc();
        $mappa="../admin/";
        echo
            '<nav>
                <a href="../../index.php" style="height:100%;">';echo MakeIcon("Vissza"); echo'<span>Felületváltás</span></a>
                <a href="'.$mappa.'users.php" class="right" id="users">'.MakeIcon("User").'<span>Felhasználók</span></a>
                <a href="'.$mappa.'uploadedrecipes.php" class="right" id="uploads">'.MakeIcon("Upload").'<span>Receptek</span></a>
                <a href="'.$mappa.'uploadedtries.php" class="right" id="tries">'.MakeIcon("Eye").'<span>Próbálkozások</span></a>
                <a href="'.$mappa.'admin.php" class="right" id="home">'.MakeIcon("House").'<span>Főpanel</span></a>

                </nav>';
        
    }

    function GetTimeElapsed($time){//ez a függvény stringként kér be egy dátumot és címkézi az azóta eltelt időt
        $elteltmp=time()-strtotime($time,time()); 
        $perc=60;
        $nap=$perc**2*24;
        $het=7*$nap;
        $honap=4*$het; //minden hónap ~4 teljes hetet tartalmaz 
        $ev=12*$honap;
        
        switch(true){ // címke elkészítése, attól függően melyik nagyságrendi kategóriába esik az eltelt idő
            case $elteltmp<$perc:
                return $elteltmp." másodperce";
                break;
            case $elteltmp<$perc**2:
                return intval($elteltmp/$perc)." perce";
                break;
            case $elteltmp<$nap:
                return intval($elteltmp/$perc**2)." órája";
                break;
            case $elteltmp<$het:
                return intval($elteltmp/$nap)." napja";
                break;
            case $elteltmp<$honap:
                return intval($elteltmp/$het)." hete";
                break;
            case $elteltmp<$ev:
                return intval($elteltmp/$honap)." hónapja";
                break;
            default:
                return intval($elteltmp/$ev)." éve";
                break;
        }
        
    }
    
    //--------------------Csempék generálása---------------------//
    function MakeFoodTiles($isindex,$kedvencei){ //$isindex => a kezdőoldalon található e legenerálandó elem?
        //Saját kedvencek, Más kedvencei, Felhasználó ételei, Index ételek
        global $conn;
        if($kedvencei){//Ha valamely felhasználó kedvenc receptjeit nézzük
            if(!isset($_GET["userid"])){
                //Saját kedvencek
                $talalt_kedvencek=DBSafeSearch("likes","userid = ?",[$_COOKIE["id"]]);    
                if(mysqli_num_rows( $talalt_kedvencek)==0){ //Ha nincs kedvence az éppen bejelentkezett FH-nak
                    echo '<h1 style="padding-top: 50px;">Még nincsenek kedvenc ételeid...</h1><a class="btn" href="../../index.php"><h2>Találj párat!</h2></a>';
                }else{
                    while($talalt_kedvenc=$talalt_kedvencek->fetch_assoc()){
                        $talalt_etel = DBSafeSearch("foods","id = ? AND ok = ?", [$talalt_kedvenc["recipeid"],1])->fetch_assoc();
                        MakeATile($talalt_etel,$isindex);//Étel csempéjének legenerálása
                    }
                }
            }
            else{
                //Más kedvencei
                $talalt_kedvencek=DBSafeSearch("likes","userid = ?",[ $_GET["userid"]]);
                if(mysqli_num_rows( $talalt_kedvencek)==0){ // Ha nincs kedvence az adott FHnak
                    echo '<h1 style="padding-top: 50px;">Ennek a felhasználónak még nincsenek kedvenc ételei...</h1>';
                }else{
                    while($talalt_kedvenc=$talalt_kedvencek->fetch_assoc()){
                        $talalt_etel = DBSafeSearch("foods","id = ? AND ok=?",[$talalt_kedvenc["recipeid"],1])->fetch_assoc();
                        MakeATile($talalt_etel,$isindex); //Étel csempéjének legenerálása
                    }
                }
            }
        }
        else{
            if(isset($_GET["userid"])){//Adott profil által feltöltött ételek
                $talalt_etelek=DBSafeSearch("foods","ok=? AND uploaderid =?", [1,$_GET["userid"]]);
                if(mysqli_num_rows($talalt_etelek)==0){
                    echo"<h1 style='padding-top: 50px;'>Ez a felhasználó még nem töltött fel recepteket...</h1>";
                }
            }
            else{//Index
                $talalt_etelek=DBSafeSearch("foods","ok=?",[1]);
            }
            
            while($talalt_etel=$talalt_etelek->fetch_assoc()){
                MakeATile($talalt_etel,$isindex); //Étel csempéjének legenerálása
            }
        }
        
    }
    //-------------------!Csempék generálása---------------------//

    //-------------------Csempe sablon---------------------------//
    function MakeATile($etel,$isindex){//$isindex => a kezdőoldalon található-e legenerálandó elem?
        global $rate;
        $path = $isindex ? "components/user/" : "";//a hivatkozás célja a legenerálandó elem helyétől függ.
        $url = $isindex ? "":"../../"; //a kép elérési útja is.
        //$etel => átadott étel [asszociatív tömb]   
        $diff=intval($etel["difficulty"]/$rate);//hány * nehézségű az adott étel -> JS használja ezt!!
        //csempe befoglaló négyzete, lekerekített sarokkal, és ízlésesen sötétített háttérképpel
        echo"<a class='tile' href='$path"."recipe.php?recipeid=$etel[id]' category='$etel[tags]' difficulty='$diff'
         style='background-image: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.75)), 
         url($url"."img/uploads/$etel[img]');>";
        //az étel neve
         echo"<div class='foodname'>
            $etel[name]
        </div>";
        echo"<div class='foodrating'>";
            Rating($etel["difficulty"]);// Csillagos értékelés az étel nehézsége alapján
            echo"</div>
                <div class='foodtags'>";
                    $tagek = explode(' ', $etel["tags"]);
                    for($i=0; $i<count($tagek); $i++) {  
                        echo"<div class='tag'>$tagek[$i]</div>"; //Az ételek kategóriáinak hozzáadása AB-ból
                    }     
           echo"</div>
        </a>";

    }
    //------------------!Csempe sablon--------------------------//
    
    function BanFoodAndRecipe($foodid){
        $recipe=DBSafeSearch("recipe","foodid = ?", [$foodid])->fetch_assoc();
        $food=DBSafeSearch("foods","id = ?",[$recipe["foodid"]])->fetch_assoc();
        $uploader=DBSafeSearch("users","id = ?",[$food["uploaderid"]])->fetch_assoc();
        $likes=DBSafeSearch("likes", "recipeid=?", [$recipeid]);
        while($like=$likes->fetch_assoc()){
            SendNotificationForUser($like["userid"],"Az egyik általad kedvelt étel sajnos sértette a Felhasználási feltételeket, így kénytelenek voltunk eltávolítani.",0);
        }
        DBSafeDelete("likes", "recipeid = ?", [$recipe["id"]]);
        DBSafeUpdate("foods", "ok = ?", "id =?",[-1, $food["id"]]);
        DBSafeUpdate("recipe", "ok = ?", "id =?",[-1, $recipe["id"]]);
        DBSafeUpdate("reports", "ok = ?", "recipeid = ?",[-1,$_GET["recipeid"]]);

    }
    
    //------Oldal tetején elhelyezkedő szűrők betöltése---------//
    function MakeFilters(){ 
        global $conn;
        echo"
        <div class='top'>
            <div class='topside'>
                <div class='arrow' id='scroll-left'><</div>
                <div class='scrolling-menu'>
                    <ul class='tagek'>";  
                        $talalatok=DBSafeSearch("categories","",[]);// =>components/functions.php /SELECT * FROM categories  /
                        while($talalat=$talalatok->fetch_assoc()) { 
                            MakeTag($talalat["catname"]); // => components/functions.php (156)
                        } 
                echo"</ul>
                </div>
            <div class='arrow' id='scroll-right'>></div>
            </div>
        </div>
        <hr>
        <div class='stars'>";
            MakeStars();     
        echo"</div>";
    }
    //-----!Oldal tetején elhelyezkedő szűrők betöltése---------//
    function MakeMarkings($site){
        echo "<script>document.getElementById('$site').classList.add('active');</script>";
    }
    
    function TestOutput($text){ echo '<script>console.log("'.$text.'")</script>"'; } //Testelés log-olással
    
    function MakeAdminFooter(){
        echo"<footer class='admin-footer'><a class='footer' href='adjust_aa.php'>Automata Admin Konfiguráció</a></footer>";
    }
    function SendNotificationForUser($userid,$type,$sender){
        global $jelenlegi_ido;
        global $conn;
        DBSafeInsert("notifications",[NULL,$userid,"$jelenlegi_ido",$sender,"$type",0]);
    }
    function WordOK($text){
        global $conn;
        $szoveg=strtolower($text);
        $keresett_szo=DBSafeSearch("swears","word = ?",[$szoveg]);
        if(mysqli_num_rows($keresett_szo)>0){
            return 0;
        }
        else{
            return 1;
        }
    }
    function PenaliseUser($id,$text,$is_aa){
        global $conn;
        global $jelenlegi_ido;
        $buntetopontszam=DBSafeSearch("users", "id = ?",[$id])->fetch_assoc()["penaltypoints"];
        DBSafeUpdate("users", "penaltypoints = ?", "id=?",[$buntetopontszam+1,$id]);
        if(!$is_aa){
            DBSafeInsert("logs",[NULL,$_COOKIE["id"],"penalty","$jelenlegi_ido",$id,"$text"]);
            SendNotificationForUser($id,"Büntetőpontot rótt ki Neked az AutoAdmin. Javasoljuk, hogy olvasd át a felhasználási feltétleket.",$_COOKIE["id"]);
        }//manuális büntetés
        else{
            DBSafeInsert("logs", [NULL,0,'penalty',"$jelenlegi_ido",$id,"$text"]); //
            SendNotificationForUser($id,"$text",0);
   
        }//automata büntetés
        AutoBan($id);//Tiltandó e a felhasználó automatikusan?
    }
    function CheckForUserBans($id){
        global $conn;
        global $jelenlegi_ido;
        
        $kereses=DBSearch("logs WHERE userid = $id AND ptype LIKE 'tempban-%'");
        if(mysqli_num_rows($kereses)==0){
            return false;
        }
        else if(mysqli_num_rows($kereses)==1){
            $napok=HowManyDays($kereses->fetch_assoc()["ptime"],$jelenlegi_ido);
            if($napok>=1){
                return false;
            }
            else{
                Message("1 napos tiltást kaptál sorozatos szabályszegések miatt...");
                return true;
            }

        }
        else if(mysqli_num_rows($kereses)==2){
            $kereses2=DBSafeSearch("logs","userid = ? AND ptype = ?",[$id,"tempban-2"]);
            $napok=HowManyDays($kereses2->fetch_assoc()["ptime"],$jelenlegi_ido);

            if($napok>=7){ return false;}
            else{
                Message("1 hetes tiltást kaptál folytatólagos szabályszegések miatt...");
                return true;
            }
        }
        $perma=DBSafeSearch("logs","userid = ? AND banned = ?",[$id, -1]);
        if(mysqli_num_rows($perma)==1){
            Message("Ezt a fiókot felfüggesztettük a többszöri figyelmeztetés után is folytatott közösségbontó viselkedés miatt!");
            return true;
        }
        
    }
    function AutoBan($id){
        global $conn;
        global $jelenlegi_ido;
        $user=DBSafeSearch("users","id = ?", [$id])->fetch_assoc();
        
        //első körös ban 1 nap erejéig
        if($user["penaltypoints"]==7){
            DBSafeInsert("logs", [NULL,$_COOKIE["id"],'tempban-1',"$jelenlegi_ido",$id,'Tiltás 1 napra a Felhasználási feltételek sorozatos megszegéséért!']);
            RemoveFromAdmins($id,0);
        }
        //második körös ban 1 hét erejéig
        else if ($user["penaltypoints"]==14) {
            DBSafeInsert("logs",[NULL,$_COOKIE["id"],'tempban-2',"$jelenlegi_ido",$id,'Tiltás 7 napra a Felhasználási feltételek sorozatos megszegéséért!']);
            RemoveFromAdmins($id,0);
        }
        //permaban
        else if($user["penaltypoints"]>=21){
            DBSafeInsert("logs", [NULL,$_COOKIE["id"],'permaban',"$jelenlegi_ido",$id,'Véglegesen tiltva a Felhasználási feltételek sorozatos megszegése miatt.']);
            RemoveFromAdmins($id,0);
        }
        
    
    }
    function HowManyDays($date1, $date2) {
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->days; // Ha csak a napok száma kell
    }
    function GetSteps($mode) { 
        global $conn;
        $recipeid=$_GET["recipeid"];

        $food = DBSafeSearch("foods","id = ?",[$recipeid])->fetch_assoc();
        $found_recipe = DBSafeSearch("recipe","foodid = ?",[$food["id"]])->fetch_assoc();
        echo"<h2 class='making-instructions'>Az elkészítés menete:</h2>";
        echo"<button id='up'>";MakeIcon("Arrow-up");echo"</button>";
        echo"<div class='instructions'>";
             
          
            $lepesek=explode('#',$found_recipe["instructions"]);
            // for($i=0; $i<count($lepesek);$i++){
            //     $szam=$i+1;
            //     echo"<div class='lepes'><h3>$szam.lépés:</h3><p>$lepesek[$i]</p></div>";    
            // }
            if($mode=="public"){
                for($i=0; $i<count($lepesek);$i++){
                    $szam=$i+1;
                    
                    echo"<div class='lepes'><h3 class='making-instructions'>$szam.lépés</h3><p class='making-instructions'>$lepesek[$i]
                    </p></div>";
                }
            }
            else{
                echo"<h3 class='making-instructions'>Ez a recept ".count($lepesek)." db lépésből áll.<h3>";
            }

        echo"</div>
        <button id='down'>";MakeIcon("Arrow-down");echo"</button>";            
    } 
    function GetRecipe($recipeid) {
        global $conn;
        $food=DBSafeSearch("foods","id = ?",[$recipeid])->fetch_assoc();?>

            <h1><?=$food["name"]?></h1>
            <div class="leiras">
                <div class="first">
                    <div class="image" <?php MakeAccessibilityTag($food["name"]);?> style="background-image: url(../../img/uploads/<?=$food["img"];?>)"></div>
                    <div class="info">
                        <?php $isFavourite = mysqli_num_rows(DBSafeSearch("likes","userid = ? AND recipeid = ?",[$_COOKIE["id"],$recipeid])); // => components/functions.php
                        ?>
                        <div class="difficulty"><h2>Nehézség</h2><div class="review"><?php Rating($food["difficulty"]);// => components/functions.php(328)?></div></div>
                        <div class="like"><h2><?php if($isFavourite) { ?> Te + <?= GetNumberOfLikes($recipeid)?><?php } else { ?> <?= GetNumberOfLikes($recipeid)?> kedvelés<?php } ?></h2><a class="love" href="addlike.php?recipeid=<?=$recipeid;?>"><?php if($isFavourite){echo MakeIcon("Heart r");}else{echo MakeIcon("Heart");}?></a></div>  <!-- -> components/functions.php -->
                        <?php $feltolto=DBSafeSearch("users","id = ?",[$food["uploaderid"]])->fetch_assoc();?>  <!-- -> components/functions.php -->
                        <div class="author">
                            <h2>Feltöltő</h2>
                            <a href="profile.php?userid=<?=$feltolto["id"];?>" class="uploader">
                                <div class="profile-pic"  style="background-image:url(../../img/site/<?=$feltolto["pic"];?>)">

                                </div>
                                <?=$feltolto["username"];?>
                            </a> 
                        </div>

                    </div>
                </div>
                
                <div class="ingredients">
                    <?php 
                        $found_recipe = DBSafeSearch("recipe","foodid = ?",[$food["id"]])->fetch_assoc();
                        $ingredients=explode("#",$found_recipe["ingredients"]);
                        $tools=explode("#",$found_recipe["tools"]);
                    ?>
                    <div class="materials ">
                        <h2>Összetevők</h2>
                        <ul class="materials-list">
                            <?php
                                for($i=0; $i<count($ingredients); $i++) { if(strlen($ingredients[$i])>1){ ?>
                                    
                                    <li class="mat"><?php MakeIcon("ListItem"); ?><?=$ingredients[$i];?></li>  <!-- -> components/functions.php -->
                            <?php } } ?>
                        </ul>
                    </div>
                    <div class="tools ">
                        <h2>Eszközök</h2>
                        <ul class="tools-list">
                            
                            <?php
                                for($i=0; $i<count($tools); $i++) { ?>
                                    <li class="tool"><?php MakeIcon("ListItem"); ?><?=$tools[$i];?></li> <!-- -> components/functions.php -->
                            <?php } ?>

                        </ul>
                        <div class="time">
                            <h2>Elkészítési idő</h2>
                            <p><?php MakeIcon("ListItem");?><?=$found_recipe["time"];?> perc</p> <!-- -> components/functions.php -->
                        </div>
                        <div class="time">
                            <h2>Adagok száma</h2>
                            <p><?php MakeIcon("ListItem");?><?=$found_recipe["portions"] ?> adag</p>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php
            ?>
            <?php if(isset($_COOKIE["adminid"])){
                GetSteps("public");
            }
            else{
                GetSteps("steps hidden");
            }?>
            <form class="btns" method="post" action="recipe.php?recipeid=<?=$recipeid?>"style='margin-top:20px;'>
                
                <?php if(!isset($_COOKIE["adminid"])){

                        $jelentetted=mysqli_num_rows(DBSafeSearch("reports","reporterid = ? AND recipeid=?",[$_COOKIE["id"],$recipeid]))>0;?>
                <button class="make" name="make" type="submit"><?php MakeIcon("MakeMeal");?><span>Elkészítés</span></button>
                <button name="rep" class="ban" type="submit" <?php if($jelentetted){echo"disabled";}?>><?php MakeIcon("Ex-mark"); echo"<span>";if($jelentetted){echo"Jelentetted";}else{echo"Jelentés";}?></span></button>                    
                <?php
                }else { ?>
                    <button name="ok" type="submit"class="make"><?php MakeIcon("Like")?><span>Rendben</span></button>
                    <button name="ban" class="ban" type="submit"><?php MakeIcon("Ban")?><span>Tiltás</span></button> 
                <?php }
                
            echo'</div>';
    }
    function GetNumberOfLikes($recipeid){
        global $conn;
        $szam=mysqli_num_rows(DBSafeSearch("likes","recipeid = ?",[$recipeid]));
        if($szam==0){
            return 0;
        }
        else{
            return $szam;
        }
    }
    
    function GetRankIndicator($id){
        global $conn;
        global $novekedesi_szorzo;
        $pont=DBSafeSearch("users","id = ?",[$id])->fetch_assoc();
        $haladas=GetLevel($pont["points"],$novekedesi_szorzo);
        $jelenlegi_rang=$haladas["jelenlegi"];
        $kovetkezo_rang=$haladas["kovetkezo"];
        $progress=GetProgress($pont["points"],$jelenlegi_rang,$kovetkezo_rang);
        $cimke=intval($progress);
        $korvonal=360-intval(3.6*$progress);
        
        echo "<h2 id='kordiagramcim'>Rang</h2>
        <div class='circle $jelenlegi_rang[rang]' style='background-image: conic-gradient(white ".$korvonal."deg, transparent 0deg);'>
            <div class='inner-circle'>
                $jelenlegi_rang[rang] <br> $pont[points]/$kovetkezo_rang[pont]<br>  
            </div>
        </div>";

    }
    function GetNumberOfRecipes($id){
        global $conn;
        $count=$conn->query("SELECT COUNT(*) AS count FROM foods WHERE ok = 1 AND uploaderid=$id AND ok=1")->fetch_assoc();
        echo "<h2>Feltöltött receptek</h2><p>$count[count]</p>";
    }
    function GetNumberOfUploads($id){
        global $conn;
        $count=$conn->query("SELECT COUNT(*) AS count FROM tries WHERE accepted=1 AND userid=$id")->fetch_assoc();
        echo "<h2>Sikeresen elkészített receptek</h2><p>$count[count]</p>";

    }
    function GetNumberOfLikesForUsersRecipes($id){
        global $conn;
        $user_receptjei=DBSafeSearch("recipe","foodid IN(SELECT id FROM foods WHERE uploaderid=? AND ok=?) AND ok=?",[$id,1,1]);
        $likeok=0;
        if(mysqli_num_rows($user_receptjei)!=0){
            
            while($talalt_recept=$user_receptjei->fetch_assoc()){
                $likeok+=GetNumberOfLikes($talalt_recept["id"]);
            }
        }
        echo"<h2>Receptjeire adott likeok</h2><p>$likeok</p>";
    }
    
    function GetAchievement($id,$kat){
        global $conn;
        global $rangok;
        $lekerdezes=$conn->query("SELECT COUNT(*) as count
        FROM tries WHERE userid=$id and accepted=1 and recipeid IN 
        (SELECT id FROM recipe WHERE foodid IN 
        (SELECT id FROM foods WHERE tags LIKE '%$kat%'))")->fetch_assoc();
        $jelenlegi_rang=GetLevel($lekerdezes["count"],1)["jelenlegi"];
        $kovetkezo_rang=GetLevel($lekerdezes["count"],1)["kovetkezo"];
        $kategoria=DBSafeSearch("categories","catname=?",[$kat])->fetch_assoc();

        echo"<div class='badge $jelenlegi_rang[rang]'>";
        echo"<div class='badge-rank'>$jelenlegi_rang[rang]</div>";
        MakeIcon($kat);
        echo"<div>$kategoria[prizename]</div>";
        echo"<div class='description'>$kategoria[description]</div>";
        
        $progress=GetProgress($lekerdezes["count"],$jelenlegi_rang,$kovetkezo_rang);
        echo"<div class='progress'>$lekerdezes[count]/$kovetkezo_rang[pont]</div>";
        echo"<div class='progress-bar'><div class='slider' style='width: $progress%;'></div></div>";
        echo"</div>"; 

        
    }
    function GetLevel($pt,$nsz){
            global $rangok; // A globális rangok elérése
            $currentRang = "Tanulóséf";
            $nextRang = "Fakanálforgató"; // Alapértelmezett következő rang
            $nextPont= 1*$nsz;
            $pont=0;
            $found = false;
        
            foreach ($rangok as $rang => $minimumPont) {
                if ($pt >= $minimumPont*$nsz) {
                    $currentRang = $rang;
                    $pont=$minimumPont*$nsz;
                    $found = true;
                } elseif ($found) {
                    // Az eggyel magasabb rang megtalálása
                    $nextRang = $rang;
                    $nextPont= $minimumPont*$nsz;
                    break;
                }
            }
        
            return ["jelenlegi" => ["rang" => $currentRang, "pont" => $pont] , "kovetkezo" => ["rang" => $nextRang, "pont" => $nextPont]];
    }
    function GetProgress($pont,$kisebb_rang, $nagyobb_rang){
        $progress=($pont-$kisebb_rang["pont"])/($nagyobb_rang["pont"]-$kisebb_rang["pont"])*100;
        return $progress;
        
    }
    
    
    
    
    function UpdateUserRank($id,$elozo_rang){ //a $elozo rang mindig 2D-s asszociatív tömb eleme
        global $conn;
        global $novekedesi_szorzo;
        $user=DBSafeSearch("users","id = ?",[$id])->fetch_assoc();
        $aktualis_rank=GetLevel($user["points"],$novekedesi_szorzo)["jelenlegi"]["rang"];//FH profilja az AB-ban
        DBSafeUpdate("users", "rank = ?","id=?",["$aktualis_rank",$id]);
        if($elozo_rang!=$aktualis_rank&&$elozo_rang!=null){
            SendNotificationForUser($id,"Megváltozott a rangod! ($elozo_rang => $aktualis_rank)",0);
        }
    }

    function GivePointsToUser($userid,$pt){
        global $conn;
        $elozo_rang=DBSafeSearch("users","id = ?",[$userid])->fetch_assoc()["rank"];
        $elozo_pontszam=DBSafeSearch("users", "id=?", [$userid])->fetch_assoc()["points"];
        DBSafeUpdate("users", "points = ?", "id = ?",[$elozo_pontszam+$pt,$userid]);
        if($pt<0){
            $pontszam=DBSafeSearch("users","id = ?",[$userid])->fetch_assoc()["points"];
            if($pontszam<0){

                DBSafeUpdate("users","points = ?", "id= ?",[0,$userid]);
            }
        }
        UpdateUserRank($userid,$elozo_rang);
        

    }

    function RewardUser($userid, $uploadedid){
        $recipeid=DBSafeSearch("tries","id = ?",[$uploadedid])->fetch_assoc()["recipeid"];
        $foodid=DBSafeSearch("recipe","id = ?",[$recipeid])->fetch_assoc()["foodid"];
        $food=DBSafeSearch("foods","id = ?",[$foodid])->fetch_assoc();
        GivePointsToUser($userid,$food["difficulty"]);
        SendNotificationForUser($userid,"Gratulálunk! Sikeresen elkészítetted ezt: $food[name]",0);  
    }

    
function GetHallOfFame($id){
    echo"<form class='hof' method='post' action='rankings.php'>
        <h1>Legtöbb pont</h1>
    </form>
    <div class='leaderboard'>
        <ul class='ranglista'>";
    $szam=0;//rangsor helyezéseihez kell
    $talalatok= DBSafeSearch("users","id=id ORDER BY points DESC",[]);
    while($talalat = $talalatok->fetch_assoc()){ 
    $szam++; 
    $isitme=$talalat["id"]==$id?"me":"";// a felhasználó akinek a profilját/kitüntetéseit nézi a felhasználó
    echo"<li class='person $isitme' id='$isitme 'ranking='$szam'>
            <span class='place' ranking='$szam'>$szam</span>
            <a href='profile.php?userid=$talalat[id]'>$talalat[username]
                <span class='pts'>$talalat[points] <span class='pont'>pont ($talalat[rank])</span></span>
            </a>
         </li>";
    }
    echo"
        </ul>
    </div>";
    
}

function GetUsersStats($id){
        echo"<div class='your-rank'>
            <h1>Összefoglalás</h1>
            <div class='rank-indicator'>";
                GetRankIndicator(intval($id));
        echo"</div>
            <div class='other-info'>
                <div class='numberofrecipes'>";
                    GetNumberOfRecipes($id);
            echo"</div>
                <div class='number-of-uploads'>";
                    GetNumberOfUploads($id);
                echo"</div>
                <div class='kudos'>";
                    GetNumberOfLikesForUsersRecipes($id);
            echo"</div>
            </div>
        </div>
        <div class='your-achievements'>
            <h1>Kitüntetéseid</h1>";
                $kategoriak=DBSafeSearch("categories","",[]);
                //echo"<div class='y-a'>";
                while($kategoria=$kategoriak->fetch_assoc()){
                    GetAchievement($id,$kategoria["catname"]);
                }
                //echo"</div>";
        echo"</div>";
    }

    function RemoveIllegalFavourites($recipeid){
        $likeok=DBSafeSearch("likes", "recipeid=?", [$recipeid]);
        while($like=$likeok->fetch_assoc()){
            SendNotificationForUser($like["userid"], "Sajnáljuk, de sajnos el kellett távolítsunk egy általad kedvelt receptet, mert sértette a Felhasználási feltételeket", $_COOKIE["id"]);
        }
        $recipe=DBSafeSearch("recipe", "id=?",[$recipeid])->fetch_assoc();
        $food=DBSafeSearch("foods", "id=?", [$recipe["foodid"]])->fetch_assoc();
        $uploader = DBSafeSearch("users", "id", [$food["uploaderid"]])->fetch_assoc();
        GivePointsToUser($uploader["id"], mysqli_num_rows($likeok));
        DBSafeDelete("likes", "recipeid=?", $recipeid);
    }
   

?>
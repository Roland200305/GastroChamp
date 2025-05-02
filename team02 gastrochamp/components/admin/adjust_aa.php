<?php
    require_once "../functions.php";
    Validate(false);
    MakeAdmin($_COOKIE["id"]);
    
    function LogItemAddition($item, $type){
        $string="";
        global $jelenlegi_ido;
        if($type=="word"){
            $string.="Sikeresen felvett tiltólistás szó: $item[word]";
        }
        elseif ($type=="ingredient") {
            $string.="Sikeresen felvetted a következő alapanyagot: $item[name] ($item[scale])";
        }
        else{
            $string="Sikeresen felvetted a következő eszközt: $item[name]";
        }

        DBSafeInsert("logs", [NULL, 0, "admin-log", "$jelenlegi_ido",$_COOKIE["adminid"],"$string"]);
    }

    if(isset($_POST["append"])){
        if(WordOK($_POST["word"])){ //Ha az adott szó nincs a tiltott szavak közt
            $ido=date("Y-m-d H:i:s",time());
            DBSafeInsert("swears",[NULL,$_POST["word"],$_COOKIE["id"],"$ido"]);
            LogItemAddition(DBSafeSearch("swears", "word=?", [$_POST["word"]])->fetch_assoc(), "word");
            Message("Sikeresen felvetted ezt a szót a szótárba: $_POST[word]");
        }
        else{
            Message("Ez a kifejezés már benne van a szótárban!");
        }
    }
    if(isset($_POST["add-i"])){
        if(WordOK($_POST["ingredient"]) && WordOK($_POST["scale"])){
            $szam=mysqli_num_rows(DBSafeSearch("ingredients", "name=?", [$_POST["ingredient"]]));
            if($szam>0){
                Message("Van már ilyen összetevő a rendszerben!");
            }
            else{
                DBSafeInsert("ingredients",[NULL,$_POST["ingredient"],$_POST["scale"],$_COOKIE["id"]]);
                LogItemAddition(DBSafeSearch("ingredients", "name=? AND scale=?",[$_POST["ingredient"],$_POST["scale"]])->fetch_assoc(),"ingredient");

                Message("Sikeresen hozzáadtad az összetevőt!");
            }

        }
        else{
            PenaliseUser($_COOKIE["id"],"Obszcén nyelvezet használata",true);
            SendNotificationForUser($_COOKIE["id"],"Büntetőpontot róttunk ki Neked.",0);

        }
    }
    if(isset($_POST["add-t"])){
        if(WordOK($_POST["tool"])){
            $szam=mysqli_num_rows(DBSafeSearch("tools", "name=?", [$_POST["tool"]]));
            if($szam>0){
                Message("Van már ilyen összetevő a rendszerben!");
            }
            else{
                DBSafeInsert("tools",[NULL,$_POST["tool"],$_COOKIE["id"]]);
                LogItemAddition(DBSafeSearch("tools","name=?",[$_POST["tool"]])->fetch_assoc(),"tool");
                Message("Sikeresen hozzáadtad az összetevőt!");
            }

        }
        else{
            PenaliseUser($_COOKIE["id"],"Obszcén nyelvezet használata",true);
            SendNotificationForUser($_COOKIE["id"],"Büntetőpontot róttunk ki Neked.",0);

        }
    }
    
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        SetCharset("UTF-8");
        InitializeViewport();
        MakeDevCredits();
    
        CallCSS("../../css/aa.css");
        CallJS("https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js");
            
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Automata Admin Rendszer");
?>
</head>
<body>
    <header>
        <?php MakeAdminNav();?>
    </header>
    <main>
        <h1>Automata Admin Rendszer kezelőfelület
        </h1>
        <div class="szotar">            
            <h2>Szótár</h2>
            <form action="adjust_aa.php" method="post" class="aa_form">
                <input type="text" name="word"  id='kereso' autocomplete='off' placeholder='Kifejezés' required>
                <button type="submit" class='make' id='make' name='append'><?php echo MakeIcon("Add");?> <span>Szűrőszótár bővítése</span></button>
            </form>
            <div id="szavak"></div>
        </div>

        <div class="hozzavalok">
            <h2>Hozzávalók</h2>
            <form action="adjust_aa.php" method="post" class="aa_form">
                <input type="text" name="ingredient"  id='hozzavalo' autocomplete='off' placeholder='Hozzávaló' required>
                <input type ="text" name = "scale" autocomplete="off" placeholder='Mértékegység (pl.: g, l, dkg)' required>
                <button type="submit" class='make' id='make' name='add-i'><?php echo MakeIcon("Add");?> <span>Hozzávaló hozzáadása</span></button>
            </form>
            <div id="hozzavalok"></div>
        </div>

        <div class="eszkozok">
            <h2>Eszközök</h2>
            <form action="adjust_aa.php" method="post" class="aa_form">
                <input type="text" name="tool"  id='eszkoz' autocomplete='off' placeholder='Eszköz' required>
                <button type="submit" class='make' id='make' name='add-t'><?php echo MakeIcon("Add");?> <span>Eszköz hozzáadása</span></button>
            </form>
            <div id="eszkozok"></div>
        </div>
    </main>
    <?php MakeAdminFooter();?>
</body>
</html>
<script>
    const kereso = document.getElementById("kereso");
    
    kereso.addEventListener("input", (e) => {
        $("#szavak").load("getitem.php?keresett="+e.target.value+"&type=word");
    });
    const eszkoz = document.getElementById("eszkoz");
    eszkoz.addEventListener("input", (e) => {
        $("#eszkozok").load("getitem.php?keresett="+e.target.value+"&type=tool");
    });
    const hozzavalo = document.getElementById("hozzavalo");
    hozzavalo.addEventListener("input", (e) => {
        $("#hozzavalok").load("getitem.php?keresett="+e.target.value+"&type=ingredient");
    });

</script>
<?php CallJS("../../js/buttons.js");?>
<?php CallJS("../../js/adjust_aa.js");?>
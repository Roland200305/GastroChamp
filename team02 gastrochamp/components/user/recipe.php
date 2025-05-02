<?php
    require_once "../functions.php";


    $id=Validate(false);
    $recept=DBSafeSearch("recipe", "foodid=?", [$_GET["recipeid"]])->fetch_assoc();

    $food=DBSafeSearch("foods", "id=?",[$recept["foodid"]])->fetch_assoc();
    $recipeid=$recept["foodid"];
    $user=WhoIsIt($id); // => components/functions.php
    $random=mysqli_num_rows(DBSafeSearch("recipe","",[]));
    if(isset($_POST["rep"])){
        $jelentetted=mysqli_num_rows(DBSafeSearch("reports","reporterid = ? AND recipeid=?",[$_COOKIE["id"],$recipeid]))>0;
        if(!$jelentetted){
            DBSafeInsert("reports",[NULL,$_COOKIE["id"],$recipeid,0,0]);
        }
    }
    if(isset($_POST["ban"])){
        $etel=DBSafeSearch("foods","id = ?", [$recipeid])->fetch_assoc();
        DBSafeInsert("logs",[NULL, $_COOKIE["adminid"],'recept',"$jelenlegi_ido",$etel["uploaderid"],'A kép vagy a szövegezés nem megfelelő!']);
        DBSafeUpdate("recipe","ok = ?","foodid = ?", [-1,$recipeid]);
        DBSafeUpdate("foods", "ok = ?","id =?", [-1 ,$recipeid]);
        DBSafeUpdate("reports", "ok = ?","recipeid = ?",[-1,$_GET["recipeid"]]);

        GivePointsToUser($etel["uploaderid"],-1*$etel["difficulty"]);
        if(isset($_COOKIE["adminid"])){
            header("Location: ../admin/uploadedrecipes.php");
        }

    }
    if(isset($_POST["make"])){
        header("Location: makerecipe.php?recipeid=$_GET[recipeid]");
    }
    if(isset($_GET["penalized"])){
        Message("Spamelted az elkészítés gombot, ezért bűntetésben részesültél. Ez a recept nem készülhetett el ennyi idő alatt.");

    }
    if(isset($_GET["ready"])){
        Message("Beküldött próbálkozásodat az adminok jóváhagyására bocsájtottuk és értesítünk, amint validálásra jutott.");
    }
    if(!isset($_GET["ready"])&& isset($_COOKIE["keszen"])){
        CancelCookie($_COOKIE["keszen"]);

    }
    if(isset($_POST["ok"])){
        DBSafeUpdate("recipe", "ok=?","foodid =?", [1,$_GET["recipeid"]]);
        DBSafeUpdate("foods", "ok=?","id = ?",[1,$_GET["recipeid"]]);
        DBSafeUpdate("reports", "ok=?, adminid=?","recipeid=?",[1,$_COOKIE["adminid"],$_GET["recipeid"]]);
        $uje=mysqli_num_rows(DBSafeSearch("reports","recipeid = ?",[$recipeid]))==0;
        if($uje){
            $foodid=DBSafeSearch("recipe", "foodid = ?",[$recipeid])->fetch_assoc()["foodid"];
            $uploader=DBSafeSearch("foods","id = ?",[$foodid])->fetch_assoc();
            
            $pont=DBSafeSearch("foods","id = ?",[$foodid])->fetch_assoc();
            GivePointsToUser($uploader["uploaderid"],$pont["difficulty"]);
        }
        header("Location: ../admin/uploadedrecipes.php");

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        SetCharset("UTF-8");
        InitializeViewport();     
        MakeDevCredits();
        MakeSEOVisibility();
        SetSEOKeywords("Egyszerű $food[name] recept, Gyors $food[name] recept, Olcsó $food[name] recept,$kozos_seo_cuccok");
        MakePageDescription();


        CallCSS("../../css/seged.css");
        CallCSS("../../css/recipe.css");
        CallCSS("../../css/nav.css");
        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("$food[name] receptje");
    ?>
    <?php
        echo"<style>
        *{
        }
        @keyframes fadeIn{
            0%{
                opacity:0;
            }   
            100%{
                opacity:1;
            }     
        }</style>"
    ?>
</head>
<body>
        <header class="clearfix">
            
            <?php if(!isset($_COOKIE["adminid"])){MakeNav(false);}
        else{MakeAdminNav();}  // => components/functions.php (110)
            ?>
        </header>
        <main>
            <?php GetRecipe($recipeid);?>

        
        </main>
        <?php MakeFooter(false); 
            CallJS("../../js/buttons.js");
        // => components/functions.php (164)?>
        

</body>
</html>
<script>
    document.getElementById("up").style.display='none';
    document.getElementById("down").style.display='none';
</script>
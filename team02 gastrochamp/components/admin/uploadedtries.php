<?php
    require_once "../functions.php";
    Validate(false);
    MakeAdmin($_COOKIE["id"]);
    
    if(isset($_POST["make"])){
        header("Location: trial.php?trialid=$_GET[trialid]");
    }
    if(isset($_POST["ban"])){
        
        $trial=DBSafeSearch("tries","id = ?", [$_GET["trialid"]])->fetch_assoc();
        DBSafeUpdate("trial", "accepted =?", "id=?",[-1,$trial["id"]]);
        PenaliseUser($uploader["id"],"Sértő kép készült a próbálkozáshoz!",false);
    }

    function LoadAttempts(){
        global $conn;
        $kiserletek=DBSafeSearch("tries","accepted = ? AND userid != ? ORDER BY id ASC",[0,$_COOKIE["id"]]);
        if(mysqli_num_rows($kiserletek)!=0){
            while($kiserlet=$kiserletek->fetch_assoc()){
                echo "<a href='trial.php?trialid=$kiserlet[id]'>";
                $keresett_szemely=DBSafeSearch("users", "id = ?",[$kiserlet["userid"]])->fetch_assoc();
                $keresett_etel=DBSafeSearch("foods","id = ?",[$kiserlet["recipeid"]])->fetch_assoc();
                echo"<form class='tile' method='post' action='uploadedtries.php?trialid=$kiserlet[id]'
                style='background:url(../../img/uploads/$kiserlet[image]); justify-content:space-between; background-repeat: no-repeat;
                       background-position: center;
                       background-size: cover;' action='' method='post'><h2 style='text-align:center;'>$keresett_etel[name]</h2><div class='btns'>
                       <button type='submit' class='make' name='make'>";echo MakeIcon("Eye");echo"<span>Nézet</span></button>
                       <button type='submit' value= name='ban' class='ban'>";echo MakeIcon("Tiltás"); echo"<span>Tiltás</span></button></div>
                        </form>"; 
            }

        }
        else{
            echo"<h2>Minden eddig beérkezett próbálkozás elbírálásra került!<h2>";
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
        
        CallCSS("../../css/style.css");
        CallCSS("../../css/recipe.css");
        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Próbálkozások ellenőrzése");     
    ?> 
    <style>form h2{width:100%;background:rgba(0,0,0,.7);}form *{justify-content:center!important;} *{opacity: 1!important;}</style>

</head>
<body>
    <header>
        <?php MakeAdminNav();  // => components/functions.php (189)?>
    </header>
    <main>
        <h1>Kísérletek</h1>
        <?php
            LoadAttempts(); // => components/functions.php(288)
        ?>
    </main>
    <?php MakeAdminFooter();?>
    <?php MakeMarkings("tries");
        CallJS("../../js/buttons.js");
    // => components/functions.php(328)?>
</body>
</html>
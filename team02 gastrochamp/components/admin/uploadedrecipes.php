<?php
    require_once "../functions.php";
    Validate(false);
    MakeAdmin($_COOKIE["id"]);



    if(isset($_POST["make"])){
        $recipe=DBSafeSearch("recipe","foodid = ?", [$_GET["recipeid"]])->fetch_assoc();
        $food=DBSafeSearch("foods","id = ?",[$recipe["foodid"]])->fetch_assoc();
        $user=DBSafeSearch("users","id = ?",[$food["uploaderid"]])->fetch_assoc();
        header("Location: ../user/recipe.php?recipeid=$recipe[foodid]");
        UpdateUserRank($user["id"],$user["rank"]);
    }
    if(isset($_POST["ban"])){
        
        PenaliseUser($uploader["id"],"Sértő kifejezés a név használata során!",false);
        sleep(3);
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
        
        CallCSS("../../css/style.css");
        CallCSS("../../css/recipe.css");
        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Receptek ellenőrzése");
    ?>
    <style>form h2{width:100%;background:rgba(0,0,0,.7);}form *{justify-content:center!important;}</style>

</head>
<body>
    <header>
        <?php
            MakeAdminNav();  // => components/functions.php (189)
        ?>
    </header>
    <main>
        <h2>Jelentett receptek</h2>
        <?php

        $lekerdezes=DBSafeSearch("reports","ok=? AND reporterid != ? ORDER BY id ASC",[0,$_COOKIE["id"]]);
        $mutathatok=0;
        if(mysqli_num_rows($lekerdezes)!=0){
            while($talalat=$lekerdezes->fetch_assoc()){
                $jelento=DBSafeSearch("users","id =?", [$talalat["reporterid"]])->fetch_assoc();
                $jelentett_recept=DBSafeSearch("recipe","foodid = ?",[$talalat["recipeid"]])->fetch_assoc();
                $jelentett_etel=DBSafeSearch("foods","id = ?" ,[$jelentett_recept["foodid"]])->fetch_assoc();
                if($jelento["id"]!=$_COOKIE["id"] && $jelentett_etel["uploaderid"]!=$_COOKIE["id"]){
                    echo "<form method='post' class='tile' action='../user/recipe.php?recipeid=$jelentett_recept[foodid]' style='background:url(../../img/uploads/$jelentett_etel[img]); justify-content:space-between; background-repeat: no-repeat;
                        background-position: center;
                        background-size: cover;'>
                    <h2>$jelentett_etel[name] <br>Jelentő: $jelento[username]</h2>
                    <div class='btns'>
                    <button type='submit' name='lookup' class='make'>";echo MakeIcon("Eye"); echo"<span>Nézet</span>
                    <button type='submit' class='ban'  name='ban'>"; echo MakeIcon("Tiltás"); echo"<span>Tiltás</span></button></div></form>";
                    
                    
                    $mutathatok++;
                }

            }
        }
        if($mutathatok==0){
            echo "<h3>Nincsenek elbírálatlan receptjelentések!<h3>";
        }
        
    ?>
        <h2>Újonnan feltöltve</h2>
        <?php
        $kereses=DBSafeSearch("foods","ok=? AND uploaderid != ?",[0,$_COOKIE["id"]]);
        if(mysqli_num_rows($kereses)>0){
            while($talalat=$kereses->fetch_assoc()){

                $recept=DBSafeSearch("recipe","foodid = ?",[$talalat["id"]])->fetch_assoc();
                $ember=DBSafeSearch("users","id = ?",[$talalat["uploaderid"]])->fetch_assoc();
                echo"<form class='tile' method='post' action='uploadedrecipes.php?recipeid=$talalat[id]'
                 style='background:url(../../img/uploads/$talalat[img]); justify-content:space-between; background-repeat: no-repeat;
                        background-position: center;
                        background-size: cover;' action='' method='post'><h2 style='text-align:center;'>$talalat[name]</h2><div class='btns'>
                        <button type='submit' class='make' name='make'>";echo MakeIcon("Eye");echo"<span>Nézet</span></button>
                        <button type='submit' value= name='ban' class='ban'>";echo MakeIcon("Tiltás"); echo"<span>Tiltás</span></button></div>
                        </form>"; 
            }
        }
        else{
            echo "<h3>Nincsenek újonnan feltöltött receptek!</h3>";
        }
        ?>
    </main>
    <footer>
        <?php MakeAdminFooter();?>
    </footer>
    <?php MakeMarkings("uploads");
    CallJS("../../js/buttons.js"); // => components/functions.php(328)?>

    
</body>
</html>

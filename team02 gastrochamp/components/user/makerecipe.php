<?php

    require_once "../functions.php";

    Validate(false);
    $recipeid=$_GET["recipeid"];
    $food=DBSafeSearch("foods","id = ?",[$_GET["recipeid"]])->fetch_assoc();
    $recipe=DBSafeSearch("recipe", "foodid = ?",[$_GET["recipeid"]])->fetch_assoc();
    setcookie("keszen",$_GET["recipeid"],time()+$recipe["time"]*54,"/");

    if(isset($_POST["back"])){
        setcookie("keszen","",time()-1000,"/");
        header("Location: recipe.php?recipeid=$_GET[recipeid]");
    }
    if(isset($_POST["make"])){
        
        if(!isset($_COOKIE["keszen"])){//KIVENNI A FELKIÁLTÓJELET!!!!!!!!!!!!!!!!
            PenaliseUser($_COOKIE["id"],"Spamelte az elkészítés gombot",true);
            setcookie("keszen",0,time()-1000,"/");
            header("Location: recipe.php?recipeid=$_GET[recipeid]&penalized=1");
        }
        if(isset($_FILES["kep"]) && $_FILES["kep"]["error"] !== 4){
            $file_name = $_FILES['kep']['name']; // Fájl neve 
            $tmp_name = $_FILES['kep']['tmp_name']; // Fájl ideiglenes neve 
                
            $mappa = getcwd();
            $unique_filename=time()."_".uniqid()."_".$file_name;//egyedi név minden képfájl számára
            $eleresi_ut = $mappa."/../../img/uploads/".$unique_filename;
            if(in_array(mime_content_type($_FILES['kep']['tmp_name']),$elfogadott_formatumok)){
                if(move_uploaded_file($tmp_name, $eleresi_ut)){
                    Message($eleresi_ut);
                    
                    DBSafeInsert("tries", [NULL,$_COOKIE["id"],$_GET["recipeid"],"$unique_filename",0]);
                    Message("Sikeresen feltöltötted a próbálkozásod!");
   
        
                }
                else{
                    echo "<script>alert('A fájl feltöltése sikertelen!')</script>";
                }
            }
            else{
                $formatumok=implode("/",$allowedTypes);
                Message("Nem támogatott formátum!($formatumok)");
            }
        }
        else{
            PenaliseUser($_COOKIE["id"],"Nem mellékelt képet az elkészítéshez",true); 
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
        MakeSEOVisibility();
        SetSEOKeywords($kozos_seo_cuccok);
        MakePageDescription();
        MakePageIcon("../../img/site/favicon.svg");


        CallCSS("../../css/svg.css");
        CallCSS("../../css/recipe.css");
        CallCSS("../../css/nav.css");    
        CallCSS("../../css/makerecipe.css");

        MakePageTitle("$food[name] elkészítése");  
    ?>
</head>
<body>
    <header><?php MakeNav(false) // => components/functions.php (110)?></header>
    <main>
        <?php GetSteps("public");  // => components/functions.php (205)
?>

        <form action="makerecipe.php?recipeid=<?=$_GET["recipeid"];?>" method="post" class="btns" enctype="multipart/form-data">
            <input type="file" name="kep">
            <button type="submit" value="Készen vagyok!" class="make" name="make"><?php MakeIcon("Kész");?><span>Készen vagyok!</span></button>
            <button type="submit" value="Vissza a recepthez!" class="ban" name="back"><?php MakeIcon("Vissza");?><span>Vissza a recepthez!</span></button>
        </form>
    </main>
    <?php
        MakeFooter(false);
        CallJS("../../js/buttons.js");
    ?>
    
        
    
</body>
</html>
<?php   CallJS("../../js/makerecipe.js");?>
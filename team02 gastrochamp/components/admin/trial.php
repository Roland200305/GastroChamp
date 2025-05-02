<?php
    require_once "../functions.php";
    Validate(false);
    MakeAdmin($_COOKIE["id"]);

    $trial=DBSafeSearch("tries","id = ?",[$_GET["trialid"]])->fetch_assoc();
    $etel=DBSafeSearch("foods", "id = ?",[$trial["recipeid"]])->fetch_assoc();
    $whotried=DBSafeSearch("users","id = ?", [$trial["userid"]])->fetch_assoc();
    if(isset($_POST["ban"])){
        DBSafeUpdate("tries","accepted=?","id = ?",[-1 , $_GET["trialid"]]);
        PenaliseUser($whotried["id"],"A feltöltött kép nem felel meg az ételnek.",false);
        header("Location: uploadedtries.php");

    }   
    if(isset($_POST["ok"])){
        DBSafeUpdate("tries", "accepted = ?", "id = ?",[1, $_GET["trialid"]]);
        RewardUser($whotried["id"],$_GET["trialid"]);
        header("Location: uploadedtries.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <?php  
        SetCharset("UTF-8");
        InitializeViewport();   
        MakeDevCredits();
        
        CallCSS("../../css/trial.css");
        CallCSS("../../css/recipe.css");
        CallCSS("../../css/svg.css");
        CallCSS("../../css/$nav_and_colors");
        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle($etel["name"]." - próbálkozás - ".$whotried["username"]);
    ?>

</head>
<body>
  
    <?php MakeAdminNav();?>
      <main><div class="images">
        <div class="original" style="background: url('../../img/uploads/<?=$etel["img"];?>'); "><span>Eredeti</span></div>
        <div class="other" style="background: url('../../img/uploads/<?=$trial["image"];?>'); "><span>Feltöltött</span></div>
    </div>
    <form action="trial.php?trialid=<?=$_GET["trialid"]?>" class="btns" method="post">
    <button name="ok" type="submit"class="make"><?php MakeIcon("Like");?><span>Rendben</span></button>
    <button name="ban" class="ban" type="submit"><?php MakeIcon("Ban");?><span>Tiltás</span></button> 
                
    </form>
</main>
    <?php MakeAdminFooter();
    CallJS("../../js/buttons.js");
    ?>
</body>
</html>
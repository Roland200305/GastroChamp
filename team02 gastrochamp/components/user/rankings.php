<?php

    require_once "../functions.php";
    if(isset($_COOKIE["adminid"])){CancelCookie($_COOKIE["adminid"]);}
    $id=Validate(false);
    $user=WhoIsIt($id);
    $random=mysqli_num_rows(DBSafeSearch("recipe","",[]));
    $lekerdezes=DBSafeSearch("users","id > ?",[0]);
    while($talalat=$lekerdezes->fetch_assoc()){
        UpdateUserRank($talalat["id"],$talalat["rank"]);
    }
    AddNotificationAnimation("#profile","background-color");

?>
<!DOCTYPE html>
<html lang="hu">
<head>
     <?php  
        InitializeViewport();        
        SetCharset("UTF-8");
        MakeDevCredits();
        MakeSEOVisibility();
        SetSEOKeywords("Szerezz rangokat!, Rangsor, Kitüntetések,$kozos_seo_cuccok");
        MakePageDescription();


        CallCSS("../../css/ranking.css");
        CallCSS("../../css/svg.css");
        CallCSS("../../css/nav.css");
        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Eredményeid");
    ?>
</head>
<body>
    <header>
        <?php
            MakeNav(false);// => components/functions.php (110)
        ?>
    </header>
    <main>
        <?php 
            GetHallOfFame($_GET["userid"]);
            GetUsersStats($_GET["userid"]); ?>
    </main>
    <footer><?php MakeFooter(false); // => components/functions.php (164)?></footer>
    <?php
        MakeMarkings("rankings");// => components/functions.php (328)
        CallJS("../../js/ranking.js");
    ?>
    
</body>
</html>
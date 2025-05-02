<?php
    require_once "../functions.php";
    
    $id=Validate(false);
    $user=WhoIsIt($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <?php
        SetCharset("UTF-8");
        InitializeViewport();    
        MakeDevCredits();
        MakeSEOVisibility();
        SetSEOKeywords("Kedvenc receptek, Kiváló receptek, Saját kedvencek, $kozos_seo_cuccok");
        MakePageDescription();

        CallCSS("../../css/style.css");
         
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Mentett receptjeid");
        
        

    ?>
</head>
<body>
    <header>
        <?php MakeNav(false);
        AddNotificationAnimation("#profile","background-color");// => components/functions.php (110)?>
    </header>
    <main>
         <?php MakeFilters(); // => components/functions.php (304)?>
            <hr>
            <div class="foodies" id="starter">
                <?php MakeFoodTiles(false,true);  // => components/functions.php (226)?>
            </div>
        </main>   
        <?php MakeFooter(false); // => components/functions.php (164)
        MakeMarkings("liked"); // => components/functions.php (328)
        ?>
    
</body>
</html>
<?php
    CallJS("../../js/index.js");
?>
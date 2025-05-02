<?php
    require_once "components/functions.php";
    $id=Validate(true);
    $user=WhoIsIt($id); // => components/functions.php
    if(isset($_COOKIE["adminid"])){
        CancelCookie("adminid");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
         <?php
            SetCharset("UTF-8");
            InitializeViewport();        
            MakeDevCredits();
            SetSEOKeywords($kozos_seo_cuccok);
            MakePageDescription("Böngéssz a receptek közt a GastroChamp-en, hogy találhass olyan új recepteket, amelyek tetszenek!");
            
            CallCSS("css/style.css");
            CallJS("https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js");

            MakePageIcon("img/site/logo.svg");
            MakePageTitle("Kezdőlap");
        
            AddNotificationAnimation("#profile","background-color");
        ?>
        
    </head>
    <body>
        <header>
            <?php MakeNav(true); // => components/functions.php?>
        </header>
        <main>
            <?php MakeFilters(); // => components/functions.php (304)?>
            <hr>
            <div class="foodies" id="starter">
                <?php
                    MakeFoodTiles(true,false);  // => components/functions.php (226)?>
            </div>
        </main>    
        <?php MakeFooter(true);?>
        
    </body>
</html>
<?php 
    MakeMarkings("home");// => components/functions.php (328)
    CallJS("js/index.js");
?>
<script>
    
    
</script>
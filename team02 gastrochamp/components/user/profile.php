<?php
    require_once "../functions.php";
    
    $id=Validate(false);
    $user=DBSafeSearch("users","id = ? ",[$id])->fetch_assoc();
    $random=mysqli_num_rows(DBSafeSearch("recipe","",[]));
    $who=DBSafeSearch("users","id = ?",[$_GET["userid"]])->fetch_assoc();
    UpdateUserRank($who["id"],$who["rank"]);
    
    $itstheuser=$who["id"]==$id;
    AddNotificationAnimation("#settings","fill");

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <?php
        InitializeViewport();     
        SetCharset("UTF-8");
        MakeDevCredits();
        MakeSEOVisibility();
        SetSEOKeywords("Profil, Receptjeid, Feltöltött receptek, Kedvelt receptek,$kozos_seo_cuccok");
        MakePageDescription();


        CallCSS("../../css/style.css");
        CallCSS("../../css/ranking.css");
        CallCSS("../../css/profile.css");
        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("$user[username] profilja");
    ?>
</head>
<body>
    <header>
        <?php if(!isset($_COOKIE["adminid"])){MakeNav(false);}
        else{MakeAdminNav();} // => components/functions.php (110)?>    
    </header>
    <main>
        <?php 
            if(isset($_COOKIE["adminid"])){MakeAdminButtons();}
            $pont=DBSafeSearch("users","id = ?",[$_GET["userid"]])->fetch_assoc();
            $haladas=GetLevel($pont["points"],$novekedesi_szorzo);
            $jelenlegi_rang=$haladas["jelenlegi"]["rang"];
        
        
        echo"<div class='info'> 
        <div class='profile $jelenlegi_rang' style='background:url(../../img/site/$who[pic]);'></div>
        <h1 class='name'>";
        if($user["isadmin"]!=0 && $itstheuser) {
            echo"<a href='../admin/admin.php?adminid=$_COOKIE[id]'>";
            MakeIcon("Admin");
            echo"</a>";
            }
            echo"$who[username]";
            if($itstheuser){ echo"<a href='settings.php'>";
                MakeIcon("Settings");
                echo"</a>";
            }
            echo"</h1></div>";
        
        echo"<div class='statistics'>
            <div class='their recipes'>
                ".MakeIcon("OwnRecipes")."<span>Receptjei</span>
            </div>
            <div class='their favourites'>
                ".MakeIcon("FavFile")."<span>Kedvencei</span>
            </div>
            <div class='their rank'>
                ".MakeIcon("Trophy")."<span>Rangja</span>
            </div>
        </div>
        <hr>";
        
        MakeFilters(); // => components/functions.php(304)
        echo"<hr>
            <div class='foodies' id='recipes'>";
            MakeFoodTiles(false,false);  // => components/functions.php (226)
            echo"</div>
            
            <div class='foodies' id='favourites'>";
                MakeFoodTiles(false,true);  // => components/functions.php (226)
            echo"</div>
            <div class='foodies' id='rank'>";
                
                    GetUsersStats($_GET["userid"]);
            
            echo"</div>";
    ?>
    </main>
    <footer>
        <?php 
        MakeFooter(false); // => components/functions.php (164)
        
        if($itstheuser){MakeMarkings("profile");}// => components/functions.php(328)
        ?>

    </footer>
</body>
</html>

<?php
    CallJS("../../js/index.js"); // => components/functions.php (150)
    CallJS("../../js/ranking.js");
    CallJS("../../js/profile.js"); // => components/functions.php (150)

?>
<?php
    require_once "../functions.php";
    Validate(false);
    MakeAdmin($_COOKIE["id"]);
    
    if(isset($_POST["makeadmin"])){
        DBSafeUpdate("users", "isadmin=?","id=?",[-1,$_GET["userid"]]);
    }
    if(isset($_POST["removeadmin"])){
        RemoveFromAdmins($_GET["userid"],$_COOKIE["id"]);
    }
    if(isset($_POST["ban"])){
        $kereses=DBSafeSearch("logs", "userid=? AND ptype=?", [$_GET["userid"],"tempban-1"]);
        $ban="";
        if(mysqli_num_rows($kereses)==0){
            $ban.="tempban-1";
        }
        else{
            $ban.="tempban-2";
        }
        DBSafeInsert("logs",[NULL, $_COOKIE["id"], $ban, $jelenlegi_ido,$_GET["userid"],"Admin által tiltásra itélve"]);
        $user=WhoIsIt($_GET["userid"]);
        Message("Sikeresen tiltottad a következő felhasználót: $user[username]");

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php    
        InitializeViewport();
        SetCharset("UTF-8");
        MakeDevCredits();
        
        CallCSS("../../css/users.css");

        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Felhasználók kezelése");
    ?>
</head>
<body>
    <header>
        <?php MakeAdminNav();  // => components/functions.php (189)?>
    </header>
    <main>
        <h1> Felhasználók</h1>
        <?php
            $lekerdezes=DBSafeSearch("users","id != ? AND penaltypoints=? AND isadmin!=?",[ $_COOKIE["id"],0,1]);
            while($talalat=$lekerdezes->fetch_assoc()) { ?>
                <div class="userrow">
                    <a href="user.php?userid=<?=$talalat["id"]?>" class="user ">
                        
                        <?php echo MakeIcon("User");echo $talalat["username"];?>
                    </a>
                    <form action="users.php?userid=<?=$talalat["id"]?>" method="post">
                        <?php if($talalat["isadmin"]==0){?><button type="submit" class="make" name="makeadmin"><?php MakeIcon("Plus"); MakeIcon("Admin");?><span>Admin jog adása</span></button>
                        <?php }else{ ?><button type="submit" name="removeadmin" class="ban"><?php MakeIcon("Minus");MakeIcon("Admin");?><span>Admin jog elvétele</span></button><?php }?>
                        <button class="ban" name="ban"><?php MakeIcon("Ban")?><span>Tiltás</span></button>
                    </form></div>
            <?php }
        ?>
    </main>
    
    <?php MakeAdminFooter(); MakeMarkings("users"); CallJS("../../js/buttons.js");// => components/functions.php(328)?>
    
</body>
</html>
<script>
    const svgs=document.querySelectorAll("svg");
    svgs.forEach(svg => {
        if(svg.classList.contains("settings")){
            svg.classList.remove("settings");
        }
        if(!svg.classList.contains("navicon") && !svg.classList.contains("math")){
            svg.classList.add("navicon");
        }
        
    }); 
</script>
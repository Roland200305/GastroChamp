<?php 
    require_once "../functions.php";
    Validate(false);
    MakeAdmin($_COOKIE["id"]);
    // user-ban,content-ban,auto-ban,recipe-made 
    //-1 admin, 0 nem admin, 1 mesteradmin
    function GetAdminActivities(){
        global $conn;
        $kereses=DBSafeSearch("logs","id>? ORDER BY id DESC",[-1]);
        while($talalat=$kereses->fetch_assoc()){    
            $felhasznalo=DBSafeSearch("users","id = ?",[$talalat["userid"]])->fetch_assoc();
            if($talalat["adminid"]!=0){
                $admin=DBSafeSearch("users", "id = ?",[$talalat["adminid"]])->fetch_assoc();
                echo"<p class='log'><span>";
                MakeIcon("Admin");
                echo"$admin[username]</span><span>";
            }
            else{
                echo"<p class='log'><span>";
                MakeIcon("Admin");
                echo"AutoAdmin</span><span>";
            }
            MakeIcon("Time");
            $ido=GetTimeElapsed($talalat["ptime"]);
            echo"$ido</span><span class='comment'>";
            MakeIcon("Comment");
            echo"$talalat[info]</span><span>";
            MakeIcon("User-log");
            echo"$felhasznalo[username]</span></p>";   
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
   
        CallCSS("../../css/admin.css");
                
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle(DBSafeSearch("users","id = ?",[$_COOKIE["id"]])->fetch_assoc()["username"]." adminfelülete");
    ?>
</head>
<body>
    <header><?php MakeAdminNav();  // => components/functions.php (189)?></header>
    <main>
        <h1>Adminok tevékenysége</h1>
        <h2>Adminok aktivitása</h2>
        <?php
            GetAdminActivities();
        ?>
        <?php?>

    </main>
        <?php MakeAdminFooter();?>
    <?php MakeMarkings("home"); // => components/functions.php(328)?>

</body>
</html>
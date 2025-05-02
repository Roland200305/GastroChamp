<?php
    require_once "../functions.php";
    MakeNav(false);
    $id=Validate(false);
    if(isset($_POST["logout"])){
        CancelCookie("id");
        header("Location: ../../index.php");
    }
    if(isset($_POST["del_not"])){
        DBSafeUpdate("notifications", "seen=?","userid=?",[-1,$_COOKIE["id"]]);
    }
    
    
    function GetUserNotifications($userid){
        global $conn;
        $notifs=DBSafeSearch("notifications","userid = ? AND seen!=? ORDER BY id DESC",[$userid,-1]);
        if(mysqli_num_rows($notifs)==0){
            echo"<h2>Nincsenek értesítéseid!</h2>";
        }
        echo "<div class='notifications'>";
        
        while($ertesites=$notifs->fetch_assoc()){
            $new=$ertesites["seen"]==0 ? "new" : "";
            echo"<div class='$new'>$ertesites[notiftype]<span class='howlongago'>".GetTimeElapsed($ertesites["notiftime"])."</span></div>";
        }
        echo"</div>";
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
        
        CallCSS("../../css/settings.css");

        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Kezelőfelület");
    ?>
</head>
<body><main>
<form action="#" method="post">
    <button class='ban' type="submit"  class='ban' name="logout"><?php MakeIcon("Switch-off");?><span>Kijelentkezés</span></button>
    <h1>Értesítéseid</h1>
    <button class='make' type="submit" name='del_not'><?php MakeIcon("Trash");?><span>Értesítések törlése</span></button>
</form>

<?php
    GetUserNotifications($_COOKIE["id"]);
?>

</main>
    <?php
        MakeFooter(false);
    ?>
</body>
</html>
<?php 
    CallJS("../../js/buttons.js");
    DBSafeUpdate("notifications", "seen=?", "userid = ? AND seen = ?",[1,$_COOKIE["id"],0]);
?>



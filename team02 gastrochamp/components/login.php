<?php
    require_once 'functions.php';
    //--------------------------------Regisztráció------------------------------//
    if(isset($_GET["landed"])){
        $expirationdate=time()+10*365*24*3600; //10 évig tart
        setcookie("landed", "yes",$expirationdate,"/");
    }else{
        if(!isset($_COOKIE["landed"])){
            header("Location: landing-page.php");
        }
    }
    if(isset($_POST["reg-btn"])){
        $talalatok=DBSafeSearch("users", "username = ?",[$_POST["user"]]);
        if(mysqli_num_rows($talalatok)>0){
           Message("Foglalt felhasználónév"); 
        }
        else{
            if($_POST["pw"]!=$_POST["pw-again"]){
                Message("Nem egyező jelszavak!");
            }
            else{
                $pw_secure=password_hash($_POST["pw"],PASSWORD_DEFAULT);
                 DBSafeInsert("users",[NULL,$_POST["user"],$_POST["email"],"$pw_secure",0,'Tanulóséf','logo.svg',0,0]);
                 $keresett=DBSafeSearch("users","username = ?",["$_POST[user]"])->fetch_assoc();
                 setcookie('id',$keresett['id'],time()+36000,"/");
                 header("Location: ../index.php");
            }
        }
    }
    //--------------------------------!Regisztráció------------------------------//

    //--------------------------------Bejelentkezés------------------------------//
    if(isset($_POST["log-btn"])){
        $talalt_felhasznalo = DBSafeSearch("users", "username = ?",[$_POST["username"]]);
        $felhasznalo = $talalt_felhasznalo->fetch_assoc();
        if(CheckForUserBans($felhasznalo["id"])){
            Message("Tiltás alatt állsz.");
        }
        else{
            if(mysqli_num_rows($talalt_felhasznalo) == 1){
                if(password_verify($_POST['password'], $felhasznalo['password'])){
                    $log_ido= isset($_POST["reminder"]) ? time()+(86400*365) : time()+86400;
                    setcookie('id', $felhasznalo['id'], $log_ido, "/");
                    header("Location: ../index.php");
                }
                else{
                    Message('Helytelen jelszó!');
                }
            }
            else{
                Message('Nincs ilyen felhasználó!');
            }
        }
    }
    //-------------------------------!Bejelentkezés------------------------------//

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        SetCharset("UTF-8");
        InitializeViewport();        
        MakeDevCredits();
        MakeSEOVisibility("GastroChamp belépés, Gastrochamp regisztráció,$kozos_seo_cuccok");
        MakePageDescription();


        CallCSS("../css/login.css");
        CallCSS("../css/nav.css");
        CallCSS("../css/svg.css");
        
        MakePageIcon("../img/site/favicon.svg");
        MakePageTitle("GastroChamp");
    ?>
</head>
<body>
    <div class="wrap clearfix">
        <div class="glass">
            <div class="panel">
                <h1 id="greet"></h1>
                <p id="pass"></p>
                <ul id = "recommendations">
                    <li id="min"><?php MakeIcon("X"); MakeIcon("OK");?>Minimum 8 karakterből áll</li>
                    <li id="num"><?php MakeIcon("X"); MakeIcon("OK");?>Tartalmaz számot</li>
                    <li id="schar"><?php MakeIcon("X"); MakeIcon("OK");?>Tartalmaz speciális karaktert</li>
                    <li id="caps"><?php MakeIcon("X"); MakeIcon("OK");?>Tartalmaz kis- és nagybetűt egyaránt</li>
                    <li id="eq"><?php MakeIcon("X"); MakeIcon("OK");?>Egyezik a két jelszó</li>

                    <li id="pwscale"> <h2>Jelszó erőssége: </h2></li> 
                    <li><span id="hats"></span></li>
                    <li><h2 id="rating"></h2></li>
                </ul>
                <p id="switching"><p>
            </div>
        </div>

         <form action="login.php" id="r" method="post" action="login.php">
            <h1>Regisztráció</h1>
            <input type="text" name="user" placeholder="Felhasználónév(max. 10 karakter)"  length="10" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="pw" id="pw" placeholder="Jelszó" required>
            <input type="password" name="pw-again" id="pw-again" placeholder="Jelszó újra" required>
            <div class="aszf"><input type="checkbox" name="aszf" id="aszf" required><label for="aszf">Elolvastam és elfogadom a ÁSZF-et, illetve az Adatvédelmi Nyilatkozatot</label></div>
            <input type="submit" value="Regisztráció" name="reg-btn" id="reg-btn" >
        </form>
    
        <form action="login.php" id="l" method="post" action="login.php">
            <h1>Bejelentkezés</h1>
            <input type="text" name="username" required placeholder="Felhasználónév">
            <input type="password" name="password" class="password-l" required placeholder="Jelszó">
            <div class="remind"><input type="checkbox" name="reminder" id="reminder"><label for="aszf">Emlékezz rám!</label></div>

            <input type="submit" name="log-btn" value="Bejelentkezés" id="log-btn">
        </form>
    </div>
</body>
   

</html>
<?php
    CallJS("../js/login.js");
?>
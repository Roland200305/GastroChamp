
    <?php
    require_once "../functions.php";
    if($_GET["keresett"]!=""){
        if($_GET["type"]=="word"){
            $lekerdezes=DBSearch("swears WHERE word LIKE '%$_GET[keresett]%'");
            echo"<h2>Eddig bejegyzett szavak</h2>";
            while($szo=$lekerdezes->fetch_assoc()){
                $feltolto=DBSafeSearch("users","id = ?",[$szo["adminid"]])->fetch_assoc();   
                echo "<p class='item'>$szo[word]</p>";
            }
        }
        else if($_GET["type"]=="tool"){
            $lekerdezes=DBSearch("tools WHERE name LIKE '%$_GET[keresett]%'");
            echo"<h2>Eddig bejegyzett eszközök</h2>";
            while($tool=$lekerdezes->fetch_assoc()){
                $feltolto=DBSafeSearch("users","id = ?",[$tool["adminid"]])->fetch_assoc();   
                echo "<p class='item'>$tool[name]</p>";
            }
        }
        else if( $_GET["type"]=="ingredient"){
            $lekerdezes=DBSearch("ingredients WHERE name LIKE '%$_GET[keresett]%'");
            echo"<h2>Eddig bejegyzett eszközök</h2>";
            while($ingredient=$lekerdezes->fetch_assoc()){
                $feltolto=DBSafeSearch("users","id = ?",[$ingredient["adminid"]])->fetch_assoc();   
                echo "<p class='item'>$ingredient[name] ($ingredient[scale])</p>";
            }
        }
    }
    
?>

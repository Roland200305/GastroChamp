<?php
    require_once "../functions.php";
    if($_GET["keresett"]!=""){
        $lekerdezes=DBSearch("tools WHERE name LIKE '%$_GET[keresett]%'");
        $array=json_decode($_GET["array"],true);
        while($talalat=$lekerdezes->fetch_assoc()){
            if(count($array)==0){
                MakeTagSelector(ucfirst($talalat["name"]),"tool-$talalat[id]","tools[]");
            }
            else{
                if(!in_array($talalat["name"],$array)){
                    MakeTagSelector(ucfirst($talalat["name"]),"tool-$talalat[id]","tools[]");
                }
            }
        }
    }
?>
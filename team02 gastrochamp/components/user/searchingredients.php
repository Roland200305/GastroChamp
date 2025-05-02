<?php
    require_once "../functions.php";
    if($_GET["keresett"]!=""){
    $lekerdezes=DBSearch("ingredients WHERE name LIKE '%$_GET[keresett]%'");
    $array=json_decode($_GET["array"],true);
    while($talalat=$lekerdezes->fetch_assoc()){
            if(count($array)==0){
                MakeTagSelector(ucfirst($talalat["name"]),"ingredient-$talalat[id]","ingredients[]");
            }
            else{
                if(!in_array($talalat["name"],$array)){
                    MakeTagSelector(ucfirst($talalat["name"]),"ingredient-$talalat[id]","ingredients[]");
                }
            } 
        }
    }
    
?>
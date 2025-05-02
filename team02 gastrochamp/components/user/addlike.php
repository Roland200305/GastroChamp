<?php
    require_once "../functions.php";
    $id=Validate(false);
    
    $recept= DBSafeSearch("recipe", "foodid = ?", [$_GET["recipeid"]])->fetch_assoc();
    $food=DBSafeSearch("foods", "id = ?", [$recept["foodid"]])->fetch_assoc();
    $szam=mysqli_num_rows(DBSafeSearch("likes","recipeid = ? AND userid = ?",[$_GET["recipeid"], $id]));
    if($szam==0){
        if($id!=$food["uploaderid"]){
            DBSafeInsert("likes",[NULL,$id,$_GET["recipeid"]]);
            GivePointsToUser($food["uploaderid"],1);
            SendNotificationForUser($food["uploaderid"],'like-olta a '.$food["name"].' receptedet.',$id);
        }
        if(isset($_COOKIE["adminid"])){
            DBSafeUpdate("recipe", "id=?",[$recipe["id"]]);
            DBSafeUpdate("food", "id=?",[$recipe["foodid"]]);
        }
    }
    else{
        DBSafeDelete("likes","recipeid=? AND userid=?",[$_GET["recipeid"], $id]);
        GivePointsToUser($food["uploaderid"],(-1));
    }
    header("Location: recipe.php?recipeid=$_GET[recipeid]");
?>
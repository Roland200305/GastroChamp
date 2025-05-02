<?php
    require_once "../functions.php";

    $id=Validate(false);
    $user=WhoIsIt($id);
    $random=mysqli_num_rows(DBSafeSearch("recipe","",[]));
    if(isset($_POST["btn"])){
        $hiba=false; //változó a hiba észleléséhez
        $difficulty=0; // az érték amelyből az algoritmus a nehézségét fogja kiszámolni az étel elkészítésének
        
        $nev=explode(" ",$_POST["name"]);
        foreach($nev as $key => $value){
            if(WordOK($value)==0){  
                PenaliseUser($id,"Inadekvát nyelvezet használata az étel elnevezésénél",true);
                Message("A recept elnevezésében sértő kifejezést találtunk.");
                $hiba=true;
                break;
            }
        }
        $tagek=$_POST["tagek"];
        $tagcount=count($_POST["tagek"]);

        $tags="";
        foreach ($tagek as $key => $value) {
            $tags.="$value ";
        }
        $tags=trim($tags);

        
        
        // Pontok állítása a hozzávalók száma alapján
        $ingredientlist=$_POST["ingredients"];
        $ingredientcount=count($ingredientlist);
        $counter=1;
        $ingredients="";
        $scaleslist=$_POST["scales"];
        if($ingredientcount!=count($scaleslist)){
            $hiba=true;
            PenaliseUser($id,"Hiányosan töltötte ki a receptleírást",true);
        }

        foreach($ingredientlist as $key => $value){
            foreach($scaleslist as $nev => $szam){
                if($nev==$value){
                    $cucc=DBSafeSearch("ingredients","name = ?",[$value])->fetch_assoc();
                    if($counter<$ingredientcount){
                        $ingredients.="$szam $cucc[scale] $value # ";
                    }
                    else{
                        $ingredients.="$szam $cucc[scale] $value";
                    }
                    $counter++;
                }
            }
        }
        $ingredients=trim($ingredients);
        //Nehézség számolása az összetevők száma alapján
        switch(true){
            case ($ingredientcount>=13):
                $difficulty+=10;
                break;
            case ($ingredientcount>=10):
                $difficulty+=7;
                break;
            case ($ingredientcount>=7):
                $difficulty+=5;
                break;
            case ($ingredientcount>=4):
                $difficulty+=3;
                break;
            case ($ingredientcount>1):
                $difficulty++;
                break;
            default:    
                Message("Nincs elég hozzávaló!");
                $hiba=true;
                break;

        }




        $toollist=$_POST["tools"];
        $toolcount=count($toollist);
        $counter=1;
        $tools="";
        
        foreach($toollist as $key => $value){
            if($counter<$toolcount){
                $tools.="$value # ";
            }
            else{
                $tools.="$value";
            }
            $counter++;
        }
        $tools=trim($tools);
        // Pontok állítása eszközök száma alapján

        switch (true) {
            case ($toolcount >= 5):
                $difficulty += 5;
                break;
            case ($toolcount >= 3):
                $difficulty += 3;
                break;
            case ($toolcount >= 1):
                $difficulty += 1;
                break;
            default:
                $hiba=true;
                Message("Nincs elég eszköz");
                break;
        }
        

        //Recept lépések összeírása
        $steplist=$_POST["steps"];
        $stepcount=count($steplist);
        $counter=1;
        $steps="";
        foreach ($steplist as $item => $step) {
            
            if($step==""){
                continue;
            }
            foreach(explode(" ",$step) as $key => $value){
                if(!WordOK($value)){
                    PenaliseUser($id,"Inadekvát nyelvezet használata a lépések közt",true);
                    Message("A recept elkészítésének lépései közt sértő kifejezést találtunk.");
                    $hiba=true;
                    break;
                }
            }
            if($counter<$stepcount){
                $steps.="$step #";
            }
            else{
                $steps.="$step";
            }
            $counter++;
        }
        
        //Pontok állítása a lépések száma alapján 

        $steps=trim($steps);
        switch(true){
            case ($stepcount>=15):
                $difficulty+=5;
                break;
            case ($stepcount>=8):
                $difficulty+=3;
                break;
            case ($stepcount>=1):
                $difficulty+=1;
                break;
            default:
                Message("Nem írtál lépéseket!");
                $hiba=true;
                break;
        }
    
        //Pontok állítása elkészítési idő alapján
        $ido=$_POST["makingtime"];
        switch (true) {
            case $ido>=120:
                $difficulty+=5;
                break;
            case $ido>=60:
                $difficulty+=4;
                break;
            case $ido>=30:
                $difficulty+=3;
                break;
            case $ido>=15:
                $difficulty+=2;
                break;
            case $ido>0:
                $difficulty+=1;
                break;
            default:
                $hiba=true;
                Message("Nem adtál meg időt!");
                break;
        }
        
        
        if($hiba==false){
            if(isset($_FILES['kep'])){
                if(in_array(mime_content_type($_FILES['kep']['tmp_name']),$elfogadott_formatumok)){
                    $file_name = $_FILES['kep']['name']; // Fájl neve 
                    $tmp_name = $_FILES['kep']['tmp_name']; // Fájl ideiglenes neve 
                    $mappa = getcwd();
                    $unique_filename=time()."_".uniqid()."_".$file_name;//egyedi név minden képfájl számára
                    $eleresi_ut = $mappa."/../../img/uploads/".$unique_filename;
                        
                    if(move_uploaded_file($tmp_name, $eleresi_ut)){
                        Message($eleresi_ut);
                        //receptfeltöltés
                        $recipecount=mysqli_num_rows(DBSafeSearch("foods","",[]));

                        DBSafeInsert("recipe",[NULL,$recipecount+1,"$ingredients","$tools",$ido,$_POST["portions"],"$steps",0]);

                        //ételfeltöltés
                        DBSafeInsert("foods",[$recipecount+1,$id,$_POST["name"],"$unique_filename",$difficulty,"$tags",0]);
                        Message("Sikeres receptfeltöltés!");
                    }
                    else{
                        echo "A fájl feltöltése sikertelen!";
                    }
                }
                else{
                    PenaliseUser($user["id"], "Hibás fájlformátumot töltött fel!");
                    Message("Hibás fájlformátum! Kérjük képet töltsön fel!");
                }
            }
            else{
                PenaliseUser($user["id"],"Nem csatolt képet a feltöltött recepthez!",true);
                Message("Nem csatolt képet a feltöltendő recepthez, ezért kapott 1 büntetőpontot.");
            }   
        }
        
        // TestOutput(print_r($kiirando)); 
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
        SetSEOKeywords("Recept hozzáadása","Oszd meg receptjeid!,$kozos_seo_cuccok");
        MakePageDescription();

        CallCSS("../../css/addrecipe.css");
        
        MakePageIcon("../../img/site/favicon.svg");
        MakePageTitle("Recept hozzáadása");
    ?>
    
   
</head>
<body>
    <header>
        <?php MakeNav(false); // => components/functions.php (110)?>    
    </header>
    <main>
    <h1>Receptfeltöltés</h1>
    <form action="addrecipe.php?userid=<?=$_COOKIE["id"];?>" method="post" enctype="multipart/form-data">
        <div class="adding-name">
            <h2>Étel neve</h2>
            <input type="text" name="name" id="" required placeholder='Ide írja az étele nevét'>
        </div>
        <div class="ingredients adding">
            <h2>Szükséges összetevők</h2>
            <div class="ingredients-checked">
            <h3 id='fejlec-i'>Kijelöltek</h3>
            </div>
            <div class="ingredient-palette">
                <h3>Kijelölhetők keresése</h3>    
            <input type="text" name="" id="search-i" placeholder='Kezdjen el gépelni a kereséshez...'>
            <div id="found-i"></div>
            </div>
        </div>

        <div class="tools adding">
            <h2>Szükséges eszközök</h2>
            <h3 id='fejlec-t'>Kijelöltek</h3>
            <div class="kijeloltek">
                
            </div>

            <div class="kijelolhetok">
                <h3>Kijelölhetők keresése</h3>
                <input type="text" name="" id="search-t" placeholder='Kezdjen el gépelni a kereséshez...'>
                <div id="foundt"></div>
            </div>
        </div> 
        
        
        
        <div class="steps adding">
            <h2>Lépések</h2>
            <textarea name="steps[]" rows="1" id="" class="noenter" placeholder="Írja be az elkészítés következő lépését ide!"></textarea>
            <div class="plus"id="add-step"><?php echo MakeIcon("Add");?></div>
        </div>
        <div class="labels">
            <h2>Címkék</h2>
            <ul class="tagek" style='width: 90%;'>
            <?php
                $talalatok=DBSafeSearch("categories","",[]);
                while($tag=$talalatok->fetch_assoc()){
                    MakeTagSelector($tag["catname"],"szuro-$tag[catid]","tagek[]"); // => components/functions.php (159)
                }
            ?>
            </ul>
        </div>
        <div class="other">
            <div class="ttm">
                <h2>Elkészítési idő</h2>
                <input type="number" name="makingtime" id="" min="1" required><label>perc</label>
            </div>
            <div class="ttm">

                <h2>Adagok száma</h2>
                <input type="number" name="portions" id="" min="1" required><label>adag</label>
            </div>
        </div>

        <div class="food-img">
            <h2>Fénykép</h2>
            <?php
                $kiirando_formatumok=[];
                foreach($elfogadott_formatumok as $key =>$value){
                    $f=".".trim(strpbrk($value,"/"),"/");
                    array_push($kiirando_formatumok,$f);
                }
                $formatumok_string=implode(", ",$kiirando_formatumok);
            ?>
            <input type="file" name="kep" required accept="<?=$formatumok_string;?>"value="Fénykép feltöltése(elfogadott formátumok: <?=$formatumok_string;?>)">
        </div>
        <button type="submit" name="btn" class="upload"><?php echo MakeIcon("Upload");?><span>Recept feltöltése</span></button>
       
    </form>
    </main>
        <?php MakeFooter(false); // => components/functions.php (164);?>
</body>
</html>
<?php
    MakeMarkings("add");// => components/functions.php(328)
    CallJS("https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js");

    CallJS("../../js/addrecipe.js");
    CallJS("../../js/buttons.js");
?>

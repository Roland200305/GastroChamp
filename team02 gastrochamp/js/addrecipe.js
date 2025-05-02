document.addEventListener('DOMContentLoaded', function() {
    const searchI = document.getElementById("search-i");
    const searchT = document.getElementById("search-t");
    const tagek = document.querySelectorAll(".szurok");
    const everythingWeNeed=document.querySelector(".steps");
    const addBtn= document.getElementById("add-step");
    const S_I_Section=document.querySelector(".ingredients-checked");
    const S_T_Section=document.querySelector(".tools.adding .kijeloltek");
    const foundT=document.getElementById("foundt");
    const foundI=document.getElementById("found-i");
    const headerT=document.getElementById("fejlec-t");
    const headerI=document.getElementById("fejlec-i");
    const inputs = document.querySelectorAll("input");
    const uploadButton = document.querySelector("button.upload");
    const svg = uploadButton.querySelector("svg");
    const span = uploadButton.querySelector("span");

 


    uploadButton.addEventListener("mouseenter",() => {
        svg.style.fill=`var(--accent)`; 
        uploadButton.style.backgroundColor=`var(--primary)`;
        span.style.color=`var(--accent)`;
        uploadButton.style.borderColor=`var(--accent)`;
    })
    uploadButton.addEventListener("mouseleave", () => {
        svg.style.fill=`var(--primary)`;
        uploadButton.style.backgroundColor=`var(--accent)`;
        span.style.color=`var(--primary)`;
        uploadButton.style.borderColor=`transparent`;
    })

    inputs.forEach((inp) => {
        inp.addEventListener("keypress", (e) => {
            if(e.key==="Enter"){
                e.preventDefault();
            }
        });
    });
    
    headerI.style.display='none';
    headerT.style.display='none';
    let stepcount=1;
    let selectedIngredients = [];
    let selectedTools = [];

    
    // Új lépés hozzáadása gomb
    addBtn.addEventListener("click", () => {
    const allSteps = document.querySelectorAll("textarea.noenter");
    let allFilled = true;

    allSteps.forEach(textarea => {
        // Ha üres, jelöljük pirossal
        if (textarea.value.trim() === "") {
            textarea.style.border = "2px solid red";
            textarea.style.backgroundColor = "#ffe6e6"; 
            textarea.placeholder="Nem írtál ide semmit!"
            allFilled = false;
        } else {
            // ha már ki van töltve, visszaállítjuk
            textarea.style.border = "";
            textarea.style.backgroundColor = "";
        }
    });

    if (!allFilled) {
        return; // ne adjunk hozzá új mezőt
    }

    // Ha minden ki van töltve, új mező hozzáadása
    const txt = document.createElement("textarea");
    txt.name = "steps[]";
    txt.rows = 1;
    txt.placeholder = "Következő lépés:";
    txt.id = "step-" + stepcount;
    txt.classList.add("noenter");

    // Enter tiltása az új textarea-n is
    txt.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
        }
    });

    //Ha minden ok akkor beillesztjük a helyére a létre hozott textarea-t
    everythingWeNeed.insertBefore(txt, addBtn);
    stepcount++;
});
    
    //Összetevők listázása keresőmező tartalma alapján
    if (searchI) {
        searchI.addEventListener("input", (e) => {
            const searchTerm = e.target.value;
            let array=encodeURIComponent(JSON.stringify(selectedIngredients));
            $("#found-i").load("searchingredients.php?keresett=" + searchTerm + "&array=" + array, function() {
                setupIngredientClickHandlers();
            });

        });
    }

    //Eszközök listázása -||-
    if (searchT) {
        searchT.addEventListener("input", (e) => {
            const searchTerm = e.target.value;
            let array=encodeURIComponent(JSON.stringify(selectedTools));
            $("#foundt").load("searchingtools.php?keresett=" + searchTerm + "&array=" + array, function() {
                setupToolClickHandlers();
            });
        });
    }

    tagek.forEach((tag) => {
        tag.addEventListener("click", () => {
            if(tag.classList.contains("active")){
                tag.classList.remove("active");
            }
            else{
                tag.classList.add("active");
            }

        });
    });

    function setupIngredientClickHandlers() {
        if (foundI) {
            const ingredients = foundI.querySelectorAll(".szurok");
            ingredients.forEach(ingredient => {
                ingredient.addEventListener("click", function() {
                    toggleSelection(this, selectedIngredients);
                    refreshHeader(headerI,selectedIngredients);
                });
            });
        }
    }
   
    function setupToolClickHandlers() {
        const foundTools = document.querySelector("#foundt");
        if (foundTools) {
            const tools = foundTools.querySelectorAll(".szurok");
            tools.forEach(tool => {
                tool.addEventListener("click", function() {
                    toggleSelection(this, selectedTools);
                    refreshHeader(headerT,selectedTools);

                });
            });
        }
    }
    function refreshHeader(header, array){
        if(array.length!=0){
            header.style.display='block';
        }
        else{
            header.style.display='none';
        }
    }
    function toggleSelection(element, selectedArray) {
        
        if (element.classList.contains("tagged")) {
            element.classList.remove("tagged");
            const index = selectedArray.indexOf(element.textContent);
            if (index > -1) {
                selectedArray.splice(index, 1);
            }
            if(selectedArray==selectedTools){foundT.appendChild(element.parentNode);}
            else{foundI.appendChild(element.parentNode);}
        } else {
            element.classList.add("tagged");
            selectedArray.push(element.textContent);
        }
        addToSelectedOnes(element,selectedArray);
        console.log(selectedArray);
    }

    //hozzáadás a kiválasztottakhoz (elem típusa alapján)
    function addToSelectedOnes(element, givenArray) {
        const parentElement = element.parentNode;
    
        if (givenArray == selectedTools) {
            if (element.classList.contains("tagged")) {
                S_T_Section.appendChild(parentElement);
            } else {
                if (S_T_Section.contains(parentElement)) {
                    parentElement.remove(); // biztonságos eltávolítás
                }
            }
        }
    
        if (givenArray == selectedIngredients) {
            if (element.classList.contains("tagged")) {
                S_I_Section.appendChild(parentElement);
                console.log(parentElement.innerHTML);
            } else {
                if (S_I_Section.contains(parentElement)) {
                    parentElement.remove(); // biztonságos eltávolítás
                }
            }
        }
    }

    document.querySelectorAll("textarea.noenter").forEach((textarea) => {
        textarea.addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
        });
    });
});




document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".szurok");
  const foodItems = document.querySelectorAll(".tile");
  let activeTags = [];
  let activeDifficulty = null;
  let selected=[];

  // Szűrők hozzáadása tagekre és csillagokra kattintva
  filters.forEach(filter => {
      filter.addEventListener("click", function () {
          if (this.classList.contains('s')) {
              // Csillagokra (nehézség) való kattintás
              const selectedDifficulty = this.textContent.trim();

              // Ha a kattintott csillag már aktív, deaktiváljuk (toggle viselkedés)
              if (activeDifficulty === selectedDifficulty) {
                  activeDifficulty = null;
                  this.classList.remove("searched");
                  var star=this.querySelector("star");
                  this.classList.remove("fb"); // Visszaállítja a formázást
              } else {
                  // Egyszerre csak egy csillag lehet aktív
                  activeDifficulty = selectedDifficulty;
                  clearDifficultySelection(); // Korábbi csillag formázásának eltávolítása
                  this.classList.add("searched");
                  this.classList.add("fb") ;// Aktív formázás hozzáadása
              }
          } else {
              // Tag-ek kezelése
              const tag = this.textContent.trim();
              if (activeTags.includes(tag)) {
                  activeTags = activeTags.filter(t => t !== tag);
                  selected = selected.filter(s=>s!==tag);
                  this.classList.remove("searched"); // Visszaveszi az aktív class-t
              } else {
                  activeTags.push(tag);
                  selected.push(tag);
                  this.classList.add("searched"); // Aktív class hozzáadása
              }
          }
          filterRecipes(); // Szűrés minden esetben
      });
  });

  

  // A szűrési logika
  function filterRecipes() {
      foodItems.forEach(item => {
          const itemTags = item.getAttribute("category").split(" ");
          const itemDifficulty = item.getAttribute("difficulty");
          const foodTags=item.querySelectorAll(".tag");
          foodTags.forEach((tag) => { 
            if(selected.includes(tag.textContent)){
                tag.classList.add("tagged");
            }
            else{
                tag.classList.remove("tagged");
            }
        });
          // Szűrés tagek és nehézségi szint alapján
          const matchesTags = activeTags.length === 0 || activeTags.every(tag => itemTags.includes(tag));
          const matchesDifficulty = !activeDifficulty || itemDifficulty === activeDifficulty;
          if (matchesTags && matchesDifficulty) {
            item.classList.remove("rejtett");
          } else {
            item.classList.add("rejtett");
          }
      });
  }
  // Egyetlen csillag formázása, korábbi kijelölések eltávolítása
  function clearDifficultySelection() {
      filters.forEach(filter => {
          if (filter.classList.contains('s')) {
              filter.classList.remove("searched");
              filter.classList.remove("fb"); // Eltávolítja az összes korábbi formázást a csillagoknál
          }
      });
  }
});

document.getElementById('scroll-left').addEventListener('mousedown', function() {
    var gap = window.innerWidth >= 576 ? 260 : window.innerWidth*0.7; 

    document.querySelector('.scrolling-menu').scrollBy({
      left: -gap, // balra mozgatás
      behavior: 'smooth'
    });
  });
  
document.getElementById('scroll-right').addEventListener('mousedown', function() {
    var gap = window.innerWidth >= 576 ? 260 : window.innerWidth*0.7; 

    document.querySelector('.scrolling-menu').scrollBy({
      left: gap, // jobbra mozgatás
      behavior: 'smooth'
    });
  });
  

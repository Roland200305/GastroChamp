document.addEventListener('DOMContentLoaded', function() {
    const recipesButton = document.querySelector('.statistics .their.recipes');
    const favouritesButton = document.querySelector('.statistics .their.favourites');
    const recipesDiv = document.getElementById('recipes');
    const favouritesDiv = document.getElementById('favourites');
    const rankingsButton = document.querySelector('.statistics .their.rank');
    const rankingsDiv=document.getElementById('rank');
    const stars = document.querySelector(".stars");
    const top=document.querySelector(".topside");
    const hrs=document.querySelectorAll("hr");

    function showRecipes() {
        recipesDiv.style.display = 'flex';
        favouritesDiv.style.display = 'none';
        rankingsDiv.style.display= 'none';
        recipesButton.classList.add('active');
        favouritesButton.classList.remove('active');
        rankingsButton.classList.remove('active');
        stars.style.display="flex";
        top.style.display="flex";
        //ChangeHrs(true);
    }

    function showFavourites() {
        recipesDiv.style.display = 'none';
        rankingsDiv.style.display= 'none';
        favouritesDiv.style.display = 'flex';
        favouritesButton.classList.add('active');
        recipesButton.classList.remove('active');
        rankingsButton.classList.remove('active');
        stars.style.display="flex";
        top.style.display="flex";
       // ChangeHrs(true);
    }
    function showRank(){
        rankingsDiv.style.display = 'block';
        recipesDiv.style.display = 'none';
        favouritesDiv.style.display = 'none';
        rankingsButton.classList.add('active');
        favouritesButton.classList.remove('active');
        recipesButton.classList.remove('active');
        stars.style.display="none";
        top.style.display="none";
       // ChangeHrs(false);
    }

    recipesButton.addEventListener('click', showRecipes);
    rankingsButton.addEventListener('click', showRank);
    favouritesButton.addEventListener('click', showFavourites);

    showRecipes();
});
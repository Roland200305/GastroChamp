const l= document.getElementById('l');
const r= document.getElementById('r');
const min = document.getElementById('min');
const num= document.getElementById('num');
const schar = document.getElementById('schar');
const caps = document.getElementById('caps');
const recommendations=document.getElementById('recommendations');
const pw=document.getElementById("pw");
const pwAgain=document.getElementById("pw-again");
const switching = document.getElementById("switching");
const greet=document.getElementById("greet");
const okays=document.querySelectorAll(".ok");
const nopes = document.querySelectorAll(".x");
const pass = document.getElementById("pass");
const rating=document.getElementById("rating");
const pwgrades=["Nagyon gyenge", "Gyenge", "Közepes", "Erős", "Nagyon erős"];
const colors=["#FF0000","#FFA500","#FFFF00","#9ACD32","#008000"];
const hats=document.getElementById("hats");
const pwscale=document.getElementById("pwscale");
const aszf=document.getElementById("aszf");
const regBtn=document.getElementById("reg-btn");
var aszfszamolo=0;
regBtn.disabled=true;
regBtn.value=aszfszamolo%2==0 ? "^^Fogadd el!^^" : "Regisztráció";

var isEverythingFilled = pw.value!="";
// const eye=document.querySelector(".eye");
// const blind=document.querySelector(".blind");
const passwordLogin=document.querySelector(".password-l");
var egyeznek=pw.value===pwAgain.value;

// blind.style.display="none";
greet.textContent= `Üdvözlünk a GastroChamp oldalán!`;
switching.innerHTML= `Regisztráltál már? <a href="#" onclick="switchForm('l')">Jelentkezz be!</a>`;
pass.innerHTML= `A GastroChamp-et azért hoztuk létre, hogy bárki megmutathassa, mennyire jó a konyhában, amit a felhasználó rangja indikál. A fiókod jelszavához kövesd a következő irányelveket:`;
pwscale.style.display="none";
okays.forEach(item => {
    item.style.display="none";
});

aszf.addEventListener("input", () => {
    aszfszamolo=aszfszamolo+1;
    regBtn.disabled=aszfszamolo%2==0;
    regBtn.value=aszfszamolo%2==0 ? "^^Fogadd el!^^" : "Regisztráció";
});
pw.addEventListener("input", () => {
    pwscale.style.display="flex";
    let jelszo=pw.value;

    if(jelszo.length>=8){
        Tick(0);
    }
    else{
        Cross(0);
    }
    
    if(/[A-Z]/.test(jelszo)&& /[a-z]/.test(jelszo)){
        Tick(3); 
    }
    else{
        Cross(3);
    }
    
    if(/[0-9]/.test(jelszo)){
        Tick(1);
    }
    else{
        Cross(1);
    }
    
    if(/[!-/]/.test(jelszo)){
        Tick(2);
    }
    else{
        Cross(2);
    }

    let count = (jelszo.length>=8)+(/[!-/]/.test(jelszo))+(/[0-9]/.test(jelszo))+(/[a-z]/.test(jelszo) && /[A-Z]/.test(jelszo));
    var chef= `<svg class="chef" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
    <g id="SVGRepo_iconCarrier"> <path d="M7 5C4.23858 5 2 7.23858 2 10C2 12.0503 3.2341 13.8124 5 14.584V17.25H19L19 14.584C20.7659 13.8124 22 12.0503 22 10C22 7.23858 19.7614 5 17 5C16.7495 5 16.5033 5.01842 16.2626 5.05399C15.6604 3.27806 13.9794 2 12 2C10.0206 2 8.33961 3.27806 7.73736 5.05399C7.49673 5.01842 7.25052 5 7 5Z" fill="${colors[count]}"></path>
    <path d="M18.9983 18.75H5.00169C5.01188 20.1469 5.08343 20.9119 5.58579 21.4142C6.17157 22 7.11438 22 9 22H15C16.8856 22 17.8284 22 18.4142 21.4142C18.9166 20.9119 18.9881 20.1469 18.9983 18.75Z" fill="${colors[count]}"></path> </g></svg>`
    egyeznek=pw.value===pwAgain.value;
    
    if(egyeznek){
        Tick(4);
    }
    else{
        Cross(4);
    }
    hats.innerHTML=chef.repeat(count+1);
    rating.textContent=pwgrades[count];
});
pwAgain.addEventListener("input", () => {
    egyeznek=pw.value===pwAgain.value;
    if(egyeznek){
        Tick(4);
    }
    else{
        Cross(4);
    }
});


l.style.display="none";
function switchForm(){
    if(l.style.display == "none"){
        l.style.display = "flex";
        r.style.display = "none";
        greet.textContent=`Üdv újra a GastroChamp oldalán!`;
        switching.innerHTML=`Nincs fiókod? - <a href="#" onclick="switchForm('r')">Regisztrálj!</a>`;
        pass.innerHTML=`Gyere, lépj be és találd meg a következő kedvenc recepted, vagy oszd meg egy specialitásod másokkal! `
        recommendations.style.display="none";
    }
    else{
        l.style.display = "none";
        r.style.display = "flex";
        greet.textContent=`Üdvözlünk a GastroChamp oldalán!`;
        switching.innerHTML=`Regisztráltál már? - <a href="#" onclick="switchForm('l')">Jelentkezz be!</a>`;
        pass.innerHTML=`A GastroChamp-et azért hoztuk létre, hogy bárki megmutathassa, mennyire jó a konyhában, amit a felhasználó rangja indikál. A fiókod jelszavához kövesd a következő irányelveket:`;
        recommendations.style.display="block";
    }
}
function Tick(index){
    okays[index].style.display="inline-block";
    nopes[index].style.display="none";
}
function Cross(index){
    nopes[index].style.display="inline-block";
    okays[index].style.display="none";
}



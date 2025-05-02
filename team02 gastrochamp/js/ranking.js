"use strict";
const badges = document.querySelectorAll(".badge");
badges.forEach((item) => {
    item.addEventListener("mouseover", () =>{
        const rank = item.querySelector(".badge-rank");
        rank.style.opacity="1";
    });
    item.addEventListener("mouseout", () =>{
        const rank = item.querySelector(".badge-rank");
        rank.style.opacity="0";
    });
});
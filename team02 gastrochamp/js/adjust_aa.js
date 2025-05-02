document.addEventListener("DOMContentLoaded", () => {
    const svgs = document.querySelectorAll(".make svg");
    svgs.forEach(svg => {
        svg.classList.add("navicon");
        svg.classList.remove("addicon");
        svg.style.marginLeft=`8px`;
    });
});
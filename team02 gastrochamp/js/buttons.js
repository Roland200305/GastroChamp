const redBtns=document.querySelectorAll("button.ban");
const yellowBtns=document.querySelectorAll("button.make");

const btnChanger =[[redBtns,`red`],[yellowBtns,`var(--accent)`]];

btnChanger.forEach((list) => {
    list[0].forEach((button) => {
        if(!button.disabled){
            var svgs = button.querySelectorAll("svg");
            var span= button.querySelector("span");
            button.addEventListener("mouseenter",() => {
                svgs.forEach((svg) => {svg.style.fill=list[1];});
                button.style.backgroundColor=`var(--primary)`;
                span.style.color=list[1];
                button.style.borderColor=list[1];
            });
            button.addEventListener("mouseleave", () => {
                svgs.forEach((svg) => {svg.style.fill=`var(--primary)`;});
                button.style.backgroundColor=list[1];
                span.style.color=`var(--primary)`;
                button.style.borderColor=`transparent`;
            });
        }else{
            button.style.opacity=`.5`;
        }
    });
    
})
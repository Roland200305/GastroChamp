const arrowUp = document.getElementById("up");
const arrowDown = document.getElementById("down");
const steps = document.querySelectorAll(".lepes");
const elsoElem = steps[0];

let currentlyHighlighted = 0;
let currentOffset = 0;

arrowUp.classList.add("disabled");
elsoElem.classList.add("highlighted");

for (let i = 1; i < steps.length; i++) {
    steps[i].classList.add("disabled");
}

arrowUp.addEventListener("click", () => {
    if (currentlyHighlighted > 0) {
        currentlyHighlighted--;
        RefreshFocused("up");
        RefreshArrows();
    }
});

arrowDown.addEventListener("click", () => {
    if (currentlyHighlighted < steps.length - 1) {
        currentlyHighlighted++;
        RefreshFocused("down");
        RefreshArrows();
    }
});

function RefreshArrows() {
    arrowUp.classList.toggle("disabled", currentlyHighlighted === 0);
    arrowDown.classList.toggle("disabled", currentlyHighlighted === steps.length - 1);
}

function RefreshFocused(dir) {
    const prev = steps[currentlyHighlighted + (dir === "up" ? 1 : -1)];
    const current = steps[currentlyHighlighted];
    
    const shiftAmount = current.offsetHeight;

    if (dir === "down") {
        currentOffset -= shiftAmount;
    } else {
        currentOffset += shiftAmount;
    }

    elsoElem.style.marginTop = `${currentOffset}px`;

    prev.classList.remove("highlighted");
    prev.classList.add("disabled");

    current.classList.add("highlighted");
    current.classList.remove("disabled");
}
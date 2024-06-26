// Function to handle slider functionality
function setupSlider(carousel) {
    const arrowbtns = carousel.parentElement.querySelectorAll(".rightSide svg");
    const firstClassWidth = document.querySelector(".card").offsetWidth;

    arrowbtns.forEach(btn => {
        btn.addEventListener("click", () => {
            carousel.scrollLeft += btn.id === "left" ? -firstClassWidth : firstClassWidth;
        })
    });
    
    let isDragging = false;
    let startX, startScrollLeft;
    
    const dragStart = (e) => {
        isDragging = true;
        carousel.classList.add("dragging");
        startX = e.pageX;
        startScrollLeft = carousel.scrollLeft;
    }
    
    const dragging = (e) => {
        if (!isDragging) return;
        carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
    }
    
    const dragStop = () => {
        isDragging = false;
        carousel.classList.remove("dragging");
    }
    
    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener('mousemove', dragging);
    document.addEventListener("mouseup", dragStop);
    
}

// Find all carousels and set up each slider
const carousels = document.querySelectorAll(".carousel");

carousels.forEach(carousel => {
    setupSlider(carousel);
});

//redirecting to display gig page
document.addEventListener("DOMContentLoaded", function () {
    var clickableCards = document.querySelectorAll(".gigCard");
    
    clickableCards.forEach(function (card) {
        card.addEventListener("click", function () {
            var url = card.getAttribute("gig-url");

            if (url) {
                window.location.href = url;
            }else{
                alert("Undefined url");
            }
        });
    });
});



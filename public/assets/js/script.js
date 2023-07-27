// défilement de la navbar catergories avec la molette de la souris et fonction tactile mobile

const navbar = document.querySelector('.nav');
let isScrolling = false;
let startX;
let scrollLeft;

navbar.addEventListener('wheel', (event) => {
    event.preventDefault();
    navbar.scrollLeft += event.deltaY * 2; // Ajustez la valeur de défilement selon vos besoins
});

navbar.addEventListener('touchstart', (event) => {
    isScrolling = true;
    startX = event.touches[0].pageX - navbar.offsetLeft;
    scrollLeft = navbar.scrollLeft;
});

navbar.addEventListener('touchmove', (event) => {
    if (!isScrolling) return;
    event.preventDefault();
    const x = event.touches[0].pageX - navbar.offsetLeft;
    const walk = (x - startX) * 2; // Ajustez la valeur de défilement selon vos besoins
    navbar.scrollLeft = scrollLeft - walk;
});

navbar.addEventListener('touchend', () => {
    isScrolling = false;
});





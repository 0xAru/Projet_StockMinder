// Carousel

const carousel = document.getElementById("myCarousel");
const events = document.getElementsByClassName("my-event");

if (events && carousel) {

    const leftArrow = document.getElementById("leftArrow");
    const rightArrow = document.getElementById("rightArrow");
    const indicators = document.getElementsByClassName("my-indicator");
    let currentIndex = 0;


//Affichage de l'événement actif (index courant)
    function showEvent(index) {
        for (let i = 0; i < events.length; i++) {
            events[i].style.display = i === index ? "flex" : "none";
        }

        //Affichage ou non des flèches selon si l'événement actif est le premier, le dernier ou entre les deux

        leftArrow.style.display = index === 0 ? "none" : "block";
        rightArrow.style.display = index === events.length - 1 ? "none" : "block";

        //Classe active de l'indicateur pour afficher le style

        for (let i = 0; i < indicators.length; i++) {
            indicators[i].classList.toggle("active", i === index);
        }
    }

    function showNextEvent() {
        currentIndex = (currentIndex + 1) % events.length;
        console.log(currentIndex)
        showEvent(currentIndex);
    }

    function showPrevEvent() {
        currentIndex = (currentIndex - 1 + events.length) % events.length;
        console.log(currentIndex)
        showEvent(currentIndex);
    }

// Cacher tous les événements sauf le premier
    showEvent(currentIndex);

// Ajouter des écouteurs d'événements aux flèches
    leftArrow.addEventListener("click", showPrevEvent);
    rightArrow.addEventListener("click", showNextEvent);

// Ajouter des écouteurs d'événements aux indicateurs
    const indicatorContainer = document.getElementById("indicatorContainer");
    const indicatorItems = indicatorContainer.getElementsByClassName("my-indicator");
    for (let i = 0; i < indicatorItems.length; i++) {
        indicatorItems[i].addEventListener("click", () => showEvent(i));
    }
}
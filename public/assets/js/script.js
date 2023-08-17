let selects = document.querySelectorAll("select");
let burger = document.querySelector('.my-burger');
let menu = document.querySelector('.my-menu-container');

// défilement de la navbar catégories avec la molette de la souris et fonction tactile mobile


const navBar = document.querySelector('.nav');
let isScrolling = false;
let startX;
let scrollLeft;

navBar.addEventListener('wheel', (event) => {
    event.preventDefault();
    navBar.scrollLeft += event.deltaY * 2; // Ajustez la valeur de défilement selon vos besoins
});

navBar.addEventListener('touchstart', (event) => {
    isScrolling = true;
    startX = event.touches[0].pageX - navbar.offsetLeft;
    scrollLeft = navBar.scrollLeft;
});

navBar.addEventListener('touchmove', (event) => {
    if (!isScrolling) return;
    event.preventDefault();
    const x = event.touches[0].pageX - navbar.offsetLeft;
    const walk = (x - startX) * 2; // Ajustez la valeur de défilement selon vos besoins
    navBar.scrollLeft = scrollLeft - walk;
});

navBar.addEventListener('touchend', () => {
    isScrolling = false;
});



//positionnement de la barre de nav catégorie et du menu burger en fonction du scroll vertical

window.addEventListener('scroll', function() {

    // Hauteur à partir de laquelle nous voulons détecter le défilement (96px)
    const scrollThreshold = 96;

    if (window.scrollY > scrollThreshold) {
        navBar.classList.add("fixed-nav");
        burger.classList.add("fixed-menu");
        menu.classList.add("fixed-menu");


    } else {
        navBar.classList.remove("fixed-nav");
        burger.classList.remove("fixed-menu");
        menu.classList.remove("fixed-menu");

    }
});




selects.forEach(function (select) {
    let options = select.getElementsByTagName('option');

    select.addEventListener('focus', function () {

// Appliquer le style souhaité à chaque option
        for (let i = 0; i < options.length; i++) {
            options[i].style.backgroundColor = "var(--persian-orange)"; // Modifier la couleur d'arrière-plan du texte de toutes les options
            if (i === 0) {
                options[i].style.fontWeight = "bold"; // Mettre en gras le texte de la première option
            }
        }
    });
});


burger.addEventListener('click', () => {

    if (burger.classList.contains('my-closed')) {
        burger.src = "{{ asset('assets/img/burger-menu-cross.svg') }}";
        burger.classList.remove("my-closed");
        burger.classList.add("my-opened");
        burger.classList.add("burger-visible")
        burger.classList.remove("burger-hidden")
        menu.classList.remove("menu-hidden");
        menu.classList.add("menu-visible");

    } else {
        burger.src = "{{ asset('assets/img/burger-menu.svg') }}";
        burger.classList.remove("my-opened");
        burger.classList.add("my-closed");
        burger.classList.add("burger-hidden")
        burger.classList.remove("burger-visible")
        menu.classList.remove("menu-visible");
        menu.classList.add("menu-hidden");

    }
});

//suppression des paramètres dans la barre URL
function removeSearchParamFromURL() {
    let urlWithoutSearchParam = window.location.href.split('?')[0];
    history.replaceState({}, document.title, urlWithoutSearchParam);
}

// Attacher un événement au chargement de la page pour supprimer le paramètre 'search'
window.addEventListener('DOMContentLoaded', () => {
    removeSearchParamFromURL();
});


//Function de réinitialisation des filtres (non utilisée pour le moment)
function resetFilters() {

    let selects = document.querySelectorAll('select');
    let search = document.querySelector('.my-search-input');
    let submitBtn = document.querySelector('#submitBtn');

    selects.forEach(function (select) {
        select.value = "";
    })

    search.value = "";

    submitBtn.click();

}

const myButtons = document.querySelectorAll('.my-button');

myButtons.forEach((myButton) => {
    myButton.addEventListener('mouseup', () => {
        setTimeout(myButton.blur(), 100); // Enlever le focus pour restaurer la boîte d'ombre par défaut
    });
});


//Affichage de la contenance en cl
function capacityDisplay() {
    let capacityOptions = document.querySelectorAll(".my-capacity option");

    capacityOptions.forEach(option => {
        let capacity = option.innerHTML;

        // Vérifiez si la capacité a trois caractères
        if (capacity.length >= 3 && capacity.length <= 4) {
            // splice pour insérer une virgule après le deuxième caractère
            let newCapacity = capacity.slice(0, 2) + ',' + capacity.slice(2) + ' cl';
            option.innerHTML = newCapacity;
        }
    });
}

capacityDisplay();



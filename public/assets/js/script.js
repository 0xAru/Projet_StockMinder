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






// augmentation et diminution des quantités de produits commandés par le client-----------------------------------------

function minus(elem, index) {
    let stock = document.querySelector("#stock" + index);
    let quantity = document.getElementById("qty" + index)

    if (quantity.value > 0) {
        quantity.value--;
    }
}

function plus(elem, index) {
    let stock = document.querySelector("#stock" + index);

    let quantity = document.getElementById("qty" + index)

    if (stock.value > 0 && quantity.value < parseInt(stock.value)) {
        quantity.value++;
    }
}

//----------------------------------------------------------------------------------------------------------------------



// Affichage de la modale de description détaillée du produit

myInfoModal = document.querySelector(".my-info-modal");
let body = document.querySelector("body");


function infoModal(elem, index) {

    let openModalBtn = document.querySelector("#infoBtn" + index);
    let modal = document.querySelector("#infoModal" + index);


    modal.classList.remove("my-hidden");
    modal.classList.add("my-active");
    body.style.overflow = "hidden";

}

function closeInfoModal(elem, index) {

    let closeModalBtn = document.querySelector("#closeInfoModal" + index);
    let modal = document.querySelector("#infoModal" + index);


    modal.classList.add("my-hidden");
    modal.classList.remove("my-active");
    body.style.overflow = "visible";

}

// Affichage de la modale du panier

let modal = document.querySelector("#cartModal");

function cartModal(elem) {

    let openModalBtn = document.querySelector(".my-cart-btn");


    modal.classList.remove("my-hidden");
    modal.classList.add("my-active");
    body.style.overflow = "hidden";

}

function closeCartModal(elem) {

    let closeModalBtn = document.querySelector(".my-close-btn");


    modal.classList.add("my-hidden");
    modal.classList.remove("my-active");
    body.style.overflow = "visible";

}




// gestion du panier ----------------------------------------------------------------------------------------------

let parent = document.querySelector("#cartData");
let cartForm = document.querySelector("#cartForm");


//Fonction création du panier---------------------------------------------------------------
function createForm(elem, index){

    let productName = document.querySelector("#name" + index);
    let productId = document.querySelector("#id" + index);
    let productPrice = document.querySelector("#price" + index);
    let unitPrice = parseFloat(productPrice.innerHTML);
    let productQuantity = document.querySelector("#qty" + index);
    let productStock = document.querySelector("#stock" + index);
    let cartLine = document.querySelector("#bktLine" + index);
    let oneTotal = document.querySelector("#oneTotal" + index);
    let quantityInput = document.querySelector("#cartQty" + index);
    let idInput = document.querySelector("#cartId" + index);
    let qty = productQuantity.value;

    //Bouton submit du panier

    let submitBtn = document.createElement("button");
    submitBtn.id = "cartSubmitBtn";
    submitBtn.setAttribute("type", "submit");
    submitBtn.classList.add("fixed", "bottom-0")
    submitBtn.innerHTML = "Valider";
    cartForm.appendChild(submitBtn);

    //Création d'une nouvelle ligne du panier pour chaque nouvelle ref. de produit ajoutée

    if (!cartLine) {
        let cartLine = document.createElement("div");
        cartLine.classList.add("cart-line", "flex");
        cartLine.id = "bktLine" + index;
        cartForm.appendChild(cartLine);

        //product.id

        idInput = document.createElement("input");
        idInput.id = "cartId" + index;
        idInput.setAttribute("type", "text");
        idInput.style.width = "50px";
        idInput.style.height = "50px";
        idInput.style.backgroundColor = "orange"
        idInput.value = productId.innerHTML;
        cartLine.appendChild(idInput);

        //product.name

        let nameInput = document.createElement("input");
        nameInput.setAttribute("type", "text");
        nameInput.setAttribute("name", "name");
        nameInput.style.width = "50px";
        nameInput.style.height = "50px";
        nameInput.style.backgroundColor = "orange";
        nameInput.value = productName.innerHTML;
        cartLine.appendChild(nameInput);


        //product.price

        let priceInput = document.createElement("input");
        priceInput.setAttribute("type", "number");
        priceInput.id = "cartPrice" + index;
        priceInput.style.width = "50px";
        priceInput.style.height = "50px";
        priceInput.style.backgroundColor = "orange"
        priceInput.value = unitPrice;
        cartLine.appendChild(priceInput);

        //product.quantity

        let qtyContainer = document.createElement("div");
        cartLine.appendChild(qtyContainer);

        let cartMinus = document.createElement("button");
        cartMinus.setAttribute("type", "button");
        cartMinus.id = "bskMinus" + index;
        cartMinus.innerHTML = "-";
        qtyContainer.appendChild(cartMinus);
        cartMinus.addEventListener("click", () => {
            decreaseBsktQty(quantityInput, productQuantity, index, oneTotal, unitPrice)
        });

        let quantityInput = document.createElement("input");
        quantityInput.setAttribute("type", "number");
        quantityInput.id = "cartQty" + index;
        quantityInput.style.width = "50px";
        quantityInput.style.height = "50px";
        quantityInput.style.backgroundColor = "orange"
        quantityInput.value = productQuantity.value;
        qtyContainer.appendChild(quantityInput);

        let cartPlus = document.createElement("button");
        cartPlus.setAttribute("type", "button");
        cartPlus.id = "bskPlus" + index;
        cartPlus.innerHTML = "+";
        qtyContainer.appendChild(cartPlus);
        cartPlus.addEventListener("click", () => {
            increaseBsktQty(quantityInput, productStock, productQuantity, index, oneTotal, unitPrice)
        });

        oneTotal = document.createElement("input");
        oneTotal.type = "number";
        oneTotal.id = "oneTotal" + index;
        oneTotal.style.width = "50px";
        oneTotal.style.height = "50px";
        oneTotal.style.backgroundColor = "orange"
        cartLine.appendChild(oneTotal);

    } else { //Si ref. déjà ajoutée: augmentation de la quantité du produit dans le panier
        quantityInput.value = productQuantity.value;
    }
    oneTotal.value = unitPrice * qty;
}


//Fonction pour augmenter la quantité de produit depuis le panier
function increaseBsktQty(elem, productStock, productQuantity, index, oneTotal, unitPrice) {
    let qty = productQuantity.value;
    if (parseInt(elem.value) < productStock.value) {
        elem.value++;
        productQuantity.value++;
        qty = productQuantity.value;
        productPriceCalc(index, qty, oneTotal, unitPrice);
    } else {
        productPriceCalc(index, qty, oneTotal, unitPrice);
    }
}

//Fonction pour diminuer la quantité de produit depuis le panier
function decreaseBsktQty(elem, productQuantity, index, oneTotal, unitPrice) {
    let qty = productQuantity.value;
    if (parseInt(elem.value) > 0) {
        elem.value--;
        productQuantity.value--;
        qty = productQuantity.value;
        productPriceCalc(index, qty, oneTotal, unitPrice);
    } else {
        productPriceCalc(index, qty, oneTotal, unitPrice);
    }
}


//Fonction pour calculer le total de chaque produit
function productPriceCalc(index, qty, oneTotal, unitPrice) {
    oneTotal.value = unitPrice * qty;
}
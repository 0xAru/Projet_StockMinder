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
let cartLines = document.querySelectorAll(".my-cart-lines");
let cartTotal = document.querySelector("#cartTotal")
let sum = 0;


//Fonction création du panier---------------------------------------------------------------
function createForm(elem, index) {

    let productName = document.querySelector("#name" + index);
    let productId = document.querySelector("#id" + index);
    let productPrice = document.querySelector("#price" + index);
    let unitPrice = parseFloat(productPrice.innerHTML);
    let productQuantity = document.querySelector("#qty" + index);
    let productStock = document.querySelector("#stock" + index);
    let cartLine = document.querySelector("#cartLine" + index);
    let productTotal = document.querySelector("#productTotal" + index);
    let quantityInput = document.querySelector("#cartQty" + index);
    let idInput = document.querySelector("#cartId" + index);
    let qty = productQuantity.value;


    //Bouton submit du panier

    let submitBtn = document.createElement("button");
    submitBtn.id = "cartSubmitBtn";
    submitBtn.type = "submit";
    submitBtn.classList.add("fixed", "bottom-0")
    submitBtn.innerHTML = "Valider";
    cartForm.appendChild(submitBtn);

    //Création d'une nouvelle ligne du panier pour chaque nouvelle ref. de produit ajoutée

    if (!cartLine) {
        let cartLine = document.createElement("div");
        cartLine.classList.add("cart-line", "grid", "grid-cols-8", "flex", "justify-between", "my-cart-lines");
        cartLine.id = "cartLine" + index;
        cartForm.appendChild(cartLine);

        //product.id

        idInput = document.createElement("input");
        idInput.id = "cartId" + index;
        idInput.classList.add("hidden");
        idInput.type = "text";
        idInput.name = "id";
        idInput.value = productId.innerHTML;
        cartLine.appendChild(idInput);

        //product.name

        let cartName = document.createElement("p");
        cartName.innerHTML = productName.innerHTML;
        cartName.classList.add("col-start-1", "col-end-3", "flex", "items-center", "justify-center");
        cartLine.appendChild(cartName);


        //product.price

        let cartPrice = document.createElement("p");
        cartPrice.id = "cartPrice" + index;
        cartPrice.classList.add("col-start-3", "col-end-5");
        cartPrice.innerHTML = unitPrice + "€";
        cartLine.appendChild(cartPrice);

        //product.quantity

        let qtyContainer = document.createElement("div");
        qtyContainer.classList.add("flex", "col-start-5", "col-end-7", "items-center", "justify-center")
        cartLine.appendChild(qtyContainer);

        let cartMinus = document.createElement("button");
        cartMinus.type = "button";
        cartMinus.id = "cartMinus" + index;
        cartMinus.classList.add("my-minus", "w-5", "h-5", "rounded-md", "font-bold");
        cartMinus.innerHTML = "-";
        qtyContainer.appendChild(cartMinus);
        cartMinus.addEventListener("click", () => {
            decreaseCartQty(quantityInput, productQuantity, index, productTotal, unitPrice)
        });

        let quantityInput = document.createElement("input");
        quantityInput.type = "number";
        quantityInput.id = "cartQty" + index;
        quantityInput.classList.add("w-7", "p-0", "text-center", "focus:ring-0", "border-0", "bg-dutch-white", "pointer-events-none");
        quantityInput.value = productQuantity.value;
        qtyContainer.appendChild(quantityInput);

        let cartPlus = document.createElement("button");
        cartPlus.type = "button";
        cartPlus.id = "cartPlus" + index;
        cartPlus.classList.add("my-plus", "w-5", "h-5", "rounded-md", "font-bold");
        cartPlus.innerHTML = "+";
        qtyContainer.appendChild(cartPlus);
        cartPlus.addEventListener("click", () => {
            increaseCartQty(quantityInput, productStock, productQuantity, index, productTotal, unitPrice)
        });

        productTotal = document.createElement("p");
        productTotal.id = "productTotal" + index;
        productTotal.classList.add("col-start-7", "col-end-9");
        cartLine.appendChild(productTotal);

    } else { //Si ref. déjà ajoutée: augmentation de la quantité du produit dans le panier
        quantityInput.value = productQuantity.value;
    }

    productTotal.innerHTML = (unitPrice * qty).toFixed(2) + "€";


}


//Fonction pour augmenter la quantité de produit depuis le panier
function increaseCartQty(elem, productStock, productQuantity, index, productTotal, unitPrice) {
    let qty = productQuantity.value;
    if (parseInt(elem.value) < productStock.value) {
        elem.value++;
        productQuantity.value++;
        qty = productQuantity.value;
        totalCartInc(index)
        productPriceCalc(index, qty, productTotal, unitPrice);
    } else {
        productPriceCalc(index, qty, productTotal, unitPrice);
    }
}

//Fonction pour diminuer la quantité de produit depuis le panier
function decreaseCartQty(elem, productQuantity, index, productTotal, unitPrice) {
    let qty = productQuantity.value;
    if (parseInt(elem.value) > 0) {
        elem.value--;
        productQuantity.value--;
        qty = productQuantity.value;
        totalCartDec(index)
        productPriceCalc(index, qty, productTotal, unitPrice);
    } else {
        productPriceCalc(index, qty, productTotal, unitPrice);
    }
}


//Fonction pour calculer le total de chaque produit
function productPriceCalc(index, qty, productTotal, unitPrice) {
    productTotal.innerHTML = (unitPrice * qty).toFixed(2) + "€";
}

function totalCartInc(index) {
    let quantityInput = document.querySelector("#cartQty" + index);
    if (cartLines) {
        let unitPrice = parseFloat(document.querySelector("#price" + index).innerHTML);
        cartLines.forEach((cartLine, index) => {
            return unitPrice;
        });
            sum += unitPrice;
        cartTotal.innerHTML = sum.toFixed(2);
    }
}

function totalCartDec(index) {
    let quantityInput = document.querySelector("#cartQty" + index);
    if (cartLines) {
        let unitPrice = parseFloat(document.querySelector("#price" + index).innerHTML);
        cartLines.forEach((cartLine, index) => {
            return unitPrice;
        });
        if (parseInt(quantityInput.value) > 0 && sum > 0){
            console.log(sum)
            sum -= unitPrice;
        }
        cartTotal.innerHTML = sum.toFixed(2);
    }
}
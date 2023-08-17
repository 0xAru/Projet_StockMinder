let openModalBtn = document.querySelector(".my-cart-btn");
let body = document.querySelector("body");


//positionnement de l'icône panier en fonction du scroll vertical

window.addEventListener('scroll', function () {

    // Hauteur à partir de laquelle nous voulons détecter le défilement (96px)
    const scrollThreshold = 96;

    if (window.scrollY > scrollThreshold) {
        openModalBtn.classList.add("fixed-menu");

    } else {

        openModalBtn.classList.remove("fixed-menu");

    }
});


// Affichage de la modale de description détaillée du produit

function infoModal(elem, index) {

    let informationModal = document.querySelector("#infoModal" + index);

    informationModal.classList.remove("my-hidden");
    informationModal.classList.add("my-active");
    body.style.overflow = "hidden";

}

function closeInfoModal(elem, index) {

    let informationModal = document.querySelector("#infoModal" + index);

    informationModal.classList.add("my-hidden");
    informationModal.classList.remove("my-active");
    body.style.overflow = "visible";

}

// Affichage de la modale du panier
function openCartModal(elem) {

    let modal = document.querySelector("#cartModal")


    modal.classList.remove("my-hidden");
    modal.classList.add("my-active");
    body.style.overflow = "hidden";

}

function closeCartModal(elem) {

    let modal = document.querySelector("#cartModal")

    modal.classList.add("my-hidden");
    modal.classList.remove("my-active");
    body.style.overflow = "visible";

}

// gestion du panier ----------------------------------------------------------------------------------------------

let modal = document.querySelector("#modal")
let companyId = modal.getAttribute("data-companyId")
let products;
window.addEventListener('load', async () => {
    products = await fetch(`/${companyId}/products`);
    products = await products.json();
    products = products.products
})
let parent = document.querySelector("#cartData");
let cartForm = document.querySelector("#cartForm");
let cartLines = document.querySelectorAll(".my-cart-lines");
let cartTotal = document.querySelector("#cartTotal")
let sum = 0;


//Fonction création du panier---------------------------------------------------------------
async function createForm(elem, index, product) {

    let unitPrice = parseFloat(product.price / 100);
    let productQuantity = document.querySelector("#qty" + index);
    let productStock = document.querySelector("#stock" + index);
    let cartLine = document.querySelector("#cartLine" + index);
    let productTotal = document.querySelector("#productTotal" + index);
    let quantityInput = document.querySelector("#cartQty" + index);
    let idInput = document.querySelector("#cartId" + index);
    let qty = productQuantity.value;


    //Création d'une nouvelle ligne du panier pour chaque nouvelle ref. de produit ajoutée

    if (!cartLine) {
        let cartLineContainer = document.createElement("div");
        cartLineContainer.id = "cartLineContainer" + index;
        let cartLine = document.createElement("div");
        cartLine.classList.add("cart-line", "grid", "grid-cols-8", "flex", "justify-between", "my-cart-lines");
        cartLine.id = "cartLine" + index;
        cartLineContainer.appendChild(cartLine);
        cartForm.appendChild(cartLineContainer);

        //product.id

        idInput = document.createElement("input");
        idInput.id = "cartId" + index;
        idInput.classList.add("hidden");
        idInput.type = "text";
        idInput.name = "id";
        idInput.value = product.id;

        cartLine.appendChild(idInput);

        //product.name

        let cartName = document.createElement("p");
        cartName.innerHTML = product.name;
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
            if (parseInt(quantityInput.value) > 0) {
                decreaseCartQty(quantityInput, productQuantity, index, productTotal, product)
            }
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
            increaseCartQty(quantityInput, productStock, productQuantity, index, productTotal, product)
        });

        productTotal = document.createElement("p");
        productTotal.id = "productTotal" + index;
        productTotal.classList.add("col-start-7", "col-end-9");
        cartLine.appendChild(productTotal);

        //Bouton submit du panier

        let submitBtn = document.createElement("button");
        submitBtn.id = "cartSubmitBtn";
        submitBtn.type = "submit";
        submitBtn.classList.add("fixed", "bottom-0")
        submitBtn.innerHTML = "Valider";
        cartForm.appendChild(submitBtn);

    } else { //Si ref. déjà ajoutée: augmentation de la quantité du produit dans le panier
        quantityInput.value = productQuantity.value;
    }

    productTotal.innerHTML = (unitPrice * qty).toFixed(2) + "€";


}


//Fonction pour augmenter la quantité de produit depuis le panier
function increaseCartQty(elem, productStock, productQuantity, index, productTotal, product) {
    let qty = productQuantity.value;
    if (parseInt(elem.value) < productStock.value) {
        elem.value++;
        productQuantity.value++;
        qty = productQuantity.value;
        productPriceCalc(index, qty, productTotal, product);
        totalCartInc(index, product)
    }
}

//Fonction pour diminuer la quantité de produit depuis le panier
function decreaseCartQty(elem, productQuantity, index, productTotal, product) {
    productQuantity.value--;
    elem.value--;
    let qty = productQuantity.value;
    if (qty <= 0) {
        document.querySelector("#cartLineContainer" + index).remove()
    }
    productPriceCalc(index, qty, productTotal, product);
    totalCartDec(index, product)
}


//Fonction pour calculer le total de chaque produit
function productPriceCalc(index, qty, productTotal, product) {
    productTotal.innerHTML = ((product.price / 100) * qty).toFixed(2) + "€";
}

function totalCartInc(index, product) {

    if (cartLines) {
        cartLines.forEach((cartLine, index) => {
            return product.price;
        });
        sum += (product.price / 100);
        cartTotal.innerHTML = sum.toFixed(2) + "€";
    }
}

function totalCartDec(index, product) {
    let quantityInput = document.querySelector("#qty" + index);
    if (cartLines) {
        cartLines.forEach((cartLine, index) => {

            return product.price;
        });


        if (parseInt(quantityInput.value) > 0 || sum > 0) {
            sum -= (product.price / 100);
        }
        cartTotal.innerHTML = sum.toFixed(2) + "€";

    }
}

//fonction de déduction d'un produit dans le panier
function minus(elem, index) {

    let product = getProduct(index)
    let quantity = document.getElementById("qty" + index)

    if (quantity.value > 0) {
        quantity.value--;
        product.stock++
        createForm(elem, index, product);
        totalCartDec(index, product);
    } else {
        document.querySelector("#cartLineContainer" + index).remove()
    }
}

//fonction de création et d'addition de produits dans le panier
function plus(elem, index) {

    let product = getProduct(index)
    let stock = document.querySelector("#stock" + index);
    let quantity = document.getElementById("qty" + index)
    if (stock.value > 0 && quantity.value < parseInt(stock.value)) {
        quantity.value++;
        product.stock--
        createForm(elem, index, product);
        totalCartInc(index, product);
    }
}


//Récupération des produits pour la gestion dynamique du panier
function getProduct(index) {
    let prodId = document.querySelector("#id" + index).getAttribute("data-productId")
    return products.find((prod) => prod.id == prodId)
}
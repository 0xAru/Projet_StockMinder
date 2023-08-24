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
    let myOverlay = document.querySelector(".my-overlay");

    informationModal.classList.remove("my-hidden");
    informationModal.classList.add("my-active");
    myOverlay.classList.remove("hidden");
    body.style.overflow = "hidden";

}

function closeInfoModal(elem, index) {

    let informationModal = document.querySelector("#infoModal" + index);
    let myOverlay = document.querySelector(".my-overlay");

    informationModal.classList.add("my-hidden");
    informationModal.classList.remove("my-active");
    myOverlay.classList.add("hidden");
    body.style.overflow = "visible";

}


//Affichage de la modal de mise à jour manuelle du stock

function stockModal(elem, index) {

    let myStockModal = document.querySelector("#stockUpdateModal" + index);
    let productStock = document.querySelector("#stock" + index).value;
    let myNewStock = document.querySelector(("#myNewStock" + index));
    let myOverlay = document.querySelector(".my-overlay");


    myStockModal.classList.remove("my-hidden");
    myStockModal.classList.add("my-active");
    myNewStock.innerHTML = productStock;
    myOverlay.classList.remove("hidden");
    body.style.overflow = "hidden";

}

function closeStockModal(elem, index) {

    let myStockModal = document.querySelector("#stockUpdateModal" + index);
    let myOverlay = document.querySelector(".my-overlay");

    myStockModal.classList.add("my-hidden");
    myStockModal.classList.remove("my-active");
    myOverlay.classList.add("hidden");
    body.style.overflow = "visible";

}




// Affichage de la modale du panier
function openCartModal(elem) {

    let modal = document.querySelector("#cartModal")
    let myOverlay = document.querySelector(".my-overlay");

    modal.classList.remove("my-hidden");
    modal.classList.add("my-active");
    myOverlay.classList.remove("hidden");
    body.style.overflow = "hidden";

}

function closeCartModal(elem) {

    let modal = document.querySelector("#cartModal")
    let myOverlay = document.querySelector(".my-overlay");

    modal.classList.add("my-hidden");
    modal.classList.remove("my-active");
    myOverlay.classList.add("hidden");
    body.style.overflow = "visible";

}



// gestion du panier ----------------------------------------------------------------------------------------------

let modal = document.querySelector("#modal");
let companyId = modal.getAttribute("data-companyId");
let products;
let cartProducts = []; //tableau d'objets de mise à jour des stocks produits en fonction des quantités commandées
let newStock = []; //tableau d'objets de mise à jour manuelle des stocks produits par le chef de salle

window.addEventListener('load', async () => {
    try {
        const response = await fetch(`/${companyId}/products`);

        if (!response.ok) {
            throw new Error('Echec de récupération des données produit.');
        }
        const data = await response.json();
        products = data.products;


    } catch (error) {
        error = "Echec de récupération des données produit."
        console.error(error);
    }
});



let parent = document.querySelector("#cartData");
let cartForm = document.querySelector("#cartForm");
let cartLines = document.querySelectorAll(".my-cart-lines");
let cartTotal = document.querySelector("#cartTotal");
let sum = 0;



//Fonction création du panier---------------------------------------------------------------
async function createForm(elem, index, product) {

    let unitPrice = parseFloat(product.price / 100); // prix unitaire
    let productQuantity = document.querySelector("#qty" + index); // quantité de produit commandé coté menu
    let productStock = document.querySelector("#stock" + index).getAttribute("data-productStock"); // stock produit côté carte
    let cartLine = document.querySelector("#cartLine" + index); // ligne d'un produit dans le panier
    let productTotal = document.querySelector("#productTotal" + index); // total pour 1 produit
    let quantityInput = document.querySelector("#cartQty" + index); // quantité de produit commandé coté panier
    let idInput = document.querySelector("#cartId" + index); // id du produit côté panier
    let qty = productQuantity.value;


    //Création d'une nouvelle ligne du panier pour chaque nouvelle ref. de produit ajoutée

    if (!cartLine) {
        let cartLineContainer = document.createElement("div");
        cartLineContainer.id = "cartLineContainer" + index;
        let cartLine = document.createElement("div");
        cartLine.classList.add("cart-line", "grid", "grid-cols-8", "flex", "justify-between", "my-cart-lines", "items-center");
        cartLine.id = "cartLine" + index;
        cartLineContainer.appendChild(cartLine);
        cartForm.appendChild(cartLineContainer);

        //product.id

        idInput = document.createElement("input");
        idInput.id = "cartId" + index;
        idInput.classList.add("hidden");
        idInput.type = "text";
        idInput.name = "productId";
        idInput.value = product.id;

        cartLine.appendChild(idInput);

        //product.name / product.capacity

        let cartName = document.createElement("p");
        let capacity = product.capacity / 10;
        cartName.innerHTML = product.name + " " + capacity + "cl";
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
        cartMinus.classList.add("my-minus", "w-5", "h-5", "rounded-md");
        let minus = document.createElement("img");
        minus.src = "./assets/img/minus.svg"
        minus.classList.add("mx-auto", "h-2.5", "w-2.5");
        cartMinus.appendChild(minus);
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
        cartPlus.classList.add("my-plus", "w-5", "h-5", "rounded-md");
        let plus = document.createElement("img");
        plus.src = "./assets/img/plus.svg"
        plus.classList.add("mx-auto", "h-2.5", "w-2.5");
        cartPlus.appendChild(plus);
        qtyContainer.appendChild(cartPlus);
        cartPlus.addEventListener("click", () => {
            increaseCartQty(quantityInput, productStock, productQuantity, index, productTotal, product)
            console.log(product)
        });

        productTotal = document.createElement("p");
        productTotal.id = "productTotal" + index;
        productTotal.classList.add("col-start-7", "col-end-9");
        cartLine.appendChild(productTotal);

        let cartBtnContainer = document.createElement("div")
        cartBtnContainer.classList.add("fixed", "bottom-2");
        cartForm.appendChild(cartBtnContainer);

        //Bouton submit du panier

        let submitBtn = document.createElement("button");
        submitBtn.id = "cartSubmitBtn";
        submitBtn.type = "button";
        submitBtn.addEventListener('click', ()=>{
           sendData();
        });
        submitBtn.classList.add("w-28", "my-cart-button", "rounded-full", "focus:font-bold", "mx-6", "bottom-2");
        submitBtn.innerHTML = "Valider";
        cartBtnContainer.appendChild(submitBtn);

        //Bouton annuler du panier

        let cancelBtn = document.createElement("button");
        cancelBtn.id = "cartCancelBtn";
        cancelBtn.type = "button";
        cancelBtn.addEventListener('click', ()=>{
            closeCartModal();
        });
        cancelBtn.classList.add("w-28", "my-cart-button", "rounded-full", "focus:font-bold", "mx-6", "bottom-2");
        cancelBtn.innerHTML = "Fermer";
        cartBtnContainer.appendChild(cancelBtn);


    } else { //Si ref. déjà ajoutée: augmentation de la quantité du produit dans le panier
        quantityInput.value = productQuantity.value;
    }

    productTotal.innerHTML = (unitPrice * qty).toFixed(2) + "€";


}


//Fonction pour augmenter la quantité de produit depuis le panier
function increaseCartQty(elem, productStock, productQuantity, index, productTotal, product) {
    let qty = productQuantity.value;
    let existingProduct = cartProducts.find(cartProduct => cartProduct.id === product.id);
    if (parseInt(elem.value) < productStock) {
        elem.value++;
        productQuantity.value++;
        qty = productQuantity.value;
        if (!existingProduct) {
            product.stock--;
            cartProducts.push({id: product.id, stock: product.stock});
        } else {
            product.stock--;
            existingProduct.stock = product.stock;
        }
        productPriceCalc(index, qty, productTotal, product);
        totalCartInc(index, product)
    }
}

//Fonction pour diminuer la quantité de produit depuis le panier
function decreaseCartQty(elem, productQuantity, index, productTotal, product) {
    let existingProduct = cartProducts.find(cartProduct => cartProduct.id === product.id);
    productQuantity.value--;
    elem.value--;
    if (existingProduct) {
        product.stock++;
        existingProduct.stock = product.stock;
    }
    let qty = productQuantity.value;
    if (qty <= 0) {
        document.querySelector("#cartLineContainer" + index).remove();
        document.querySelector(".my-cart-button").remove();
    }
    productPriceCalc(index, qty, productTotal, product);
    totalCartDec(index, product);
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
    let cartLineContainer = document.querySelector("#cartLineContainer" + index);
    let product = getProduct(index);
    let existingProduct = cartProducts.find(cartProduct => cartProduct.id === product.id);
    let quantity = document.getElementById("qty" + index);


    if (quantity.value > 0) {
        quantity.value--;
        if (existingProduct) {
            product.stock++;
            existingProduct.stock = product.stock;
        }
        //product.stock++;
        createForm(elem, index, product);
        totalCartDec(index, product);

        if (cartLineContainer && quantity.value <= 0) {
            cartLineContainer.remove();
            document.querySelector(".my-cart-button").remove();
        }
    }
}

//fonction de création et d'addition de produits dans le panier
function plus(elem, index) {

    let stock = document.querySelector("#stock" + index).getAttribute("data-productStock");
    let quantity = document.getElementById("qty" + index)
    let product = getProduct(index)
    let existingProduct = cartProducts.find(cartProduct => cartProduct.id === product.id);

    if (stock > 0 && quantity.value < parseInt(stock)) {
        quantity.value++;
        if (!existingProduct) {
            product.stock--;
            cartProducts.push({id: product.id, stock: product.stock});
        } else {
            product.stock--;
            existingProduct.stock = product.stock;
        }
        //product.stock--
        createForm(elem, index, product);
        totalCartInc(index, product);
    }
}


//Récupération des produits pour la gestion dynamique du panier
function getProduct(index) {
    let prodId = document.querySelector("#id" + index).getAttribute("data-productId")
    return products.find((prod) => prod.id == prodId)
}

async function sendData(){

    // Options pour la requête Fetch
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Indique que vous envoyez des données JSON
        },
        body: JSON.stringify(cartProducts) // Convertit les données en JSON
    };

    let response = await fetch ('/order', options)
    window.location.reload();


}

async function stockUpdate(index){
    let product = getProduct(index)
    product.stock = parseInt(document.querySelector("#myNewStock" + index).innerHTML)
    newStock.push({id: product.id, stock: product.stock});
    console.log(newStock)
    // Options pour la requête Fetch
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Indique que vous envoyez des données JSON
        },
        body: JSON.stringify(newStock) // Convertit les données en JSON
    };

    let response = await fetch ('/stock-update', options)
    window.location.reload();

}
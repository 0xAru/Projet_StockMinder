const iconEmployee = document.querySelector("#employee");
const iconProduct = document.querySelector("#product");
const iconEvent = document.querySelector("#event");
const employeeContainer = document.querySelector("#employeeForm");
const productContainer = document.querySelector("#productForm");
const eventContainer = document.querySelector("#eventForm");
let companyId = iconProduct.getAttribute("data-companyId");
let isLoading = false;
window.addEventListener("load", (event) => {
    switch (parseInt(window.location.search.split('=')[1])) {
        case 1:
            getEvents()
            break
        case 2:
            getProducts()
            break
        default:
            getEmployees()
            break
    }
});
iconEmployee.addEventListener("click", async (e) => {
    getEmployees();
});
iconProduct.addEventListener("click", async (e) => {
    getProducts();
});
iconEvent.addEventListener("click", async (e) => {
    getEvents();
});

let styleSelect = document.createElement("datalist");
styleSelect.id = "styleOptions";
let styles = "<option value = IPA> <option value = Lager> <option value = Lambic> <option value = Stout> <option value = Pils> <option value = Saison> <option value = Sour>";
styleSelect.innerHTML = styles;
document.querySelector("#dashboard_product_form_style").insertAdjacentElement("afterend", styleSelect);

let categorySelect = document.createElement("datalist");
categorySelect.id = "categoryOptions";
let category = "<option value = Blonde> <option value = Brune> <option value = Blanche> <option value = Ambrée> <option value = Fruitée> <option value = Sans-Alcool> <option value = Soft>";
categorySelect.innerHTML = category;
document.querySelector("#dashboard_product_form_style").insertAdjacentElement("afterend", categorySelect);

let originSelect = document.createElement("datalist");
originSelect.id = "originOptions";
let origin = "<option value = France> <option value = Belgique> <option value = Allemagne> <option value = Pays-Bas> <option value = Chine> <option value = États-Unis> <option value = Brésil> <option value = Mexique> <option value = Russie>"
originSelect.innerHTML = origin;
document.querySelector("#dashboard_product_form_style").insertAdjacentElement("afterend", originSelect);

//Recovery of the first words of a text
function extractFirstWords(text, wordCount) {
    let words = text.trim().split(/\s+/);
    return words.slice(0, wordCount).join(' ');
}

//Reformat the date
function formatDate(dateString) {
    const options = {year: 'numeric', month: 'long', day: 'numeric'};
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', options);
}

//Reformat the time
function formatTime(dateTimeString) {
    let date = new Date(dateTimeString);
    let hours = date.getHours();
    let minutes = date.getMinutes();

    return (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
}

//Employees//
async function getEmployees(filter = null) {

    createEmployeeFilters();

    // This function avoids overloading the server and displaying the table several times
    if (isLoading) {
        return
    }
    isLoading = true;
    // we reset the display of the table
    if (document.getElementById("listEmployee")) {
        document.getElementById("listEmployee").remove();
    }

    let employees = await fetch(`/${companyId}/employees`);
    employees = await employees.json();
    iconEmployee.classList.add("activTab");
    iconProduct.classList.remove('activTab');
    iconEvent.classList.remove('activTab');
    employeeContainer.classList.remove("hidden");
    productContainer.classList.add("hidden");
    eventContainer.classList.add("hidden");

    let employeeList = document.createElement("div");
    employeeList.classList.add("dashFormBg", "grid", "grid-cols-6", "mt-4", "mx-52", "rounded-xl");
    employeeList.id = "listEmployee"
    employeeContainer.appendChild(employeeList);
    let labelContainer = document.createElement('div');
    labelContainer.classList.add("my-5", "col-start-2", "col-end-7", "w-full", "flex", "justify-around")
    labelContainer.innerHTML =
        '<span class="w-full grid-cols-2 flex justify-center font-bold">Id</span>' +
        '<span class="w-full grid-cols-3 flex justify-center font-bold">Nom</span>' +
        '<span class="w-full grid-cols-4 flex justify-center font-bold">Prénom</span>' +
        '<span class="w-full grid-cols-5 flex justify-center font-bold">Matricule</span>' +
        '<span class="w-full grid-cols-6 flex justify-center font-bold">Rôle</span>';
    employeeList.appendChild(labelContainer);

    //creation of the employee table
    employees.employees.forEach(employee => {
        let divButton = document.createElement("div");
        divButton.classList.add("grid-cols-1", "flex", "flex-col", "gap-2", "my-5", "ml-5");
        employeeList.appendChild(divButton);
        let button1 = document.createElement("a");
        button1.href = "/employee/" + employee.id + "/update";
        button1.classList.add("py-1", "rounded-xl", "bg-persian-orange", "font-semibold", "text-raisin-black", "text-center");
        button1.innerHTML = "Modifier";
        divButton.appendChild(button1);
        let button2 = document.createElement("a");
        button2.href = "/employee/" + employee.id + "/delete";
        button2.classList.add("py-1", "rounded-xl", "bg-wine", "font-semibold", "text-persian-orange", "text-center");
        button2.innerHTML = "Supprimer";
        divButton.appendChild(button2);
        let divId = document.createElement("div");
        divId.classList.add("grid-cols-2", "flex", "flex-col", "items-center", "justify-center");
        divId.innerHTML = employee.id
        employeeList.appendChild(divId);
        let divLastname = document.createElement("div");
        divLastname.classList.add("grid-cols-3", "flex", "flex-col", "items-center", "justify-center");
        divLastname.innerHTML = employee.lastname
        employeeList.appendChild(divLastname);
        let divFirstname = document.createElement("div");
        divFirstname.classList.add("grid-cols-4", "flex", "flex-col", "items-center", "justify-center");
        divFirstname.innerHTML = employee.firstname;
        employeeList.appendChild(divFirstname);
        let divEmployeeNumber = document.createElement('div');
        divEmployeeNumber.classList.add("grid-cols-5", "flex", "flex-col", "items-center", "justify-center");
        divEmployeeNumber.innerHTML = employee.employee_number;
        if (parseInt(employee.employee_number) === 1) {
            button2.classList.add('hidden');
        }
        employeeList.appendChild(divEmployeeNumber);
        let divRole = document.createElement('div');
        divRole.classList.add("grid-cols-6", "flex", "flex-col", "items-center", "justify-center");
        divRole.innerHTML = employee.roles;
        employeeList.appendChild(divRole);
    })
    isLoading = false
}

//Products//
async function getProducts(filter = null) {

    createProductFilters();

    // This function avoids overloading the server and displaying the table several times
    if (isLoading) {
        return
    }
    isLoading = true;
    // we reset the display of the table
    if (document.getElementById("listProduct")) {
        document.getElementById("listProduct").remove();
    }

    // I adapt the classes of my elements to display only those related to my products
    iconProduct.classList.add("activTab");
    iconEmployee.classList.remove("activTab");
    iconEvent.classList.remove('activTab');
    productContainer.classList.remove("hidden");
    employeeContainer.classList.add("hidden");
    eventContainer.classList.add("hidden");

    let productList = document.createElement("div");
    productList.classList.add("dashFormBg", "mt-4", "rounded-xl", "overflow-x-auto");
    productList.id = "listProduct";
    productContainer.appendChild(productList);
    let products = null

    if (filter == null) {
        products = await fetch(`/${companyId}/products`);
    } else {
        products = await fetch(`/${companyId}/products?filter=${filter}`);
    }

    products = await products.json();
    let tableContainer = document.createElement("div");
    tableContainer.classList.add("overflow-x-auto", "p-2");

    let table = document.createElement("table");
    table.classList.add("w-full", "border-collapse");

    // Table header
    let thead = document.createElement("thead");
    let headerRow = document.createElement("tr");
    headerRow.classList.add("mb-4", "flex", "items-center");

    let headers = ["", "Id", "Nom", "Marque", "Catégorie", "Style", "Degré d'alcool", "Provenance", "Contenance", "Prix Unitaire", "Promotion",
        "Stock", "Seuil de réaprovisionnement", "Label", "Description Client", "Description Serveur"];
    headers.forEach(headerText => {
        let th = document.createElement("th");
        th.classList.add("py-4", "px-8", "font-bold", "text-center");
        th.textContent = headerText;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Table body
    let tbody = document.createElement("tbody");
    products.products.forEach(product => {
        let row = document.createElement("tr");
        row.classList.add("mb-4", "flex", "items-center")

        let buttonCell = document.createElement("td");
        buttonCell.classList.add("flex", "flex-col", "gap-2", "justify-center");

        let buttonDiv = document.createElement("div");
        buttonDiv.classList.add("flex", "flex-col", "gap-2");
        buttonCell.appendChild(buttonDiv);

        let button1 = document.createElement("a");
        button1.href = "/product/" + product.id + "/update";
        button1.classList.add("py-1", "rounded-xl", "bg-persian-orange", "font-semibold", "text-raisin-black", "text-center");
        button1.innerHTML = "Modifier";
        buttonDiv.appendChild(button1);

        let button2 = document.createElement("a");
        button2.href = "/product/" + product.id + "/delete";
        button2.classList.add("py-1", "rounded-xl", "bg-wine", "font-semibold", "text-persian-orange", "text-center");
        button2.textContent = "Supprimer";
        buttonDiv.appendChild(button2);
        row.appendChild(buttonCell);

        let rowData = [
            product.id,
            product.name,
            product.brand,
            product.category,
            product.style,
            product.degree_of_alcohol + "%",
            product.origin,
            product.capacity + "cl",
            ((product.price) / 100) + "€",
            product.promotion + "%",
            product.stock,
            product.threshold,
            product.label,
            product.customer_description,
            product.employee_description
        ];

        rowData.forEach(data => {
            let cell = document.createElement("td");
            cell.classList.add("text-center");
            let cellContent = document.createElement("div");
            cellContent.classList.add("h-28", "overflow-y-scroll", "flex", "flex-col", "justify-center", "mx-3");
            cellContent.textContent = data;

            if (data && data.length > 70) {
                cellContent.textContent = extractFirstWords(data, 10);
                cellContent.classList.remove("justify-center");
            }

            if (data == "null%") {
                cellContent.textContent = "_";
            }
            cell.appendChild(cellContent);
            row.appendChild(cell);
        });
        tbody.appendChild(row);
    });
    table.appendChild(tbody);
    tableContainer.appendChild(table);
    productList.appendChild(tableContainer);
    isLoading = false
}

//Events//
async function getEvents() {

    if (document.getElementById("listEvent")) {
        document.getElementById("listEvent").remove();
    }
    let events = await fetch(`/${companyId}/events`);
    events = await events.json();
    iconEvent.classList.add('activTab');
    iconProduct.classList.remove('activTab');
    iconEmployee.classList.remove('activTab');
    eventContainer.classList.remove("hidden");
    productContainer.classList.add("hidden");
    employeeContainer.classList.add("hidden");

    let eventList = document.createElement("div");
    eventList.classList.add("dashFormBg", "mt-4", "rounded-xl", "overflow-x-auto");
    eventList.id = "listEvent";
    eventContainer.appendChild(eventList);

    let tableContainer = document.createElement("div");
    tableContainer.classList.add("overflow-x-auto", "p-2");

    let table = document.createElement("table");
    table.classList.add("w-full", "border-collapse");

    // Table header
    let thead = document.createElement("thead");
    let headerRow = document.createElement("tr");
    headerRow.classList.add("mb-4", "flex", "items-center");

    let headers = ["", "Id", "Nom", "Date de début", "Date de fin", "Heure de début", "Heure de fin", "Délai d'affichage", "Thème", "Image", "Description"];
    headers.forEach(headerText => {
        let th = document.createElement("th");
        th.classList.add("py-4", "px-8", "font-bold", "text-center", "whitespace-nowrap");
        th.textContent = headerText;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Table body
    let tbody = document.createElement("tbody");
    events.events.forEach(event => {

        let row = document.createElement("tr");
        row.classList.add("mb-4", "flex", "items-center")

        let buttonCell = document.createElement("td");
        buttonCell.classList.add("flex", "flex-col", "gap-2", "justify-center");

        let buttonDiv = document.createElement("div");
        buttonDiv.classList.add("flex", "flex-col", "gap-2");
        buttonCell.appendChild(buttonDiv);

        let button1 = document.createElement("a");
        button1.href = "/event/" + event.id + "/update";
        button1.classList.add("py-1", "rounded-xl", "bg-persian-orange", "font-semibold", "text-raisin-black", "text-center");
        button1.textContent = "Modifier";
        buttonDiv.appendChild(button1);

        let button2 = document.createElement("a");
        button2.href = "/event/" + event.id + "/delete";
        button2.classList.add("py-1", "rounded-xl", "bg-wine", "font-semibold", "text-persian-orange", "text-center");
        button2.textContent = "Supprimer";
        buttonDiv.appendChild(button2);

        row.appendChild(buttonCell);
        let rowData = [
            event.id,
            event.name,
            formatDate(event.start_date),
            formatDate(event.end_date),
            formatTime(event.start_time),
            formatTime(event.end_time),
            event.display_time_period + " jours",
            event.theme,
            event.image,
            event.description
        ];

        rowData.forEach(data => {
            let cell = document.createElement("td");
            cell.classList.add("text-center");
            let cellContent = document.createElement("div");
            cellContent.classList.add("h-28", "overflow-y-scroll", "flex", "flex-col", "justify-center");

            if (data && data.length > 80) {
                cellContent.textContent = extractFirstWords(data, 10);
            }

            if (event.image == data) {
                let img = document.createElement('img');
                img.src = "../uploaded_img/" + data;
                cellContent.classList.remove("justify-center")
                cellContent.appendChild(img);
            } else {
                cellContent.textContent = data;
            }
            cell.appendChild(cellContent);
            row.appendChild(cell);
        });
        tbody.appendChild(row);
    });
    table.appendChild(tbody);
    tableContainer.appendChild(table);
    eventList.appendChild(tableContainer);
}

async function createProductFilters() {
    let productsResponse = await fetch(`/${companyId}/products`);
    products = await productsResponse.json();

    let filterContainer = document.createElement("div");
    filterContainer.id = "filterContainerProducts";
    productContainer.appendChild(filterContainer);
    let filterForm = document.createElement('form');
    filterForm.classList.add("flex", "justify-center", "gap-8", "py-6");
    listProduct.appendChild(filterForm);

    const nameFilterInput = document.createElement("input");
    nameFilterInput.type = "text";
    nameFilterInput.id = "productFilterName";
    nameFilterInput.placeholder = "Nom du produit";
    nameFilterInput.classList.add("rounded-full", "md:my-3", "w-64");
    filterForm.appendChild(nameFilterInput);

    const brandFilterSelect = document.createElement("select");
    brandFilterSelect.id = "productFilterBrand";
    brandFilterSelect.classList.add("rounded-full", "md:my-3", "w-64");
    const placeholderBrand = document.createElement("option");
    placeholderBrand.textContent = "Sélectionnez une marque";
    placeholderBrand.value = "";
    brandFilterSelect.appendChild(placeholderBrand);
    filterForm.appendChild(brandFilterSelect);

    // We use a temporary set to recover the marks only once
    const uniqueBrands = new Set();

    // Populate the brand drop-down list
    products.products.forEach(product => {
        let brand = product.brand;
        if (brand && !uniqueBrands.has(brand)) {
            uniqueBrands.add(brand);
            let option = document.createElement("option");
            option.textContent = brand;
            option.value = brand;
            brandFilterSelect.appendChild(option);
        }
    });

    const categoryFilterSelect = document.createElement("select");
    categoryFilterSelect.id = "productFilterCategory";
    categoryFilterSelect.classList.add("rounded-full", "md:my-3", "w-64");
    const placeholderCat = document.createElement("option");
    placeholderCat.textContent = "Sélectionnez une catégorie";
    placeholderCat.value = "";
    categoryFilterSelect.appendChild(placeholderCat);
    filterForm.appendChild(categoryFilterSelect);

    // We use a temporary set to retrieve the categories only once
    const uniqueCategories = new Set();

    // Populate the category dropdown
    products.products.forEach(product => {
        let category = product.category;
        if (category && !uniqueCategories.has(category)) {
            uniqueCategories.add(category);
            let option = document.createElement("option");
            option.textContent = category;
            option.value = category;
            categoryFilterSelect.appendChild(option);
        }
    });

    const originFilterSelect = document.createElement("select");
    originFilterSelect.id = "productFilterOrigin";
    originFilterSelect.classList.add("rounded-full", "md:my-3", "w-64");
    const placeholderOri = document.createElement("option");
    placeholderOri.value = null;
    placeholderOri.textContent = "Sélectionnez le pays d'origine";
    originFilterSelect.appendChild(placeholderOri);
    filterForm.appendChild(originFilterSelect);

    // We use a temporary set to retrieve the origins only once
    const uniqueOrigin = new Set();

    // Fill in the origins drop-down list
    products.products.forEach(product => {
        let origin = product.origin;
        if (origin && !uniqueCategories.has(origin)) {
            uniqueCategories.add(origin);
            let option = document.createElement("option");
            option.textContent = origin;
            option.value = origin;
            originFilterSelect.appendChild(option);
        }
    });

    const labelFilterSelect = document.createElement("select");
    labelFilterSelect.id = "productFilterLabel";
    labelFilterSelect.classList.add("rounded-full", "md:my-3", "w-64");
    const placeholderLab = document.createElement("option");
    placeholderLab.value = null;
    placeholderLab.textContent = "Sélectionnez un label";
    labelFilterSelect.appendChild(placeholderLab);
    filterForm.appendChild(labelFilterSelect);

    // We use a temporary set to retrieve the labels only once
    const uniqueLabels = new Set();

    // Populate the label drop-down list
    products.products.forEach(product => {
        let label = product.label;
        if (label && !uniqueLabels.has(label)) {
            uniqueCategories.add(label);
            let option = document.createElement("option");
            option.textContent = label;
            option.value = label;
            labelFilterSelect.appendChild(option);
        }
    });

    const button = document.createElement("button");
    button.type = "button";
    button.addEventListener("click", () => {
        fetchProductFilter();
    })
    button.textContent = "Filtrer";
    button.classList.add("btn", "px-10", "my-4", "rounded-full", "bg-persian-orange", "text-raisin-black", "text-center");
    filterForm.appendChild(button);
}

async function fetchProductFilter() {

    let filter = {}

    const nameFilterInput = document.querySelector('#productFilterName');
    const brandFilterSelect = document.querySelector('#productFilterBrand');
    const categoryFilterSelect = document.querySelector('#productFilterCategory');
    const originFilterSelect = document.querySelector('#productFilterOrigin');
    const labelFilterSelect = document.querySelector('#productFilterLabel');

    if (nameFilterInput !== null){
        filter.name = nameFilterInput.value;
    }
    if (brandFilterSelect !== null){
        filter.brand = brandFilterSelect.value;
    }
    if (categoryFilterSelect !== null){
        filter.category = categoryFilterSelect.value;
    }
    if (originFilterSelect !== null){
        filter.origin = originFilterSelect.value;
    }
    if (labelFilterSelect !== null){
        filter.label = labelFilterSelect.value;
    }

    filter = JSON.stringify(filter);
    await getProducts(filter);
}

async function createEmployeeFilters(){
    let employeesResponse = await fetch(`/${companyId}/employee`);
    employees = await employeesResponse.json();

    let filterContainer = document.createElement("div");
    filterContainer.id = "filterContainerEmployees";
    employeeContainer.appendChild(filterContainer);
    let filterForm = document.createElement('form');
    filterForm.classList.add("flex", "justify-center", "gap-8", "py-6");
    listEmployee.appendChild(filterForm);

    const searchTerms = document.createElement("input");
    searchTerms.type = "text";
    searchTerms.id = "searchField";
    searchTerms.placeholder = "Rechercher un employé";
    searchTerms.classList.add("rounded-full", "md:my-3", "w-64");
    filterForm.appendChild(searchTerms);

    const button = document.createElement("button");
    button.type = "button";
    button.addEventListener("click", () => {
        fetchEmployeeFilter();
    })
    button.textContent = "Filtrer";
    button.classList.add("btn", "px-10", "my-4", "rounded-full", "bg-persian-orange", "text-raisin-black", "text-center");
    filterForm.appendChild(button);
}
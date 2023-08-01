const iconEmployee = document.querySelector("#employee");
const iconProduct = document.querySelector("#product");
const iconEvent = document.querySelector("#event");
const employeeContainer = document.querySelector("#employeeForm");
const productContainer = document.querySelector("#productForm");
const eventContainer = document.querySelector("#eventForm");
let companyId = iconProduct.getAttribute("data-companyId");


iconEmployee.addEventListener("click", async (e) => {

    let employees = await fetch(`/${companyId}/employees`);
    employees = await employees.json();
    iconEmployee.classList.add("activTab");
    iconProduct.classList.remove('activTab');
    iconEvent.classList.remove('activTab');
    employeeContainer.classList.remove("hidden");
    productContainer.classList.add("hidden");
    eventContainer.classList.add("hidden");
    console.log(employees)

    let employeeList = document.createElement("div");
    employeeList.classList.add("dashFormBg", "grid", "grid-cols-6", "mt-4", "mx-52", "rounded-xl");
    employeeContainer.appendChild(employeeList);
    let labelContainer = document.createElement('div');
    labelContainer.classList.add("my-5", "col-start-2", "col-end-7", "grid-row-1", "w-full", "flex", "justify-around")
    labelContainer.innerHTML =
        '<span class="w-full grid-cols-2 flex justify-center font-bold">Id</span>' +
        '<span class="w-full grid-cols-3 flex justify-center font-bold">Nom</span>' +
        '<span class="w-full grid-cols-4 flex justify-center font-bold">Prénom</span>' +
        '<span class="w-full grid-cols-5 flex justify-center font-bold">Matricule</span>' +
        '<span class="w-full grid-cols-6 flex justify-center font-bold">Rôle</span>';
    employeeList.appendChild(labelContainer);



    //creer front employer
    employees.employees.forEach(employee=>{
        let divButton = document.createElement("div");
        divButton.classList.add("grid-cols-1", "flex", "flex-col", "gap-2", "my-5", "ml-5");
        employeeList.appendChild(divButton);
        let button1 = document.createElement("button");
        button1.classList.add("py-1", "rounded-xl", "bg-persian-orange", "font-semibold", "text-raisin-black");
        button1.innerHTML = "Modifier";
        divButton.appendChild(button1);
        let button2 = document.createElement("button");
        button2.classList.add("py-1", "rounded-xl", "bg-wine", "font-semibold", "text-persian-orange");
        button2.innerHTML = "Supprimer";
        divButton.appendChild(button2);
        let divId = document.createElement("div");
        divId.classList.add("grid-cols-2", "flex", "flex-col", "items-center", "justify-center");
        divId.innerHTML = employee.id
        employeeList.appendChild(divId);
        let divName = document.createElement("div");
        divName.classList.add("grid-cols-3", "flex", "flex-col", "items-center", "justify-center")
    })
});

iconProduct.addEventListener("click", async (e) => {
    let products = await fetch(`/${companyId}/products`);
    products = await products.json();
    iconProduct.classList.add("activTab");
    iconEmployee.classList.remove("activTab");
    iconEvent.classList.remove('activTab');
    productContainer.classList.remove("hidden");
    employeeContainer.classList.add("hidden");
    eventContainer.classList.add("hidden");
});

iconEvent.addEventListener("click", async (e) => {
    let events = await fetch(`/${companyId}/events`);
    events = await events.json();
    iconEvent.classList.add('activTab');
    iconProduct.classList.remove('activTab');
    iconEmployee.classList.remove('activTab');
    eventContainer.classList.remove("hidden")
    productContainer.classList.add("hidden");
    employeeContainer.classList.add("hidden");
});

let styleSelect = document.createElement("datalist");
styleSelect.id = "styleOptions";
let styles = "<option value = IPA> <option value = Lager> <option value = Lambic> <option value = Stout> <option value = Pils> <option value = Pale Ale> <option value = Saison> <option value = Sour Beer>";
styleSelect.innerHTML = styles;
document.querySelector("#dashboard_product_form_style").insertAdjacentElement("afterend",styleSelect);

let categorySelect = document.createElement("datalist");
categorySelect.id = "categoryOptions";
let category = "<option value = Blonde> <option value = Brune> <option value = Blanche> <option value = Ambrée> <option value = Fruitée> <option value = Sans Alcool> <option value = Soft>";
categorySelect.innerHTML = category;
document.querySelector("#dashboard_product_form_style").insertAdjacentElement("afterend", categorySelect);
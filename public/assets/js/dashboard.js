const employee = document.querySelector("#employee");
const product = document.querySelector("#product");
const event = document.querySelector("#event");
let companyId = product.getAttribute("data-companyId");


employee.addEventListener("click", async (e) => {

    let employees = await fetch(`/${companyId}/employees`);
    employees = await employees.json()
    console.log(employees)
});

product.addEventListener("click", async (e) => {
    let products = await fetch(`/${companyId}/products`);
    products = await products.json()
    console.log(products)
});

event.addEventListener("click", async (e) => {
    let events = await fetch(`/${companyId}/events`);
    events = await events.json()
    console.log(events)
});

let styleSelect = document.createElement("datalist")
styleSelect.id = "styleOptions";
let test = "<option value =IPA><option value =pol>"
styleSelect.innerHTML = test
document.querySelector("#dashboard_product_form_style").insertAdjacentElement("afterend",styleSelect)


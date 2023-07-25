const employee = document.querySelector("#employee");
const product = document.querySelector("#product");
const event = document.querySelector("#event");
let companyId = product.getAttribute("data-companyId");
    employee.addEventListener("click", async(e)=>{

});

product.addEventListener("click",async(e)=>{

  let products = await fetch(`/${companyId}/produits`);
    console.log(products)
});

event.addEventListener("click",async(e)=>{

});
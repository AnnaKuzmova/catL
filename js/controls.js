let modal = document.querySelector(".confirmation-modal")
let allCatDeleteButton = Array.from(document.querySelectorAll(".delete-cat-button"))
let allUserDeleteButton = Array.from(document.querySelectorAll("#delete-user-button"))
let inputFor = document.querySelector(".type")
let inputId = document.querySelector(".current")
let modalHeading = document.querySelector(".modal-heading");
let decline = document.querySelector(".decline.btn")
let form = document.querySelector("#form")

allCatDeleteButton.forEach(button => {
   button.addEventListener("click", function(){
    inputFor.setAttribute("value", "cat")
    inputId.setAttribute("value", this.getAttribute("cat"))
    modalHeading.innerHTML = `Are you sure you want to remove ${this.previousElementSibling.previousElementSibling.innerHTML} from cats?`
    modal.style.display = "flex"
   })
})

allUserDeleteButton.forEach(button => {
    button.addEventListener("click", function(){
        inputFor.setAttribute("value", "user")
        inputId.setAttribute("value", this.getAttribute("user"))
        modalHeading.innerHTML = `Are you sure you want to remove ${this.previousElementSibling.previousElementSibling.innerHTML}?`
        modal.style.display = "flex"
    })
})

decline.addEventListener("click", function(e){
    e.preventDefault();
    modal.style.display = "none"
})




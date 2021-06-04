let inputs = Array.from(document.querySelectorAll(".profile-form input[type=text]:not(submit-data)"))
let editButton = document.querySelector(".edit-button")
let cancelButton = document.querySelector(".cancel-button")
let saveButton = document.querySelector(".submit-data")
let uploadImageHolder = document.querySelector(".upload-image");

let aElements = document.querySelectorAll(".user-cat-heading span")
let addCatButton = document.querySelector(".add-cat")
let addPictureButton = document.querySelector(".add-picture")

let userCatsHolder = document.querySelector(".cats-holder")
let galleryHolder = document.querySelector(".gallery-holder")
var userSRC = "";
const tl = new TimelineLite();

inputs.forEach(input => {
    input.classList.add("disabled")
    input.setAttribute('disabled', true)
})

editButton.addEventListener('click', function(){
    inputs.forEach(input => {
        input.classList.remove("disabled")
        input.removeAttribute("disabled")
    })
    cancelButton.style.display = "inline-block";
    saveButton.setAttribute('type', 'submit')
    uploadImageHolder.style.display = "block"
    userSRC = displayUserImage.getAttribute("src")

})


cancelButton.addEventListener("click", function(){
    inputs.forEach(input => {
        input.classList.add('disabled')
        input.setAttribute('disabled', true)
    })
    this.style.display = 'none'
    saveButton.setAttribute("type", "hidden");
    uploadImageHolder.style.display = "none"
    displayUserImage.setAttribute("src", userSRC)

});

let userInputImage = document.querySelector(".user-image");
let displayUserImage = document.querySelector(".display-user-image");

userInputImage.addEventListener("change",  function(e){
    if(this.files.length> 0) {
        var src = URL.createObjectURL(e.target.files[0]);
        displayUserImage.src = src;
    }
} )

//Animating the gallery and cats holder
aElements.forEach(a => {
    a.addEventListener('click', function(){
        let current = document.querySelector('.user-cat-heading span.active')
        current.classList.remove('active')
        if(current.innerText == 'Your cats') {
            addPictureButton.style.display = 'block'
            addCatButton.style.display = 'none'
            tl.to(userCatsHolder,0.3,{
                opacity:0,
                ease: "Power2",
                duration:0.3,
                onComplete: function(){
                    userCatsHolder.style.display = "none"
                    galleryHolder.style.display = "block"
                }
            }).to(galleryHolder,0.3,{
                opacity:1,
                ease:"Power2",
                duration:0.3,
                delay:0.3
            })

        } else {
            addPictureButton.style.display = 'none'
            addCatButton.style.display = 'block'
            tl.to(galleryHolder,0.3,{
                opacity:0,
                ease: "Power2",
                duration:0.3,
                onComplete: function(){
                    galleryHolder.style.display = "none"
                    userCatsHolder.style.display = "block"
                }
            }).to(userCatsHolder,0.3,{
                opacity:1,
                ease:"Power2",
                duration:0.3,
                delay:0.3
            })
        }

        this.classList.add('active')     
    })
})

let openModalButton = document.querySelector(".button.add-picture")
let modal = document.querySelector(".add-picture-modal")
let closeModalButton = document.querySelector(".cancel")

openModalButton.addEventListener("click", function(){
    modal.style.top = `${window.scrollY.toFixed(2)}px`
    modal.style.display = "block"
})

closeModalButton.addEventListener("click", function(){
    modal.style.display = "none"
})



let inputImageFile = document.querySelector(".image-input");
let imgTagDisplayImage = document.querySelector(".modal-img");

inputImageFile.addEventListener("change", function(e){
    if(this.files.length> 0) {
        var src = URL.createObjectURL(e.target.files[0]);
        imgTagDisplayImage.src = src;
    }
})



let allUserImages = Array.from(document.querySelectorAll(".gallery-image"))
let userImageModal = document.querySelector(".display-image-modal")
let userImgTag = document.querySelector(".user-img-tag")
let index = 0;

allUserImages.forEach(img => {
    img.setAttribute("index", index)
    index++
    img.addEventListener("click", function(){
        userImgTag.src = `${this.src}`
        userImgTag.setAttribute("index", this.getAttribute("index"))
        userImageModal.style.top = `${window.scrollY.toFixed(2)}px`
        userImageModal.style.display = "block"
    })
})

let closeUserImageModalButton = document.querySelector("#close-user-image-modal")
let showNextPicture = document.querySelector("#next-cat")
let showPreviousCat = document.querySelector("#previous-cat")

closeUserImageModalButton.addEventListener("click", function(){
    userImageModal.style.display = "none"
});

showNextPicture.addEventListener("click", function(){
    let currentIndex = parseInt(userImgTag.getAttribute("index")) + 1 

    if(currentIndex >= allUserImages.length) {
        currentIndex = 0
    }

    let nextSRC = allUserImages[currentIndex].getAttribute("src")
    userImgTag.setAttribute("index", currentIndex)
    userImgTag.setAttribute("src", nextSRC)

})

showPreviousCat.addEventListener("click", function(){
    let currentIndex = parseInt(userImgTag.getAttribute("index")) - 1 

    if(currentIndex == -1) {
        currentIndex = allUserImages.length - 1
    }

    let nextSRC = allUserImages[currentIndex].getAttribute("src")
    userImgTag.setAttribute("index", currentIndex)
    userImgTag.setAttribute("src", nextSRC)
})

//Disable all cat inputs
let catInputs = Array.from(document.querySelectorAll(".cat-edit-input"))
catInputs.forEach(input => input.classList.add("disabled"))

let catEditButtons = document.querySelectorAll(".cat-edit-button")
let catCurrentImage = ""
let catImageHolder = ""
let catCancelEditButton = Array.from(document.querySelectorAll(".cancel-cat-edit"))
let catImage = ""

catEditButtons.forEach(button => button.addEventListener("click", function(){
    
    let count = this.getAttribute("count")
    catImageHolder = document.querySelector(`.cat-image-holder[count="${count}"]`)
    let catEditInputs = Array.from(document.querySelectorAll(`.cat-data > .cat-edit-input[count = "${count}"]`))
    catCurrentImage = catImageHolder.getAttribute("src")
    catEditInputs.forEach(catInput => {
        catInput.classList.remove("disabled")
        catInput.removeAttribute("disabled")
    })
    let saveCatBtn = document.querySelector(`.save-cat[count = "${count}"]`)
    let cancelCatBtn = document.querySelector(`.cancel-cat-edit[count = "${count}"]`)
    saveCatBtn.style.display = "inline-block"
    cancelCatBtn.style.display = "inline-block"
    catImage = document.querySelector(`.cat-edit-upload-photo[count="${count}"]`)
    catImage.style.display = "block"
    catImage.addEventListener("change", function(e){
        if(this.files.length> 0) {
            var src = URL.createObjectURL(e.target.files[0]);
            catImageHolder.src = src;
        }
    })
}))

catCancelEditButton.forEach(btn => btn.addEventListener("click", function(){
    let count = this.getAttribute("count")
    let catEditInputs = Array.from(document.querySelectorAll(`.cat-data > .cat-edit-input[count = "${count}"]`))
    catEditInputs.forEach(catInput => {
        catInput.classList.add("disabled")
        catInput.setAttribute("disabled", true)
    })
    let saveCatBtn = document.querySelector(`.save-cat[count = "${count}"]`)
    let cancelCatBtn = document.querySelector(`.cancel-cat-edit[count = "${count}"]`)
    saveCatBtn.style.display = "none"
    cancelCatBtn.style.display = "none"
    catImage.style.display = "none"
    catImageHolder.src = catCurrentImage
 
}))





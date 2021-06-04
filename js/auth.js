let showRegisterFormButton = document.querySelector(".reg");
let signInContainer = document.querySelector(".sign-in-form");

let showSignInFormButton = document.querySelector(".sign");
let registerContainer = document.querySelector(".register-form");

showRegisterFormButton.addEventListener('click', function(){
    signInContainer.style.left = '-100%';
    registerContainer.style.left = '0';
});

showSignInFormButton.addEventListener("click", function(){
    registerContainer.style.left = '-100%';
    signInContainer.style.left = '0';
});
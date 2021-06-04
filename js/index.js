let wordArray = ['d', 'e', 'p', 'r', 'e', 's', 's', 'i', 'o', 'n', '.'];
let textContainer = document.querySelector('.text-animate');
let index = 0;

let type = setInterval(function(){
    if(index >= wordArray.length) {
        index = 0;
        textContainer.innerHTML = " ";
    }

    textContainer.innerHTML += wordArray[index];
    index++;

}, 500);


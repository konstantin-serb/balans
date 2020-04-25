var btn = document.querySelector('#buttonComment');
var modalWindow = document.querySelector('.modalWindow');
var closeBtn = document.querySelector('.closeBtn');

btn.addEventListener('click', function() {
    modalWindow.style.display = 'flex';
});

closeBtn.addEventListener('click', function () {
    modalWindow.style.display = 'none';
});

window.addEventListener('click', function (e) {
    if(e.target == modalWindow) {
        modalWindow.style.display = 'none';
    }
});






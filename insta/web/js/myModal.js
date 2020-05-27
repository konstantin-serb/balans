document.addEventListener('click', function (e) {
    let target = e.target;

    if (target.dataset.toggle === 'myModal') {
        e.preventDefault();
        document.querySelector(target.dataset.target).classList.add('open');
    } else if (target.dataset.close === 'myModal') {
        e.preventDefault();
        target.closest('.myModal').classList.remove('open');
    }
});

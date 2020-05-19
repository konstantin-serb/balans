
document.onkeydown = function (event) {
    if(event.code == "Escape") {
        history.back(); return false;
    }
};

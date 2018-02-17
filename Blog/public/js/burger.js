var burger = function (){
    var burgerMenu = document.getElementById('burgerMenu');
    var burgerButton = document.getElementById('burgerButton');
    var minTop, maxTop, defPadding = 10;
    // yes, the burger work with click on hidden checkbox so not mouse hover
    
    
    var burgerHandler = function() {
        var burgerStat = burgerButton.checked;
        burgerMenu.style.top = (burgerStat ? maxTop : minTop)+'px';
    };

    if (burgerButton && burgerMenu) {
        minTop = -burgerMenu.offsetHeight - 50; 
        maxTop = burgerButton.offsetHeight + (burgerButton.offsetTop + defPadding) * 2; 
        burgerMenu.style.top = minTop+'px';
        burgerButton.addEventListener('click', burgerHandler);
    }
}
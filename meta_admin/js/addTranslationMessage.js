var addTranslationMessage = document.querySelector('#add-translation-message-button');

addTranslationMessage.addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelectorAll('.vvod_perevod')[0].value = 'ffff';
}, false);
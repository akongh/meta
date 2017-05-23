var addTranslationMessage = document.querySelector('#add-translation-message-button');

addTranslationMessage.addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelectorAll('.vvod_znachenie')[0].value = 'перевод не предусмотрен';
}, false);
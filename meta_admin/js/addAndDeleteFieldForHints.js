var countOfFields = 1; // Текущее число полей
var curFieldNameId = 1; // Уникальное значение для атрибута name

function deleteField(a) {
    // Получаем доступ к ДИВу, содержащему поле
    var contDiv = a.parentNode;
    // Удаляем этот ДИВ из DOM-дерева
    contDiv.parentNode.removeChild(contDiv);
    // Уменьшаем значение текущего числа полей
    countOfFields--;
    // Возвращаем false, чтобы не было перехода по ссылке
    return false;
}
function addField() {
    // Увеличиваем текущее значение числа полей
    countOfFields++;
    // Увеличиваем ID
    curFieldNameId++;
    // Создаем элемент ДИВ
    var div = document.createElement("div");
    // Добавляем HTML-контент с пом. свойства innerHTML
    div.innerHTML = "<input name=\"perevod[]\" type=\"text\" class=\"vvod_perevod\"> — <input name=\"znachenie[]\" type=\"text\" class=\"vvod_znachenie\"><a onclick=\"return deleteField(this)\" href=\"#\" class=\"link\"><div class=\"minus_plus\"><input type=\"button\" class=\"pm_knopka\" onclick=\"return deleteField(this)\" value=\"×\"></div></a><hr class=\"otbivka_12\">";
    // Добавляем новый узел в конец списка полей
    document.getElementById("parentId").appendChild(div);
    // Возвращаем false, чтобы не было перехода по сслыке
    return false;
}
var arrRus = document.getElementsByName("massiv_itog[]");
for (var i = 0; i < arrRus.length; i++){
    arrRus[i].onclick = countRusChecked;
};

countRusChecked();

function countRusChecked(){
    var count = 0;
    for (var i = 0; i < arrRus.length; i++){
        if (arrRus[i].checked == true){
            count++;
        };
    };
    document.getElementById("countRusChecked").innerHTML = count;
};
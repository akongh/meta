let arrRus = document.getElementsByName("arr_kws_marked[]");

for (let i = 0; i < arrRus.length; i++){
    arrRus[i].onclick = countRusChecked;
}

countRusChecked();

function countRusChecked(){
    let count = 0;
    for (let i = 0; i < arrRus.length; i++){
        if (true === arrRus[i].checked){
            count++;
        }
    }
    document.getElementById("countRusChecked").innerHTML = count.toString();
}

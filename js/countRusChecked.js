let arrRus = document.getElementsByName("resulting_arr[]");

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
    document.getElementById("countRusChecked").innerHTML = count;
}

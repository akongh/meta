let arrAngl = document.getElementsByName("angl[]");

for (let i = 0; i < arrAngl.length; i++) {
    arrAngl[i].onclick = countUniqEngChecked;
}

countUniqEngChecked();

function countUniqEngChecked() {
    let checked = [];
    let f = false;
    for (let i = 0; i < arrAngl.length; i++) {
        if (true === arrAngl[i].checked) {
            if (checked.length > 0) {
                for (let j = 0; j < checked.length; j++) {
                    f = false;
                    if (checked[j] === arrAngl[i].value) {
                        f = true;
                        break;
                    }
                }
                if (false === f) {
                    checked.push(arrAngl[i].value);
                }
            } else {
                checked.push(arrAngl[i].value);
            }
        }
    }
    document.getElementById("countUniqEngChecked").innerHTML = checked.length.toString();
}

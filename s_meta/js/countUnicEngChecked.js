/**
 * Created by Andrei on 07.03.2017.
 */
countUnicEngChecked();

function countUnicEngChecked() {
    var arrAngl = document.getElementsByName("angl[]");
    for (var i = 0; i < arrAngl.length; i++) {
        arrAngl[i].onclick = countUnicEngChecked;
    }
    ;
    var checked = [];
    var f = false;
    for (var i = 0; i < arrAngl.length; i++) {
        if (arrAngl[i].checked == true) {
            if (checked.length > 0) {
                for (var j = 0; j < checked.length; j++) {
                    f = false;
                    if (checked[j] == arrAngl[i].value) {
                        f = true;
                        break;
                    }
                    ;
                }
                ;
                if (f == false) {
                    checked.push(arrAngl[i].value);
                }
                ;
            } else {
                checked.push(arrAngl[i].value);
            }
            ;
        }
        ;
    }
    ;
    document.getElementById("countUnicEngChecked").innerHTML = checked.length;
}
;
<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/php/sql_prepared_statements.php');

if (isset($_POST["russk"])) {
    $russk = array_values(array_unique($_POST["russk"]));
};
if (isset($_POST["angl"])) {
    $angl = array_values(array_unique($_POST["angl"]));
};
if (isset($_POST["zayavka"])) {
    $zayavka = $_POST["zayavka"];
}

if (isset($russk)) {
    $_SESSION["kol_slov_russk"] = count($russk);
}
if (isset($angl)) {
    $_SESSION["kol_slov_angl"] = count($angl);
} else {
    $_SESSION["kol_slov_angl"] = 0;
}

$vr_nabora = time();
$ses = session_id();

if (isset($russk)) {
    $russk2 = $russk;
    for ($i = 0; $i < count($russk2); $i++) {
        $russk2[$i] = trim($russk2[$i]);
        $russk2[$i] = preg_replace("/ {2,}/", " ", $russk2[$i]);
        $russk2[$i] = preg_replace("/'/", "\'", $russk2[$i]);
    }

    if (!($stmt = $db_connect->prepare(SQL_CREATE_KWSET_ID))) {
        echo $db_connect->errno . " -> " . $db_connect->error;
    }
    if (!$stmt->bind_param("ss", $vr_nabora, $ses)) {
        echo $stmt->errno . " -> " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo $stmt->errno . " -> " . $stmt->error;
    }

    for ($i = 0; $i < count($russk2); $i++) {
        if (!($stmt = $db_connect->prepare(SQL_CREATE_KWSET_KWS))) {
            echo $db_connect->errno . " -> " . $db_connect->error;
        }
        if (!$stmt->bind_param("s", $russk2[$i])) {
            echo $stmt->errno . " -> " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo $stmt->errno . " -> " . $stmt->error;
        }

        if (!($stmt = $db_connect->prepare(SQL_CREATE_KWSET_REL))) {
            echo $db_connect->errno . " -> " . $db_connect->error;
        }
        if (!$stmt->bind_param("sss", $vr_nabora, $ses, $russk2[$i])) {
            echo $stmt->errno . " -> " . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo $stmt->errno . " -> " . $stmt->error;
        }
    }

    $_REZULTAT_russk = implode(", ", $russk);
}
if ( isset( $angl ) ) {
    $_REZULTAT_angl = implode(", ", $angl);
}
if (isset($zayavka)) {
    $zayavka = implode("', '", $zayavka);
    $db_connect->query(sql_kws_mark_transl($zayavka));
}

$stmt->close();

$_SESSION["_REZULTAT_russk"] = $_REZULTAT_russk;
if (isset($_REZULTAT_angl)) {
    $_SESSION["_REZULTAT_angl"] = $_REZULTAT_angl;
};

$db_connect->close();
header("Location: //" . $_SERVER["HTTP_HOST"] . "/step_6.php");

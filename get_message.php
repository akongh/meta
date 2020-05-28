<?php
declare(strict_types=1);
error_reporting(-1);

if (isset($_POST["messageText"])) {
    $e_mail = "andreikorzhyts@gmail.com";
    $subject = "META.afoteris.com";
    $message_text = $_POST["messageText"];

    if (mail($e_mail, $subject, $message_text)) {
        echo("Сообщение отправлено.");
    } else {
        echo("Что-то не так… Сообщение не отправлено. Попробуйте andreikorzhyts на gmail.");
    }
} else {
    echo("Что-то не так… Сообщение не получено. Попробуйте andreikorzhyts на gmail.");
}

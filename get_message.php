<?php

declare(strict_types=1);
error_reporting(-1);

if (isset($_POST["messageText"])) {
    $from = "andreikorzhyts@gmail.com";
    $to = "andreikorzhyts@gmail.com";
    $subject = "META.afoteris.com";
    $message = $_POST["messageText"];
    $headers = "From: <{$from}>\r\n" .
        "Reply-To: <{$to}>\r\n" .
        "Content-type: text/html\r\n" .
        "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo("Сообщение отправлено.");
    } else {
        echo("Что-то не так… Сообщение не отправлено. Попробуйте andreikorzhyts на gmail.");
    }
} else {
    echo("Что-то не так… Сообщение не получено. Попробуйте andreikorzhyts на gmail.");
}

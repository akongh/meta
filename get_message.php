<?php

declare(strict_types=1);
error_reporting(-1);

$patch_to_message_settings = $_SERVER["DOCUMENT_ROOT"] . "/../_meta_privacy/message_settings";
$message_settings = file($patch_to_message_settings, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (isset($_POST["messageText"])) {
    $from = $message_settings[0];
    $to = $message_settings[1];
    $subject = $message_settings[2];
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

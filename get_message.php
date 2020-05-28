<?php
declare(strict_types=1);
error_reporting(-1);

if (isset($_POST["messageText"])) {
    $e_mail = "andreikorzhyts@google.com";
    $subject = "META.afoteris.com";
    $message_text = $_POST["messageText"];
    $headers = array(
        'From' => 'META.afoteris.com',
        'X-Mailer' => 'PHP/' . phpversion()
    );

    if (mail($e_mail, $subject, $message_text, $headers)) {
        echo("Сообщение отправлено.");
    } else {
        echo("Что-то не так… Сообщение не отправлено. Попробуйте andreikorzhyts на gmail.");
    }
} else {
    echo("Что-то не так… Сообщение не получено. Попробуйте andreikorzhyts на gmail.");
}

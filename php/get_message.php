<?php error_reporting( - 1 );

if ( isset( $_POST["messageText"] ) ) {

    $e_mail       = "support@afoteris.com";
    $subject      = "Сообщение с Меты";
    $message_text = trim( htmlspecialchars( strip_tags( stripslashes( $_POST["messageText"] ) ) ) );

    if ( mail( $e_mail, $subject, $message_text ) ) {
        echo( "Спасибо, мы получили ваше сообщение." );
    } else {
        echo( "Что-то не так. Нам не отправлено ваше сообщение." );
    };
} else {
    echo( "Что-то не так. Мы не получили ваше сообщение." );
};
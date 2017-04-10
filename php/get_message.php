<?php error_reporting( 0 );
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 09.04.2017
 * Time: 18:07
 */

if ( isset( $_POST["messageText"] ) ) {

    $e_mail       = "pochta@afoteris.com";
    $subject      = "Отзыв с Меты";
    $message_text = trim( htmlspecialchars( strip_tags( stripslashes( $_POST["messageText"] ) ) ) );

    if ( mail( $e_mail, $subject, $message_text ) ) {
        echo( "Спасибо, мы получили ваш отзыв." );
    } else {
        echo( "Что-то не так. Нам не отправлен ваш отзыв." );
    };
} else {
    echo( "Что-то не так. Мы не получили ваш отзыв." );
};
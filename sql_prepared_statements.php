<?php
/**
 * Defining of constants of prepared SQL-statements.
 *
 * PHP version 7.3
 *
 * @package   Meta
 * @author    Andrei Korzhyts <andreikorzhyts@dmail.com>
 * @copyright 2018 Andrei Korzhyts, Elena Abrazhevich
 * @since     0.1.0
 */


define("SQL_COUNT_TRANSLATED_WORDS_QUERY", "
    select count(`k-ts`.`s`)
	from `k-ts`
	where `f` = 1
");

define("SQL_COUNT_TRANSLATION_REQUEST_QUERY", "
    select count(`k-ts`.`s`)
	from `k-ts`
	where `f` = 7
");

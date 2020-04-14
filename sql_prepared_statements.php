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


function SQL_ZAPROS_PODBOR ($data_string) {

    $data_string = "'" . $data_string . "'";

    $SQL_ZAPROS_PODBOR = "select `k-ts`.`s`, count(*)
	  from (
		select `k-t_s`.`id_n`
		from  `k-ts`
		join `k-t_s` on `k-t_s`.`id_s` = `k-ts`.`ids`
		where `k-ts`.`s` in (" . $data_string . ")
		group by `k-t_s`.`id_n` having count(/*distinct*/ `k-t_s`.`id_s`) >= ?
		) `g`
	  join `k-t_s` on `k-t_s`.`id_n` = `g`.`id_n`
	  join `k-ts` on `k-ts`.`ids` = `k-t_s`.`id_s`
	  where `k-ts`.`f` in (0, 1, 7)
	  group by `k-t_s`.`id_s`, `k-ts`.`s`
	  order by count(*) desc, `k-ts`.`s` LIMIT 0, ?";

    return $SQL_ZAPROS_PODBOR;
}

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

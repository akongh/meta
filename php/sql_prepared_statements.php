<?php
declare(strict_types=1);
error_reporting(-1);
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


/**
 * @param string $data_string
 * @return string
 */
function sql_select_kws_frequency($data_string)
{
    $data_string = "'$data_string'";
    return <<<SQL
        select `s`, `kol`
        from `k-ts`
        where `s` in ($data_string)
        order by `k-ts`.`kol` desc
SQL;
}

/**
 * @param string $data_string
 * @return string
 */
function sql_update_mark_kws_for_translation($data_string)
{
    $data_string = "'$data_string'";
    return <<<SQL
        update `k-ts`
        set `f` = 7
        where `s` in ($data_string)
SQL;
}

/**
 * @param string $data_string
 * @return string
 */
function sql_select_kws_choice($data_string)
{
    $data_string = "'$data_string'";
    return <<<SQL
        select `k-ts`.`s`
        from (
          select `k-t_s`.`id_n`
          from  `k-ts`
          join `k-t_s` on `k-t_s`.`id_s` = `k-ts`.`ids`
          where `k-ts`.`s` in ($data_string)
          group by `k-t_s`.`id_n`
          having count(`k-t_s`.`id_s`) >= ?
          ) `g`
        join `k-t_s` on `k-t_s`.`id_n` = `g`.`id_n`
        join `k-ts` on `k-ts`.`ids` = `k-t_s`.`id_s`
        where `k-ts`.`f` in (0, 1, 7)
        group by `k-t_s`.`id_s`, `k-ts`.`s`
        order by count(*) desc, `k-ts`.`s` limit 0, ?
SQL;
}

define("SQL_SELECT_KW_STATUSES", "
    select `k-ts`.`f`
	from `k-ts`
	where `k-ts`.`s`= ?
");

define("SQL_SELECT_EN_TRANSLATION_AND_MEANING", "
    select `l-ts`.`s`, `tz`.`z`
	from `k-ts`
	join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
	join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
	join `tz` on `tz`.`idz`=`k_l`.`idz`
	where `k-ts`.`s`= ?
");

define("SQL_SELECT_KWS_FOR_TRANSLATION", "
    SELECT `k-ts`.`s`
    FROM `k-ts`
    WHERE `f` = 7
    order by `kol` desc
");

define("SQL_INSERT_CREATE_KWS_SET_ID", "
    INSERT INTO `k-tn` (`vr`)
    VALUES ( ? )
");

define("SQL_INSERT_CREATE_KWS_SET_KWS", "
    INSERT IGNORE INTO `k-ts` (`s`)
    VALUES ( ? )
");

define("SQL_INSERT_CREATE_KWS_SET_RELATIONS", "
    INSERT INTO `k-t_s` (`id_n`, `id_s`)
    VALUES ( ?, (SELECT `ids` FROM `k-ts` WHERE `s` = ? ))
");

define("SQL_SELECT_COUNT_TRANSLATED_KWS", "
    select count(`k-ts`.`s`)
	from `k-ts`
	where `f` = 1
");

define("SQL_SELECT_COUNT_KWS_FOR_TRANSLATION", "
    select count(`k-ts`.`s`)
	from `k-ts`
	where `f` = 7
");

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
 * @return string $query_string
 */
function sql_est_v_base($data_string)
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
 * @return string $query_string
 */
function sql_kws_mark_transl($data_string)
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
 * @return string $query_string
 */
function sql_zapr_podb($data_string)
{
    $data_string = "'$data_string'";
    return <<<SQL
        select `k-ts`.`s`, count(*)
        from (
          select `k-t_s`.`id_n`
          from  `k-ts`
          join `k-t_s` on `k-t_s`.`id_s` = `k-ts`.`ids`
          where `k-ts`.`s` in ($data_string)
          group by `k-t_s`.`id_n`
          having count(/*distinct */`k-t_s`.`id_s`) >= ?
          ) `g`
        join `k-t_s` on `k-t_s`.`id_n` = `g`.`id_n`
        join `k-ts` on `k-ts`.`ids` = `k-t_s`.`id_s`
        where `k-ts`.`f` in (0, 1, 7)
        group by `k-t_s`.`id_s`, `k-ts`.`s`
        order by count(*) desc, `k-ts`.`s` limit 0, ?
SQL;
}

define("SQL_F", "
    select `k-ts`.`f`
	from `k-ts`
	where `k-ts`.`s`= ?
");

define("SQL_P_Z", "
    select `l-ts`.`s`, `tz`.`z`
	from `k-ts`
	join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
	join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
	join `tz` on `tz`.`idz`=`k_l`.`idz`
	where `k-ts`.`s`= ?
");

define("SQL_ZAPROS_OCHERED", "
    SELECT *
    FROM `k-ts`
    WHERE `f` = 7
    order by `kol` desc
");

define("SQL_CREATE_KWSSET_ID", "
    INSERT INTO `k-tn` (`vr`, `ses`)
    VALUES ( ?, ? )
");

define("SQL_CREATE_KWSSET_KWS", "
    INSERT IGNORE INTO `k-ts` (`s`)
    VALUES ( ? )
");

define("SQL_CREATE_KWSSET_REL", "
    INSERT INTO `k-t_s` (`id_n`, `id_s`)
    VALUES ((SELECT `idn` FROM `k-tn` WHERE `vr` =  ? AND `ses` = ? ),
            (SELECT `ids` FROM `k-ts` WHERE `s` = ? ))
");

define("SQL_COUNT_TRANSLATED_WORDS", "
    select count(`k-ts`.`s`)
	from `k-ts`
	where `f` = 1
");

define("SQL_COUNT_TRANSLATION_REQUEST", "
    select count(`k-ts`.`s`)
	from `k-ts`
	where `f` = 7
");

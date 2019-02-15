/************************************************************/
SELECT COUNT(*) FROM `k-tn`;
SELECT COUNT(*) FROM `k-ts`;
SELECT COUNT(*) FROM `k-ts` WHERE `kol` in (1);
SELECT COUNT(*) FROM `k-ts` WHERE `kol` > 10;
/************************************************************/
/*сброс слова в заявку*/

UPDATE `k-ts` SET `k-ts`.`f` = 7 WHERE `k-ts`.`s` in ('бант','бантик','камень','простынь');
/************************************************************/
/*перенос пропущеных в заявку*/

UPDATE `k-ts` SET `k-ts`.`f` = 7 WHERE `k-ts`.`f` = 3;
/************************************************************/
SELECT * FROM `tz` WHERE `z` regexp '́';
SELECT * FROM `tz` WHERE `z` regexp 'волосатая';
SELECT * FROM `tz` WHERE `z` regexp '\\?';
SELECT * FROM `tz` WHERE `idz` = 12879;
/*========================*/
SELECT * FROM `k-ts` WHERE `s` regexp ' ';
SELECT * FROM `k-ts` WHERE `s` regexp '^нит';
SELECT * FROM `k-ts` WHERE `s` regexp '[a-z]';
SELECT * FROM `k-ts` WHERE `s` regexp '[0-9]' and `f` = 0;
SELECT * FROM `k-ts` WHERE `s` in ('лето','природа','пейзаж','море');
SELECT * FROM `k-ts` WHERE `s` = 'гоа';
SELECT * FROM `k-ts` WHERE `ids` in (1185,60703,228866,1354571);
SELECT * FROM `k-ts` WHERE `f` = 0;
SELECT * FROM `k-ts` WHERE `f` = 1;
SELECT * FROM `k-ts` WHERE `f` = 2;
SELECT * FROM `k-ts` WHERE `f` = 3;
SELECT * FROM `k-ts` WHERE `f` = 4;
SELECT * FROM `k-ts` WHERE `f` = 5;
SELECT * FROM `k-ts` WHERE `f` = 6;
SELECT * FROM `k-ts` WHERE `f` = 7 order by `kol` desc;
SELECT * FROM `k-ts` WHERE `kol` = 10000;
/*========================*/
SELECT * FROM `l-ts` WHERE `s` regexp ' ';
SELECT * FROM `l-ts` WHERE `s` = 'five thousand';
SELECT * FROM `l-ts` WHERE `s` in ('toe-nail','toe-nails');
SELECT * FROM `l-ts` WHERE `s` regexp 'caf';
SELECT * FROM `l-ts` WHERE `s` regexp '\'';
SELECT * FROM `l-ts` WHERE `s` REGEXP '[а-яё]';
SELECT * FROM `l-ts` WHERE `ids` = 77216;
SELECT * FROM `l-ts` WHERE `s` regexp '\\?';
/*========================*/
SELECT * FROM `l-t_s` WHERE `id_s` = 92490;
SELECT * FROM `l-t_s` WHERE `id_s` in (SELECT `ids` FROM `l-ts` WHERE `s` = 'five thousand');
SELECT * FROM `k-t_s` WHERE `id_s` = 240816;
/*========================*/
SELECT * FROM `k_l` WHERE `idk_l` = 13086;
SELECT * FROM `k_l` WHERE `idk` in (SELECT `ids` FROM `k-ts` WHERE `s` = 'кабан');
SELECT * FROM `k_l` WHERE `idl` in (SELECT `ids` FROM `l-ts` WHERE `s` = 'five thousand');
SELECT * FROM `k_l` WHERE
`idl` in (SELECT `ids` FROM `l-ts` WHERE `s` = 'wages')
and
`idk` in (SELECT `ids` FROM `k-ts` WHERE `s` = 'зарплата');
SELECT * FROM `k_l` WHERE `idk` = 9230147;
SELECT * FROM `k_l` WHERE `idl` = 97260;
SELECT * FROM `k_l` WHERE `idz` in (0000012879);
/*========================*/
/*удаление неправильных переводов*/

DELETE 
    `k_l`
FROM
    `k_l`
        INNER JOIN
    `tz` ON `k_l`.`idz` = `tz`.`idz`
        INNER JOIN
    `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
WHERE
    `tz`.`z` REGEXP '^красится'
        AND `l-ts`.`s` = 'colour';
    
    
DELETE `k_l` FROM `k_l` inner JOIN `tz` ON `k_l`.`idz` = `tz`.`idz` WHERE `tz`.`idz` IS NULL;
/*========================*/
UPDATE `tz` SET `z` = REPLACE(`z`, '?', '́') /*WHERE id>100*/;
UPDATE `l-ts` SET `s` = REPLACE(`s`, '?', '́') /*WHERE id>100*/;
/*========================*/
/*номера несуществующих значений в таблице перевода*/

SELECT 
    *
FROM
    `tz`
        LEFT JOIN
    `k_l` ON `tz`.`idz` = `k_l`.`idz`
        LEFT JOIN
    `k-ts` ON `k-ts`.`ids` = `k_l`.`idk`
WHERE
    `k-ts`.`ids` IS NULL;
/************************************************************/
insert into `k-ts` (`s`) value ('жаккард'), ('пледы'), ('постельное бельё'), ('ранфорс');
/************************************************************/
/*удаление из таблицы значений значений, отсутствующих в таблице связей перевода*/

delete `tz`
from `tz` LEFT JOIN `k_l` ON `tz`.`idz`=`k_l`.`idz`
WHERE `k_l`.`idz` IS NULL;
/************************************************************/
/*выбор слов из одного из предыдущих наборов*/

/*SELECT 
    `s`
FROM
    `k-ts`
        JOIN
    `k-t_s` ON `k-ts`.`ids` = `k-t_s`.`id_s`
        AND `k-t_s`.`id_n` = (SELECT 
            `idn`
        FROM `k-tn` where `idn` in
            (SELECT 
                `idn`
            FROM
                `k-tn`
            ORDER BY `idn` DESC
            LIMIT 8)
        LIMIT 1);*/
/************************************************************/
/*выбор слов последнего набора*/

select `s` from `k-ts` join `k-t_s` on `k-ts`.`ids` = `k-t_s`.`id_s` and `k-t_s`.`id_n` = (select `k-tn`.`idn` from `k-tn` order by `k-tn`.`idn` desc limit 1);

select `s` from `l-ts` join `l-t_s` on `l-ts`.`ids` = `l-t_s`.`id_s` and `l-t_s`.`id_n` = (select `l-tn`.`idn` from `l-tn` order by `l-tn`.`idn` desc limit 1);
/************************************************************/
/*выбор пследних номеров наборов*/

select * from `k-tn` order by `k-tn`.`idn` desc limit 10;
/************************************************************/
/*выбор слов из заданного набора*/

select `s` from `k-ts` join `k-t_s` on `k-ts`.`ids` = `k-t_s`.`id_s` and `k-t_s`.`id_n` = '0000570780';

select `s` from `l-ts` join `l-t_s` on `l-ts`.`ids` = `l-t_s`.`id_s` and `l-t_s`.`id_n` = '272108';
/************************************************************/
SELECT `k-t_s`.*
FROM `k-t_s` LEFT JOIN `k-ts` ON `k-t_s`.`id_s`=`k-ts`.`ids`
WHERE `k-ts`.`ids` IS NULL;
/*========================*/
	delete `k-t_s`
	from `k-t_s` LEFT JOIN `k-ts` ON `k-t_s`.`id_s`=`k-ts`.`ids`
	WHERE `k-ts`.`ids` IS NULL;
/*========================*/
SELECT `k-t_s`.*
FROM `k-t_s` LEFT JOIN `k-tn` ON `k-t_s`.`id_n` = `k-tn`.`idn` 
WHERE `k-tn`.`idn` IS NULL;
/*========================*/
	delete `k-t_s`
	FROM `k-t_s` LEFT JOIN `k-tn` ON `k-t_s`.`id_n` = `k-tn`.`idn` 
	WHERE `k-tn`.`idn` IS NULL;
/*========================*/
SELECT `k-tn`.*
FROM `k-tn` LEFT JOIN `k-t_s` ON `k-tn`.`idn`=`k-t_s`.`id_n`
WHERE `k-t_s`.`id_n` IS NULL;
/*========================*/
	DELETE `k-tn`
	FROM `k-tn` LEFT JOIN `k-t_s` ON `k-tn`.`idn`=`k-t_s`.`id_n`
	WHERE `k-t_s`.`id_n` IS NULL;
/*========================*/
SELECT `k-ts`.*
FROM `k-ts` LEFT JOIN `k-t_s` ON `k-ts`.`ids`=`k-t_s`.`id_s`
WHERE `k-t_s`.`id_s` IS NULL;
/*========================*/
/*ОСТОРОЖНО*/

	DELETE `k-ts`
	FROM `k-ts` LEFT JOIN `k-t_s` ON `k-ts`.`ids`=`k-t_s`.`id_s`
	WHERE `k-t_s`.`id_s` IS NULL;
/*========================*/
SELECT `k-ts`.*
FROM `k-ts` LEFT JOIN `k-t_s` ON `k-ts`.`ids`=`k-t_s`.`id_s`
WHERE `k-t_s`.`id_s` IS NULL and `k-ts`.`f` not in (1);
/*========================*/
	DELETE `k-ts`
	FROM `k-ts` LEFT JOIN `k-t_s` ON `k-ts`.`ids`=`k-t_s`.`id_s`
	WHERE `k-t_s`.`id_s` IS NULL and `k-ts`.`f` not in (1);
/************************************************************/
/************************************************************/
SELECT `tz`.*
FROM `tz` LEFT JOIN `k_l` ON `tz`.`idz`=`k_l`.`idz`
WHERE `k_l`.`idz` IS NULL;
/*========================*/
    delete `tz`
	FROM `tz` LEFT JOIN `k_l` ON `tz`.`idz`=`k_l`.`idz`
	WHERE `k_l`.`idz` IS NULL;
/*========================*/
SELECT `k_l`.*
FROM `k_l` LEFT JOIN `k-ts` ON `k_l`.`idk`=`k-ts`.`ids`
WHERE `k-ts`.`ids` IS NULL;
/*========================*/
	delete `k_l`
	FROM `k_l` LEFT JOIN `k-ts` ON `k_l`.`idk`=`k-ts`.`ids`
	WHERE `k-ts`.`ids` IS NULL;
/************************************************************/
/************************************************************/
SELECT `l-t_s`.*
FROM `l-t_s` LEFT JOIN `l-ts` ON `l-t_s`.`id_s` = `l-ts`.`ids`
WHERE `l-ts`.`ids` IS NULL;
/*========================*/
	DELETE `l-t_s`
	FROM `l-t_s` LEFT JOIN `l-ts` ON `l-t_s`.`id_s` = `l-ts`.`ids` 
	WHERE `l-ts`.`ids` IS NULL;
/*========================*/
SELECT `l-t_s`.*
FROM`l-t_s` LEFT JOIN `l-tn` ON `l-t_s`.`id_n` = `l-tn`.`idn`
WHERE `l-tn`.`idn` IS NULL;
/*========================*/
	DELETE `l-t_s`
	FROM `l-t_s` LEFT JOIN `l-tn` ON `l-t_s`.`id_n` = `l-tn`.`idn` 
	WHERE `l-tn`.`idn` IS NULL;
/*========================*/
SELECT `l-tn`.*
FROM `l-tn` LEFT JOIN `l-t_s` ON `l-tn`.`idn` = `l-t_s`.`id_n`
WHERE `l-t_s`.`id_n` IS NULL;
/*========================*/
	DELETE `l-tn`
	FROM `l-tn` LEFT JOIN `l-t_s` ON `l-tn`.`idn` = `l-t_s`.`id_n`
	WHERE `l-t_s`.`id_n` IS NULL;
/*========================*/
/*выбор английских слов, которых нет в связях перевода*/
SELECT `l-ts`.*
FROM `l-ts` LEFT JOIN `k_l` ON `l-ts`.`ids` = `k_l`.`idl`
WHERE `k_l`.`idl` IS NULL;
/************************************************************/
/*выбор последних переведённых слов
(не по факту, а по номеру перевода)*/

SELECT `k-ts`.`s`, `k_l`.`idk_l`
FROM `k_l` JOIN `k-ts` ON `k_l`.`idk` = `k-ts`.`ids`
GROUP BY `k_l`.`idk`
ORDER BY `k_l`.`idk_l` DESC LIMIT 10;
/************************************************************/
/*выбор дубликатов переводов*/

SELECT 
    t1.*
FROM
    `k_l` t1,
    `k_l` t2
WHERE
    t1.`idk` = t2.`idk`
        AND t1.`idl` = t2.`idl`
        AND t1.`idz` = t2.`idz`
        AND t1.`idk_l` > t2.`idk_l`
ORDER BY `t2`.`idz` ASC;
/*========================*/
/*удаление дубликатов переводов*/

DELETE t1 FROM `k_l` t1,
    `k_l` t2 
WHERE
    t1.`idk` = t2.`idk`
    AND t1.`idl` = t2.`idl`
    AND t1.`idz` = t2.`idz`
    AND t1.`idk_l` > t2.`idk_l`;
/************************************************************/
/*выборка битых переводов (нету таких слов на английском)*/

SELECT 
    `k-ts`.`ids`, `k-ts`.`s`, `k-ts`.`f`, `k_l`.`idl`
FROM
    `k-ts`
        JOIN
    `k_l` ON `k-ts`.`ids` = `k_l`.`idk`
WHERE
    `k_l`.`idl` IN (SELECT 
            `k_l`.`idl`
        FROM
            `k_l`
                LEFT JOIN
            `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
        WHERE
            `l-ts`.`ids` IS NULL)
GROUP BY `k-ts`.`ids`;
/************************************************************/
/*номера наборов с заданным числом слов (русск.)*/

SELECT * FROM `k-t_s`
group by `id_n` having count(*) <8;
/*========================*/
SELECT 
    `k-tn`.*
FROM
    `k-tn`
        JOIN
    (SELECT 
        `id_n`
    FROM
        `k-t_s`
    GROUP BY `id_n`
    HAVING COUNT(*) > 99) AS `a` ON `k-tn`.`idn` = `a`.`id_n`;
/*========================*/
DELETE `k-tn` FROM `k-tn`
        JOIN
    (SELECT 
        `id_n`
    FROM
        `k-t_s`
    GROUP BY `id_n`
    HAVING COUNT(*) < 8) AS `a` ON `k-tn`.`idn` = `a`.`id_n`;
/************************************************************/
/*номера наборов с заданным числом слов (англ.)*/

DELETE `l-tn` FROM `l-tn`
        JOIN
    (SELECT 
        `id_n`
    FROM
        `l-t_s`
    GROUP BY `id_n`
    HAVING COUNT(*) < 5) AS `a` ON `l-tn`.`idn` = `a`.`id_n`;
/************************************************************/
/*число уникальных наборов*/

SELECT 
    COUNT(*)
FROM
    (SELECT 
        `str`.`id_n`
    FROM
        (SELECT 
        `k-t_s`.`id_n`,
            GROUP_CONCAT(`k-t_s`.`id_s`
                ORDER BY `k-t_s`.`id_s`
                SEPARATOR '') `sostav`
    FROM
        `k-t_s`
    GROUP BY `k-t_s`.`id_n`) `str`
    GROUP BY `str`.`sostav`) `t`;
/*========================*/
/*выбор уникальных наборов*/

SELECT 
    `str`.`id_n`
FROM
    (SELECT 
        `k-t_s`.`id_n`,
            GROUP_CONCAT(`k-t_s`.`id_s`
                ORDER BY `k-t_s`.`id_s`
                SEPARATOR '') `sostav`
    FROM
        `k-t_s`
    GROUP BY `k-t_s`.`id_n`) `str`
GROUP BY `str`.`sostav`;

    
/************************************************************/
/*выбор номеров наборов с заданным словом*/

SELECT 
    `k-tn`.`idn`
FROM
    `k-tn`
        JOIN
    `k-t_s` ON `k-tn`.`idn` = `k-t_s`.`id_n`
        JOIN
    `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
WHERE
    `k-ts`.`ids` = (SELECT 
            `ids`
        FROM
            `k-ts`
        WHERE
            `s` = 'гоа');
/************************************************************/
/*Восстановление принадлежности слов к наборам по запасным данным.
Всё делается через дамп промежуточной таблицы с нехватающими связями.
Номера слов из запасной таблицы связей не совпали с номерами тех же слов в восстанавливаемой таблице.*/
CREATE TABLE IF NOT EXISTS `y` (
  `id_sv` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_n` int(10) unsigned zerofill NOT NULL,
  `id_s` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id_sv`),
  UNIQUE KEY `sost` (`id_n`,`id_s`),
  KEY `id_s` (`id_s`),
  KEY `id_n` (`id_n`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Связи для кириллицы' AUTO_INCREMENT=1 ;


insert ignore into `y` (`id_n`, `id_s`)
SELECT 
    `k-tn`.`idn`, `k-ts`.`ids`
FROM
    `k-tn`
        JOIN
    `k-t_s` ON `k-tn`.`idn` = `k-t_s`.`id_n`
        JOIN
    `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
WHERE
    `k-ts`.`ids` in (SELECT 
            `ids`
        FROM
            `k-ts`
        WHERE
            `s` in ('гоа','лагуна','лопасти','скотина'));


insert ignore into `k-t_s` (`id_n`, `id_s`)
SELECT 
    `y`.`id_n`, `y`.`id_s`
FROM
    `y`;
    
    
UPDATE `k-t_s` 
SET 
    `id_s` = 9232947
WHERE
    `id_s` = 60703;
/************************************************************/
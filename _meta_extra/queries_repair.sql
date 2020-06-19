# ВЫБОРКИ КОЛИЧЕСТВА

SELECT COUNT(*) as `count`
FROM `k-tn`;

SELECT COUNT(*) as `count`
FROM `k-ts`
WHERE `kol` in (1, 2, 3);

SELECT COUNT(*) as `count`
FROM `k-ts`
WHERE `kol` > 10;


# СБРОС СЛОВА В ЗАЯВКУ

UPDATE `k-ts`
SET `k-ts`.`f` = 7
WHERE `k-ts`.`s` in ('бант', 'бантик', 'камень', 'простынь');


# ПЕРЕНОС ПРОПУЩЕНЫХ В ЗАЯВКУ

UPDATE `k-ts`
SET `k-ts`.`f` = 7
WHERE `k-ts`.`f` = 3;


# ВЫБОРКИ

SELECT *
FROM `k-tn`
WHERE `idn` = '576635';

SELECT *
FROM `tz`
WHERE `z` regexp 'лурд';

SELECT *
FROM `k-ts`
WHERE `s` regexp '[0-9]'
  and `f` = 0;

SELECT *
FROM `k-ts`
WHERE `s` in ('лето', 'природа', 'пейзаж', 'море');

SELECT *
FROM `k-ts`
WHERE `f` = 7
order by `kol` desc;

SELECT *
FROM `k-t_s`
WHERE `id_s` in (SELECT `ids` FROM `k-ts` WHERE `s` = 'слово');

SELECT *
FROM `k_l`
WHERE `idk` IN (SELECT `ids`
                FROM `k-ts`
                WHERE `s` = 'банты')
  AND `idl` IN (SELECT `ids`
                FROM `l-ts`
                WHERE `s` = 'bow');


# УДАЛЕНИЕ НЕПРАВИЛЬНЫХ ПЕРЕВОДОВ

DELETE
    `k_l`
FROM `k_l`
         INNER JOIN
     `tz` ON `k_l`.`idz` = `tz`.`idz`
         INNER JOIN
     `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
WHERE `tz`.`z` REGEXP '^красится'
  AND `l-ts`.`s` = 'colour';

DELETE `k_l`
FROM `k_l`
         inner JOIN `tz` ON `k_l`.`idz` = `tz`.`idz`
WHERE `tz`.`idz` IS NULL;


# ОНОВЛЕНИЕ С ЗАМЕНОЙ ПОДСТРОКИ

UPDATE `tz`
SET `z` = REPLACE(`z`, '?', '́') /*WHERE id>100*/;


# НОМЕРА НЕСУЩЕСТВУЮЩИХ ЗНАЧЕНИЙ В ТАБЛИЦЕ ПЕРЕВОДА

SELECT `tz`.*
FROM `tz`
         LEFT JOIN
     `k_l` ON `tz`.`idz` = `k_l`.`idz`
         LEFT JOIN
     `k-ts` ON `k-ts`.`ids` = `k_l`.`idk`
WHERE `k-ts`.`ids` IS NULL;


# УДАЛЕНИЕ ИЗ ТАБЛИЦЫ ЗНАЧЕНИЙ ЗНАЧЕНИЙ, ОТСУТСТВУЮЩИХ В ТАБЛИЦЕ СВЯЗЕЙ ПЕРЕВОДА

delete `tz`
from `tz`
         LEFT JOIN `k_l` ON `tz`.`idz` = `k_l`.`idz`
WHERE `k_l`.`idz` IS NULL;


# ВСТАВКА СЛОВ

insert into `k-ts` (`s`) value ('жаккард'), ('пледы'), ('постельное бельё'), ('ранфорс');


# ВЫБОР СЛОВ ИЗ ОДНОГО ИЗ ПРЕДЫДУЩИХ НАБОРОВ

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


# ВЫБОР СЛОВ ПОСЛЕДНЕГО НАБОРА

SELECT `s`
FROM `k-ts`
         JOIN `k-t_s` ON `k-ts`.`ids` = `k-t_s`.`id_s` AND `k-t_s`.`id_n` = (SELECT `k-tn`.`idn`
                                                                             FROM `k-tn`
                                                                             ORDER BY `k-tn`.`idn` DESC
                                                                             LIMIT 1);


# ВЫБОР ПОСЛЕДНИХ НОМЕРОВ НАБОРОВ

select *
from `k-tn`
order by `k-tn`.`idn` desc
limit 10;


# ВЫБОР СЛОВ ИЗ ЗАДАННОГО НАБОРА

select `s`
from `k-ts`
         join `k-t_s` on `k-ts`.`ids` = `k-t_s`.`id_s` and `k-t_s`.`id_n` = '0000570780';


# ЧИСТКА ТАБЛИЦЫ СВЯЗЕЙ ОТ НЕСУЩЕСТВУЮЩИХ СЛОВ

SELECT `k-t_s`.*
FROM `k-t_s`
         LEFT JOIN `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
WHERE `k-ts`.`ids` IS NULL;
#------------------------------------------------
delete `k-t_s`
from `k-t_s`
         LEFT JOIN `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
WHERE `k-ts`.`ids` IS NULL;


# ЧИСТКА ТАБЛИЦЫ СВЯЗЕЙ ОТ НЕСУЩЕСТВУЮЩИХ НАБОРОВ

SELECT `k-t_s`.*
FROM `k-t_s`
         LEFT JOIN `k-tn` ON `k-t_s`.`id_n` = `k-tn`.`idn`
WHERE `k-tn`.`idn` IS NULL;
#------------------------------------------------
delete `k-t_s`
FROM `k-t_s`
         LEFT JOIN `k-tn` ON `k-t_s`.`id_n` = `k-tn`.`idn`
WHERE `k-tn`.`idn` IS NULL;


# ЧИСТКА ТАБЛИЦЫ НАБОРОВ ОТ НЕСУЩЕСТВУЮЩИХ СВЯЗЕЙ

SELECT `k-tn`.*
FROM `k-tn`
         LEFT JOIN `k-t_s` ON `k-tn`.`idn` = `k-t_s`.`id_n`
WHERE `k-t_s`.`id_n` IS NULL;
#------------------------------------------------
DELETE `k-tn`
FROM `k-tn`
         LEFT JOIN `k-t_s` ON `k-tn`.`idn` = `k-t_s`.`id_n`
WHERE `k-t_s`.`id_n` IS NULL;


# ЧИСТКА ТАБЛИЦЫ СЛОВ ОТ НЕСУЩЕСТВУЮЩИХ СВЯЗЕЙ

SELECT `k-ts`.*
FROM `k-ts`
         LEFT JOIN `k-t_s` ON `k-ts`.`ids` = `k-t_s`.`id_s`
WHERE `k-t_s`.`id_s` IS NULL;
#------------------------------------------------
# !!! Удалит все свободные слова, даже переведённые
DELETE `k-ts`
FROM `k-ts`
         LEFT JOIN `k-t_s` ON `k-ts`.`ids` = `k-t_s`.`id_s`
WHERE `k-t_s`.`id_s` IS NULL;

SELECT `k-ts`.*
FROM `k-ts`
         LEFT JOIN `k-t_s` ON `k-ts`.`ids` = `k-t_s`.`id_s`
WHERE `k-t_s`.`id_s` IS NULL
  and `k-ts`.`f` not in (1);
#------------------------------------------------
DELETE `k-ts`
FROM `k-ts`
         LEFT JOIN `k-t_s` ON `k-ts`.`ids` = `k-t_s`.`id_s`
WHERE `k-t_s`.`id_s` IS NULL
  and `k-ts`.`f` not in (1);


# ЧИСТКА ТАБЛИЦЫ ЗНАЧЕНИЙ ОТ НЕСУЩЕСТВУЮЩИХ СВЯЗЕЙ ПЕРЕВОДОВ

SELECT `tz`.*
FROM `tz`
         LEFT JOIN `k_l` ON `tz`.`idz` = `k_l`.`idz`
WHERE `k_l`.`idz` IS NULL;
#------------------------------------------------
delete `tz`
FROM `tz`
         LEFT JOIN `k_l` ON `tz`.`idz` = `k_l`.`idz`
WHERE `k_l`.`idz` IS NULL;

SELECT `k_l`.*
FROM `k_l`
         LEFT JOIN `k-ts` ON `k_l`.`idk` = `k-ts`.`ids`
WHERE `k-ts`.`ids` IS NULL;
#------------------------------------------------
delete `k_l`
FROM `k_l`
         LEFT JOIN `k-ts` ON `k_l`.`idk` = `k-ts`.`ids`
WHERE `k-ts`.`ids` IS NULL;


# ВЫБОР АНГЛИЙСКИХ СЛОВ, КОТОРЫХ НЕТ В СВЯЗЯХ ПЕРЕВОДА

SELECT count(*)
FROM `l-ts`
         LEFT JOIN `k_l` ON `l-ts`.`ids` = `k_l`.`idl`
WHERE `k_l`.`idl` IS NULL;

SELECT `l-ts`.*
FROM `l-ts`
         LEFT JOIN `k_l` ON `l-ts`.`ids` = `k_l`.`idl`
WHERE `k_l`.`idl` IS NULL;
#------------------------------------------------
DELETE `l-ts`
FROM `l-ts`
         LEFT JOIN `k_l` ON `l-ts`.`ids` = `k_l`.`idl`
WHERE `k_l`.`idl` IS NULL;


# ВЫБОР ПОСЛЕДНИХ ПЕРЕВЕДЁННЫХ СЛОВ (НЕ ПО ФАКТУ, А ПО НОМЕРУ ПЕРЕВОДА)

SELECT `k-ts`.`s`, `k_l`.`idk_l`
FROM `k_l`
         JOIN `k-ts` ON `k_l`.`idk` = `k-ts`.`ids`
GROUP BY `k_l`.`idk`, `k_l`.`idk_l`
ORDER BY `k_l`.`idk_l` DESC
LIMIT 10;


# ВЫБОР ДУБЛИКАТОВ ПЕРЕВОДОВ

SELECT t1.*
FROM `k_l` t1,
     `k_l` t2
WHERE t1.`idk` = t2.`idk`
  AND t1.`idl` = t2.`idl`
  AND t1.`idz` = t2.`idz`
  AND t1.`idk_l` > t2.`idk_l`
ORDER BY `t2`.`idz`;


# УДАЛЕНИЕ ДУБЛИКАТОВ ПЕРЕВОДОВ

DELETE t1
FROM `k_l` t1,
     `k_l` t2
WHERE t1.`idk` = t2.`idk`
  AND t1.`idl` = t2.`idl`
  AND t1.`idz` = t2.`idz`
  AND t1.`idk_l` > t2.`idk_l`;


# ВЫБОРКА БИТЫХ ПЕРЕВОДОВ (НЕТУ ТАКИХ СЛОВ НА АНГЛИЙСКОМ)

SELECT `k-ts`.`ids`,
       `k-ts`.`s`,
       `k-ts`.`f`,
       `k_l`.`idl`
FROM `k-ts`
         JOIN
     `k_l` ON `k-ts`.`ids` = `k_l`.`idk`
WHERE `k_l`.`idl` IN (SELECT `k_l`.`idl`
                      FROM `k_l`
                               LEFT JOIN
                           `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
                      WHERE `l-ts`.`ids` IS NULL)
GROUP BY `k-ts`.`ids`;


# НОМЕРА НАБОРОВ С ЗАДАННЫМ ЧИСЛОМ СЛОВ (RU)

SELECT *
FROM `k-t_s`
group by `id_n`
having count(*) < 8;

SELECT `k-tn`.*
FROM `k-tn`
         JOIN
     (SELECT `id_n`
      FROM `k-t_s`
      GROUP BY `id_n`
      HAVING COUNT(*) > 99) AS `a` ON `k-tn`.`idn` = `a`.`id_n`;
#------------------------------------------------
DELETE `k-tn`
FROM `k-tn`
         JOIN
     (SELECT `id_n`
      FROM `k-t_s`
      GROUP BY `id_n`
      HAVING COUNT(*) < 8) AS `a` ON `k-tn`.`idn` = `a`.`id_n`;


# ЧИСЛО УНИКАЛЬНЫХ НАБОРОВ

SELECT COUNT(*)
FROM (SELECT `str`.`id_n`
      FROM (SELECT `k-t_s`.`id_n`,
                   GROUP_CONCAT(`k-t_s`.`id_s`
                                ORDER BY `k-t_s`.`id_s`
                                SEPARATOR '') `sostav`
            FROM `k-t_s`
            GROUP BY `k-t_s`.`id_n`) `str`
      GROUP BY `str`.`sostav`) `t`;


# ВЫБОР УНИКАЛЬНЫХ НАБОРОВ

SELECT `str`.`id_n`
FROM (SELECT `k-t_s`.`id_n`,
             GROUP_CONCAT(`k-t_s`.`id_s`
                          ORDER BY `k-t_s`.`id_s`
                          SEPARATOR '') `sostav`
      FROM `k-t_s`
      GROUP BY `k-t_s`.`id_n`) `str`
GROUP BY `str`.`sostav`;


# ВЫБОР НОМЕРОВ НАБОРОВ С ЗАДАННЫМ СЛОВОМ

SELECT `k-tn`.`idn`
FROM `k-tn`
         JOIN
     `k-t_s` ON `k-tn`.`idn` = `k-t_s`.`id_n`
         JOIN
     `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
WHERE `k-ts`.`ids` = (SELECT `ids`
                      FROM `k-ts`
                      WHERE `s` = 'мета 3');


# ВОССТАНОВЛЕНИЕ ПРИНАДЛЕЖНОСТИ СЛОВ К НАБОРАМ ПО ЗАПАСНЫМ ДАННЫМ
# ВСЁ ДЕЛАЕТСЯ ЧЕРЕЗ ДАМП ПРОМЕЖУТОЧНОЙ ТАБЛИЦЫ С НЕХВАТАЮЩИМИ СВЯЗЯМИ
# НОМЕРА СЛОВ ИЗ ЗАПАСНОЙ ТАБЛИЦЫ СВЯЗЕЙ НЕ СОВПАЛИ С НОМЕРАМИ ТЕХ ЖЕ СЛОВ В ВОССТАНАВЛИВАЕМОЙ ТАБЛИЦЕ

CREATE TABLE IF NOT EXISTS `y`
(
    `id_sv` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
    `id_n`  int(10) unsigned zerofill NOT NULL,
    `id_s`  int(10) unsigned zerofill NOT NULL,
    PRIMARY KEY (`id_sv`),
    UNIQUE KEY `sost` (`id_n`, `id_s`),
    KEY `id_s` (`id_s`),
    KEY `id_n` (`id_n`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Связи для кириллицы'
  AUTO_INCREMENT = 1;

INSERT IGNORE INTO `y` (`id_n`, `id_s`)
SELECT `k-tn`.`idn`,
       `k-ts`.`ids`
FROM `k-tn`
         JOIN
     `k-t_s` ON `k-tn`.`idn` = `k-t_s`.`id_n`
         JOIN
     `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
WHERE `k-ts`.`ids` IN (SELECT `ids`
                       FROM `k-ts`
                       WHERE `s` IN ('гоа', 'лагуна', 'лопасти', 'скотина'));

INSERT IGNORE INTO `k-t_s` (`id_n`, `id_s`)
SELECT `y`.`id_n`,
       `y`.`id_s`
FROM `y`;

UPDATE `k-t_s`
SET `id_s` = 9232947
WHERE `id_s` = 60703;

/************************************************************/
-- выбор переводов для английского слова

SELECT `tz`.`z`
FROM `tz`
       JOIN
     `k_l` ON `tz`.`idz` = `k_l`.`idz`
       JOIN
     `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
WHERE `l-ts`.`s` = 'food'
limit 1;

/************************************************************/
-- пометка непереведённых по заявке

UPDATE `k-ts`
SET `f` = 7
WHERE `s` IN (SELECT `k`.`s`
              FROM (SELECT `k-ts`.`s`,
                           `k-ts`.`f`,
                           COUNT(*)
                    FROM (SELECT `k-t_s`.`id_n`
                          FROM `k-ts`
                                 JOIN `k-t_s` ON `k-t_s`.`id_s` = `k-ts`.`ids`
                          WHERE `k-ts`.`s` IN ('новый год', 'рождество')
                          GROUP BY `k-t_s`.`id_n`
                          HAVING COUNT(`k-t_s`.`id_s`) = 2) `g`
                           JOIN `k-t_s` ON `k-t_s`.`id_n` = `g`.`id_n`
                           JOIN `k-ts` ON `k-ts`.`ids` = `k-t_s`.`id_s`
                    WHERE `k-ts`.`f` IN (0, 1, 6)
                    GROUP BY `k-t_s`.`id_s`, `k-ts`.`s`
                    ORDER BY COUNT(*) DESC, `k-ts`.`s`
                    LIMIT 0 , 200) `k`
              WHERE `k`.`f` = 0);

/************************************************************/
-- выбор непереведённых слов в определённом запросе

SELECT `gg`.`s`,
       `gg`.`f`,
       `kol`
FROM (SELECT `k-ts`.`s`,
             `k-ts`.`f`,
             COUNT(*) `kol`
      FROM (SELECT `k-t_s`.`id_n`
            FROM `k-ts`
                   JOIN `k-t_s` ON `k-t_s`.`id_s` = `k-ts`.`ids`
            WHERE `k-ts`.`s` IN ('медицина')
            GROUP BY `k-t_s`.`id_n`
            HAVING COUNT(`k-t_s`.`id_s`) = '1') `g`
             JOIN `k-t_s` ON `k-t_s`.`id_n` = `g`.`id_n`
             JOIN `k-ts` ON `k-ts`.`ids` = `k-t_s`.`id_s`
      GROUP BY `k-t_s`.`id_s`, `k-ts`.`s`
      ORDER BY COUNT(*) DESC, `k-ts`.`s`) `gg`
WHERE `gg`.`f` = 0
LIMIT 0 , 100;

/************************************************************/
-- число слов в наборах

SELECT *,
       COUNT(`id_n`) `kol`
FROM `k-t_s`
GROUP BY `id_n`
ORDER BY COUNT(`id_n`) DESC;

/************************************************************/
-- создание индекса

CREATE INDEX `ids` ON `ts` (`ids`);

/************************************************************/
-- выбор перевода и значения для заданного русского слова

SELECT `l-ts`.`s`,
       `tz`.`z`
FROM `k-ts`
       JOIN
     `k_l` ON `k-ts`.`ids` = `k_l`.`idk`
       JOIN
     `l-ts` ON `l-ts`.`ids` = `k_l`.`idl`
       JOIN
     `tz` ON `tz`.`idz` = `k_l`.`idz`
WHERE `k-ts`.`s` = 'фон';

/************************************************************/

SELECT *
FROM `k-ts`
WHERE LENGTH(`s`) > 40;
/*========================*/
SELECT *
FROM `k-ts`
WHERE CHAR_LENGTH(`s`) > 40;
/*========================*/
SELECT *
FROM `k-tn`
WHERE `ses` = '200slov_proba'
LIMIT 0 , 400;

/************************************************************/
-- номер и количество заданного слова

SELECT `id_s`        `slovo`,
       COUNT(`id_s`) `kol`
FROM `k-t_s`
       JOIN
     `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
WHERE `k-ts`.`s` = 'природа';

/************************************************************/
-- слова и их количество

SELECT `k-ts`.`s` `slovo`,
       COUNT(*)   `kol`
FROM `k-t_s`
       JOIN
     `k-ts` ON `k-t_s`.`id_s` = `k-ts`.`ids`
GROUP BY `k-t_s`.`id_s`
ORDER BY COUNT(`k-t_s`.`id_s`) DESC;

/************************************************************/
-- все наборы с латиницей и цифрами

SELECT `idn`
FROM `tn`
       JOIN
     `t_s` ON `tn`.`idn` = `t_s`.`id_n`
       JOIN
     `ts` ON `t_s`.`id_s` = `ts`.`ids`
WHERE `ts`.`s` REGEXP '[a-z0-9]';

/************************************************************/
-- выбор числа наборов с латиницей

SELECT COUNT(DISTINCT `tn`.`idn`)
FROM `tn`
       JOIN
     `t_s` ON `tn`.`idn` = `t_s`.`id_n`
       JOIN
     `ts` ON `t_s`.`id_s` = `ts`.`ids`
WHERE `ts`.`s` REGEXP '[a-z]';

/************************************************************/

explain EXTENDED SELECT `k-ts`.`s`,
                        COUNT(*)
                 FROM (SELECT `k-t_s`.`id_n`
                       FROM `k-ts`
                              JOIN `k-t_s` ON `k-t_s`.`id_s` = `k-ts`.`ids`
                       WHERE `k-ts`.`s` IN ('фон')
                       GROUP BY `k-t_s`.`id_n`
                       HAVING COUNT(`k-t_s`.`id_s`) = '1') `g`
                        JOIN
                      `k-t_s` ON `k-t_s`.`id_n` = `g`.`id_n`
                        JOIN
                      `k-ts` ON `k-ts`.`ids` = `k-t_s`.`id_s`
                 GROUP BY `k-t_s`.`id_s`, `k-ts`.`s`
                 ORDER BY COUNT(*) DESC, `k-ts`.`s`
                 LIMIT 0 , 200;
/*========================*/
SHOW WARNINGS;

/************************************************************/
-- выбор номеров русских слов и количества переводов для них

SELECT `idk`,
       COUNT(`k_l`.`idk`) `kol`
FROM `k_l`
GROUP BY `k_l`.`idk`
ORDER BY `kol` DESC

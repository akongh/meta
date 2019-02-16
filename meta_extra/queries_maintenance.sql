SHOW VARIABLES;
SHOW PROCESSLIST;
KILL 1234;

/************************************************************/

SET group_concat_max_len = 102400;

/************************************************************/
/*обновление частоты слов*/

UPDATE `k-ts`
SET `k-ts`.`kol` = (SELECT COUNT(*) FROM `k-t_s` WHERE `k-t_s`.`id_s` = `k-ts`.`ids`);

/************************************************************/
/*удаление дубликатов наборов через промежуточную таблицу*/

CREATE TABLE IF NOT EXISTS `webart_meta`.`x`
(
  `id` INT(10) UNSIGNED ZEROFILL NOT NULL,
  KEY `id` (`id`)
) ENGINE = INNODB
  DEFAULT CHARACTER SET = UTF8;

/*========================*/

insert into `x` (`id`)
SELECT `str`.`id_n`
FROM (SELECT `k-t_s`.`id_n`,
             GROUP_CONCAT(`k-t_s`.`id_s`
                          ORDER BY `k-t_s`.`id_s`
                          SEPARATOR '') `sostav`
      FROM `k-t_s`
        /*JOIN `k-tn` ON `k-t_s`.`id_n` = `k-tn`.`idn`
            AND `k-tn`.`f` = 0*/
      GROUP BY `k-t_s`.`id_n`) `str`
GROUP BY `str`.`sostav`;

/*========================*/

SELECT `k-tn`.*
FROM `k-tn`
       LEFT JOIN
     `x` ON `k-tn`.`idn` = `x`.`id`
WHERE `x`.`id` IS NULL;

/*========================*/

SELECT COUNT(`k-tn`.`idn`)
FROM `k-tn`
       LEFT JOIN
     `x` ON `k-tn`.`idn` = `x`.`id`
WHERE `x`.`id` IS NULL;

/*========================*/

DELETE `k-tn`
FROM `k-tn`
       LEFT JOIN
     `x` ON `k-tn`.`idn` = `x`.`id`
WHERE `x`.`id` IS NULL;

/************************************************************/
/*удаление дубликатов наборов одним запросом*/

DELETE `k-tn`
FROM `k-tn`
WHERE `idn` NOT IN (SELECT `str`.`id_n`
                    FROM (SELECT `k-t_s`.`id_n`,
                                 GROUP_CONCAT(`k-t_s`.`id_s`
                                              ORDER BY `k-t_s`.`id_s`
                                              SEPARATOR '') `sostav`
                          FROM `k-t_s`
                          GROUP BY `k-t_s`.`id_n`) `str`
                    GROUP BY `str`.`sostav`);

/*========================*/

DELETE `k-tn`
FROM `k-tn`
       LEFT JOIN
     (SELECT `str`.`id_n`
      FROM (SELECT `k-t_s`.`id_n`,
                   GROUP_CONCAT(`k-t_s`.`id_s`
                                ORDER BY `k-t_s`.`id_s`
                                SEPARATOR '') `sostav`
            FROM `k-t_s`
            GROUP BY `k-t_s`.`id_n`) `str`
      GROUP BY `str`.`sostav`) `nom` ON `k-tn`.`idn` = `nom`.`id_n`
WHERE `nom`.`id_n` IS NULL;

/************************************************************/
/*Рзмеры БД*/

SELECT table_schema                                  'database_name',
       data_length / 1024 / 1024                     'Data in MB',
       index_length / 1024 / 1024                    'Index in MB',
       SUM(data_length + index_length) / 1024 / 1024 'Sum in MB'
FROM information_schema.TABLES
GROUP BY table_schema;

/************************************************************/
-- база в UTF-8, проверяем

SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[ЁА-пр-яё[:blank:]-]+$';


-- 20:14:05 
SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[ЁА-пр-яё[:blank:]-]+$'
LIMIT 0 , 1000; /*15 row(s) returned 0.001 sec / 0.000 sec*/
/************************************************************/

SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[a-z[:blank:]-]+$';

-- 20:14:52 
SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[a-z[:blank:]-]+$'
LIMIT 0 , 1000; /*18 row(s) returned 0.001 sec / 0.000 sec*/

SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[а-яё[:blank:]-]+$';

-- 20:20:36 
SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[а-яё[:blank:]-]+$'
LIMIT 0 , 1000; /*3 row(s) returned 0.002 sec / 0.000 sec*/

SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[А-ЯЁа-яё[:blank:]-]+$';

-- 20:22:04 
SELECT 
    *
FROM
    `ls`
WHERE
    `s` REGEXP '^[А-ЯЁа-яё[:blank:]-]+$'
LIMIT 0 , 1000; /*3 row(s) returned 0.010 sec / 0.001 sec*/
-- Although automatic conversion is not in the SQL standard, the SQL standard document does say that every character set is 
-- (in terms of supported characters) a “subset” of Unicode. Because it is a well-known principle that “what applies to a superset 
-- can apply to a subset,” we believe that a collation for Unicode can apply for comparisons with non-Unicode strings.


/************************************************************/

select count(*) from `ts`
where `s` regexp '^[ЁА-пр-яё[:blank:]-]+$';
-- 3738

select count(*) from `ts`
where `s` regexp '^[a-z[:blank:]-]+$';
-- 3463

select count(*) from `ts`
where `s` regexp '^[а-яё[:blank:]-]+$';
-- 330

select count(*) from `ts`
where `s` regexp '^[А-ЯЁа-яё[:blank:]-]+$';
-- 484

-- А всего — 7206.
-- 
-- ЖОПА!


/************************************************************/


SELECT 
    `s`
FROM
    `ts`
WHERE
    `s` REGEXP '^[HEX(?)]+$';
/************************************************************/
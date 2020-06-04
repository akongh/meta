# БАЗА В UTF-8, ПРОВЕРЯЕМ

SELECT *
FROM `l-ts`
WHERE `s` REGEXP '^[ЁА-пр-яё[:blank:]-]+$';

SELECT *
FROM `l-ts`
WHERE `s` REGEXP '^[a-z[:blank:]-]+$';

SELECT *
FROM `l-ts`
WHERE `s` REGEXP '^[а-яё[:blank:]-]+$';

SELECT *
FROM `l-ts`
WHERE `s` REGEXP '^[А-ЯЁа-яё[:blank:]-]+$';

#################################################

select count(*)
from `k-ts`
where `s` regexp '^[ЁА-пр-яё[:blank:]-]+$';

select count(*)
from `k-ts`
where `s` regexp '^[a-z[:blank:]-]+$';

select count(*)
from `k-ts`
where `s` regexp '^[а-яё[:blank:]-]+$';

select count(*)
from `k-ts`
where `s` regexp '^[А-ЯЁа-яё[:blank:]-]+$';

#################################################

SELECT `s`
FROM `k-ts`
WHERE `s` REGEXP '^[HEX(?)]+$';

<?php error_reporting( - 1 );

$select_translation = "SELECT
    `tz`.`z`
FROM
    `tz`
        JOIN
    `k_l` ON `tz`.`idz` = `k_l`.`idz`
        JOIN
    `l-ts` ON `k_l`.`idl` = `l-ts`.`ids`
WHERE
    `l-ts`.`s` = $keyword_hint
    limit 1
    ";

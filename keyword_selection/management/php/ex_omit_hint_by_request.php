<?php

declare(strict_types=1);
error_reporting(-1);

session_start();

require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');

$kw_ru = $_SESSION["original_kw"];

mysqli_query($mysqli, "
UPDATE `l-ts`
SET `f` = 5
WHERE `s` = '" . $kw_ru . "' 
");

mysqli_close($mysqli);
header("Location: //" . $_SERVER["HTTP_HOST"] . "/management/translation_hint.php");

<?php

declare(strict_types=1);
error_reporting(-1);

require($_SERVER["DOCUMENT_ROOT"] . '/_meta_privacy_db_connection.php');

$json_hints_string_for_translation = file_get_contents("php://input");
$json_hints_array_for_translation = json_decode($json_hints_string_for_translation);

foreach ($json_hints_array_for_translation as $element) {
    $element = mysqli_real_escape_string($mysqli, $element);
    mysqli_query($mysqli, "
	INSERT IGNORE INTO `l-ts` (`s`)
	VALUES ('" . $element . "')
    ");
    mysqli_query($mysqli, "
	UPDATE `l-ts`
	SET `f` = 7
	WHERE `s` = '" . $element . "' and `f` = 0
    ");
}

mysqli_close($mysqli);

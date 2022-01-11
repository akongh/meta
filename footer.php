<?php

$patch_to_feedback_data = $_SERVER["DOCUMENT_ROOT"] . "/../_meta_privacy/feedback_data";

if (file_exists($patch_to_feedback_data)) {
    $array_feedback_data = file($patch_to_feedback_data, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $feedback_data = "<br>" . implode("<br>", $array_feedback_data);
}
?>

<div class="footer">
    META 0.4.3
    <?php
    if (isset($feedback_data)) {
        echo $feedback_data;
    }
    ?>
</div>

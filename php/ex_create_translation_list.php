<?php
declare(strict_types=1);
error_reporting(-1);

session_start();
require($_SERVER["DOCUMENT_ROOT"] . '/_privacy_path.php');
require($_SERVER["DOCUMENT_ROOT"] . '/php/sql_prepared_statements.php');


unset(
    $_SESSION["err_msg_of_kws_amount"],
    $_SESSION["total_untranslated_ru_kws"]
);

$rus = $_POST["spisok_mesto"];
for ( $i = 0; $i < count( $rus ); $i ++ ) {

    if (!($mysqli_stmt = $mysqli->prepare(SQL_P_Z))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("s", $rus[ $i ])) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    $result = $mysqli_stmt->get_result();
    $mysqli_stmt->close();

    $SQL_p_z = $result->fetch_all(MYSQLI_ASSOC);

    foreach ( $SQL_p_z as $key => $val ) {
        $p[ $key ]   = $val["s"];
        $p2[ $key ]  = preg_replace( "/'/", "&#039;", $p[ $key ] );
        $z[ $key ]   = $val["z"];
        $p_z[ $key ] = "
        <label class='label-highlight separate-checkbox'>
            <span class='keyword-en'>
                <input type='checkbox' name='angl[]' value = '" . $p2[ $key ] . "'> " . $p[ $key ] . "
            </span> — " . $z[ $key ]. "
        </label>";
    }

    //выясняем флаг русского слова, если оно уже есть в базе, или его отсутствие, если слова в базе пока нет
    if (!($mysqli_stmt = $mysqli->prepare(SQL_F))) {
        echo PHP_EOL . $mysqli->errno . " --> " . $mysqli->error . PHP_EOL;
    }
    if (!$mysqli_stmt->bind_param("s", $rus[ $i ])) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    if (!$mysqli_stmt->execute()) {
        echo PHP_EOL . $mysqli_stmt->errno . " --> " . $mysqli_stmt->error . PHP_EOL;
    }
    $result = $mysqli_stmt->get_result();
    $mysqli_stmt->close();

    $SQL_f = $result->fetch_all(MYSQLI_ASSOC);

    foreach ( $SQL_f as $key => $val ) {
        $f[ $key ] = $val["f"];
    }

    if ( isset( $f[0] ) ) {
        $f = $f[0];
    } else {
        $f = null;
    };

    if ( isset( $p_z ) && count( $p_z ) > 1 ) {
        $p_z               = implode( "<br>", $p_z );
        $with_translation[ $i ] = "
        <div class = 'block-translated'>
		    <span class = 'keyword-ru'>
		        <input type='checkbox' name='russk[]' class='hidden' checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "
		    </span>
		    <br>
		    " . $p_z . "
		</div>
		";

    } else if ( isset( $p_z ) && count( $p_z ) == 1 ) {
        $p_z               = "
        <label class='label-highlight separate-checkbox'>
            <span class='keyword-en'>
                <input type='checkbox' name='angl[]' checked value = '" . $p2[0] . "'> " . $p[0] . "
            </span> — " . $z[0] . "
        </label>";
        $with_translation[ $i ] = "
        <div class = 'block-translated'>
		    <span class = 'keyword-ru'>
		        <input type='checkbox' name='russk[]' class='hidden' checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "
		    </span>
		    <br>
		    " . $p_z . "
		</div>
		";

    } else if ( ! isset( $p_z ) && ( $f == 0 or $f == null ) ) {
        $neperevedennye[ $i ] = $rus[ $i ];
        $with_translation[ $i ]    = "
        <div class = 'block-not-translated'>
		    <span class = 'keyword-ru'>
		        <input type='checkbox' name='russk[]' class='hidden' checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "
		    </span>
		    <br>
		    (перевода пока нет)<input type='checkbox' name='zayavka[]' class='hidden' checked value = '" . $rus[ $i ] . "'>
		</div>
		";

    } else if ( ! isset( $p_z ) && $f == 7 ) {
        $neperevedennye[ $i ] = $rus[ $i ];
        $with_translation[ $i ]    = "
        <div class = 'block-not-translated'>
		    <span class = 'keyword-ru'>
		        <input type='checkbox' name='russk[]' class='hidden' checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "
		    </span>
		    <br>
		    (в заявке на перевод)<input type='checkbox' name='zayavka[]' class='hidden' checked value = '" . $rus[ $i ] . "'>
		</div>
		";
    }

    unset( $p_z, $p, $z, $f );
}

$with_translation = implode( "<br>", $with_translation );

if ( isset( $neperevedennye ) ) {
    $neperevedennye_kol = count( $neperevedennye );
    $neperevedennye     = implode( ", ", $neperevedennye );

    $total_untranslated_ru_kws             = "
	<h2 class = 'bold'>Непереведённые</h2>
    <br>
    <span class='result' name='result-no-transl'>" . $neperevedennye . "</span>
    <span class='counter'> " . $neperevedennye_kol . "</span>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
	";
    $_SESSION["total_untranslated_ru_kws"] = $total_untranslated_ru_kws;
}

$_SESSION["with_translation"] = $with_translation;

if ( isset( $about_request ) ) {
    $_SESSION["about_request"] = $about_request;
}

$mysqli->close();
header( "Location: //" . $_SERVER["HTTP_HOST"] . "/step_5.php" );

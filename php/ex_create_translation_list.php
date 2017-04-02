<?php error_reporting( - 1 );
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );

unset(
    $_SESSION["oshibka_kolichestva"],
    $_SESSION["_REZULTAT_russk_neperevedennye"]
);

$rus = $_POST['spisok_mesto'];
for ( $i = 0; $i < count( $rus ); $i ++ ) {
    $SQL_p_z = mysqli_query( $db_connect, "
	select `l-ts`.`s`, `tz`.`z`
	from `k-ts`
	join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
	join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
	join `tz` on `tz`.`idz`=`k_l`.`idz`
	where `k-ts`.`s`='" . $rus[ $i ] . "'
	" );

    $n = 0;
    while ( $rez = mysqli_fetch_array( $SQL_p_z ) ) {
        $p[ $n ]   = $rez['s'];
        $p2[ $n ]  = preg_replace( "/'/", "&#039;", $p[ $n ] );
        $z[ $n ]   = $rez['z'];
        $p_z[ $n ] = "
        <label class='label-highlight'><span class=\"keyword-en\"><input type=\"checkbox\" name=\"angl[]\" value = '" . $p2[ $n ] . "'> " . $p[ $n ] . "</span> — " . $z[ $n ]. "</label>";
        $n ++;
    }

    //выясняем флаг русского слова, если оно уже есть в базе, или его отсутствие, если слова в базе пока нет
    $SQL_f = mysqli_query( $db_connect, "
	select `k-ts`.`f`
	from `k-ts`
	where `k-ts`.`s`='" . $rus[ $i ] . "'
	" );

    $n = 0;
    while ( $rez = mysqli_fetch_array( $SQL_f ) ) {
        $f[ $n ] = $rez['f'];
        $n ++;
    }

    if ( isset( $f[0] ) ) {
        $f = $f[0];
    } else {
        $f = null;
    };

    if ( isset( $p_z ) && count( $p_z ) > 1 ) {
        $p_z               = implode( "<br>", $p_z );
        $s_perevodom[ $i ] = "
        <div class = \"block-translated\">
		<span class = \"keyword-ru\"><input type=\"checkbox\" name=\"russk[]\" class=\"hidden\" checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "</span>
		<br>
		" . $p_z . "
		</div>
		";

    } else if ( isset( $p_z ) && count( $p_z ) == 1 ) {
        $p_z               = "
        <label class='label-highlight'><span class=\"keyword-en\"><input type=\"checkbox\" name=\"angl[]\" checked value = '" . $p2[0] . "'> " . $p[0] . "</span> — " . $z[0] . "</label>";
        $s_perevodom[ $i ] = "
        <div class = \"block-translated\">
		<span class = \"keyword-ru\"><input type=\"checkbox\" name=\"russk[]\" class=\"hidden\" checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "</span>
		<br>
		" . $p_z . "
		</div>
		";

    } else if ( ! isset( $p_z ) && ( $f == 0 or $f == null ) ) {
        $neperevedennye[ $i ] = $rus[ $i ];
        $s_perevodom[ $i ]    = "
        <div class = \"block-not-translated\">
		<span class = \"keyword-ru\"><input type=\"checkbox\" name=\"russk[]\" class=\"hidden\" checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "</span>
		<br>
		(перевода пока нет)<input type=\"checkbox\" name=\"zayavka[]\" class=\"hidden\" checked value = '" . $rus[ $i ] . "'>
		</div>
		";

    } else if ( ! isset( $p_z ) && $f == 7 ) {
        $neperevedennye[ $i ] = $rus[ $i ];
        $s_perevodom[ $i ]    = "
        <div class = \"block-not-translated\">
		<span class = \"keyword-ru\"><input type=\"checkbox\" name=\"russk[]\" class=\"hidden\" checked value = '" . $rus[ $i ] . "'>" . $rus[ $i ] . "</span>
		<br>
		(в заявке на перевод)<input type=\"checkbox\" name=\"zayavka[]\" class=\"hidden\" checked value = '" . $rus[ $i ] . "'>
		</div>
		";
    }

    unset( $p_z, $p, $z, $f );
}

$s_perevodom = implode( "<br>", $s_perevodom );

if ( isset( $neperevedennye ) ) {
    $neperevedennye_kol = count( $neperevedennye );
    $neperevedennye     = implode( ", ", $neperevedennye );

    $_REZULTAT_russk_neperevedennye             = "
	<h2 class = \"bold\">Непереведённые</h2>
    <br>
    <span class=\"result\" name=\"result-no-transl\">" . $neperevedennye . "</span>
    <span class=\"counter\"> " . $neperevedennye_kol . "</span>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
	";
    $_SESSION["_REZULTAT_russk_neperevedennye"] = $_REZULTAT_russk_neperevedennye;
}

$_SESSION["s_perevodom"] = $s_perevodom;

if ( isset( $pro_zayavku ) ) {
    $_SESSION["pro_zayavku"] = $pro_zayavku;
}

mysqli_close( $db_connect );
header( "Location: http://" . $site_domain_name . "/step_5.php" );
<?php error_reporting( 0 );

session_start();

unset(
	$_SESSION["oshibka_kolichestva"],
	$_SESSION["_REZULTAT_russk_neperevedennye"]
);

include( '/home/webart/www/d_meta/bd_meta.php' );

$rus = $_POST['spisok_mesto'];

for ( $i = 0; $i < count( $rus ); $i ++ ) {
	$SQL_p_z = mysql_query( "
	select `l-ts`.`s`, `tz`.`z`
	from `k-ts`
	join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
	join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
	join `tz` on `tz`.`idz`=`k_l`.`idz`
	where `k-ts`.`s`='" . $rus[ $i ] . "'
	" );

	$n = 0;

	while ( $rez = mysql_fetch_array( $SQL_p_z ) ) {
		$p[ $n ]   = $rez['s'];
		$p2[ $n ]  = preg_replace( "/'/", "&#039;", $p[ $n ] );
		$z[ $n ]   = $rez['z'];
		$p_z[ $n ] = "<span class=\"perevod\"><input type=\"checkbox\" name=\"angl[]\" value = '" . $p2[ $n ] . "'> " . $p[ $n ] . "</span><span class=\"znachenie\"> — " . $z[ $n ] . "</span>";
		$n ++;
	}

	//выясняем флаг русского слова, если оно уже есть в базе, или его отсутствие, если слова в базе пока нет
	$SQL_f = mysql_query( "
	select `k-ts`.`f`
	from `k-ts`
	where `k-ts`.`s`='" . $rus[ $i ] . "'
	" );

	$n = 0;

	while ( $rez = mysql_fetch_array( $SQL_f ) ) {
		$f[ $n ] = $rez['f'];
		$n ++;
	}

	$f = $f[0];//var_dump($f);

	if ( isset( $p_z ) && count( $p_z ) > 1 ) {
		$p_z               = implode( "<hr class=\"otbivka_0\">", $p_z );
		$s_perevodom[ $i ] = "<div class = \"blok_perevoda\">
		<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '" . $rus[ $i ] . "' hidden=\"true\">" . $rus[ $i ] . "</span><hr class=\"otbivka_6\">" . $p_z .
		                     "</div>";//*************************************************************************************************
	} else if ( isset( $p_z ) && count( $p_z ) == 1 ) {
		$p_z               = "<span class=\"perevod\"><input type=\"checkbox\" name=\"angl[]\" checked value = '" . $p2[0] . "'> " . $p[0] . "</span><span class=\"znachenie\"> — " . $z[0] . "</span>";
		$s_perevodom[ $i ] = "<div class = \"blok_perevoda\">
		<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '" . $rus[ $i ] . "' hidden=\"true\">" . $rus[ $i ] . "</span><hr class=\"otbivka_6\">" . $p_z .
		                     "</div>";//**************************************************************************************************
	} else if ( ! isset( $p_z ) && ( $f == 0 or $f == null ) )/////////////////
	{
		$neperevedennye[ $i ] = $rus[ $i ];
		$s_perevodom[ $i ]    = "<div class = \"blok_perevoda_netu\">
			<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '" . $rus[ $i ] . "' hidden=\"true\">" . $rus[ $i ] . "</span><hr class=\"otbivka_6\"><span class = \"perevoda_net\">* Перевода пока нет<input type=\"checkbox\" name=\"zayavka[]\" checked value = '" . $rus[ $i ] . "' hidden=\"true\"></span></div>";
		if ( ! isset( $pro_zayavku ) ) {
			$pro_zayavku = "<span class=\"upravlenie\">* Мы&nbsp;переводим ключевые слова в&nbsp;порядке убывания по&nbsp;их&nbsp;популярности. Переводим вручную, чтобы избежать неполноценности автоматического перевода. Ключевых слов не&nbsp;одна тысяча, и&nbsp;поэтому это&nbsp;долгий и&nbsp;кропотливый процесс. И&nbsp;хоть уже&nbsp;переведено достаточно ключевых слов, чтобы охватить наиболее популярные тематики среди авторов, всё&nbsp;равно встречаются менее используемые и&nbsp;поэтому пока непереведённые ключевые слова, которые автоматически попадают в список первоочерёдных на перевод при переходе к&nbsp;получению результата строками.
<hr class=\"otbivka_6\">
Данное ключевое слово к&nbsp;таковым и&nbsp;относится, и,&nbsp;если оно&nbsp;ещё&nbsp;не&nbsp;в&nbsp;списке первоочерёдных на&nbsp;перевод, оно&nbsp;будет в&nbsp;него добавлено, и&nbsp;мы&nbsp;его&nbsp;переведём в&nbsp;течение двух или&nbsp;более дней, в&nbsp;зависимости от&nbsp;нашей загрузки.
<hr class=\"otbivka_48\"></span>";
		}
	} else if ( ! isset( $p_z ) && $f == 7 )/////////////////
	{
		$neperevedennye[ $i ] = $rus[ $i ];
		$s_perevodom[ $i ]    = "<div class = \"blok_perevoda_netu\">
				<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '" . $rus[ $i ] . "' hidden=\"true\">" . $rus[ $i ] . "</span><hr class=\"otbivka_6\"><span class = \"perevod_v_zayavke\">* В заявке на перевод<input type=\"checkbox\" name=\"zayavka[]\" checked value = '" . $rus[ $i ] . "' hidden=\"true\"></span></div>";
		if ( ! isset( $pro_zayavku ) ) {
			$pro_zayavku = "<span class=\"upravlenie\">* Мы&nbsp;переводим ключевые слова в&nbsp;порядке убывания по&nbsp;их&nbsp;популярности. Переводим вручную, чтобы избежать неполноценности автоматического перевода. Ключевых слов не&nbsp;одна тысяча, и&nbsp;поэтому это&nbsp;долгий и&nbsp;кропотливый процесс. И&nbsp;хоть уже&nbsp;переведено достаточно ключевых слов, чтобы охватить наиболее популярные тематики среди авторов, всё&nbsp;равно встречаются менее используемые и&nbsp;поэтому пока непереведённые ключевые слова, которые автоматически попадают в список первоочерёдных на перевод при переходе к&nbsp;получению результата строками.
	<hr class=\"otbivka_6\">
	Данное ключевое слово к&nbsp;таковым и&nbsp;относится, и,&nbsp;если оно&nbsp;ещё&nbsp;не&nbsp;в&nbsp;списке первоочерёдных на&nbsp;перевод, оно&nbsp;будет в&nbsp;него добавлено, и&nbsp;мы&nbsp;его&nbsp;переведём в&nbsp;течение двух или&nbsp;более дней, в&nbsp;зависимости от&nbsp;нашей загрузки.
	<hr class=\"otbivka_48\"></span>";
		}
	}

	unset( $p_z, $p, $z, $f );
}

$s_perevodom = implode( "", $s_perevodom );//print_r($s_perevodom);

if ( isset( $neperevedennye ) ) {
	$neperevedennye_kol = count( $neperevedennye );
	$neperevedennye     = implode( ", ", $neperevedennye );

	$_REZULTAT_russk_neperevedennye             =
		"<div class = \"rezultat_fon_neperevedennye\">
	<span class = \"na_russk_angl\">Непереведённые</span>
	<hr class=\"otbivka_24\">
	<div class=\"select_result_not_transl\">"
		. $neperevedennye .
		"</div>
	<hr class=\"otbivka_24\">
	<div class=\"statistika\">Ключевых слов в группе — <span class=\"statistika_czyfra\">" . $neperevedennye_kol . "</span>.</div>
	<hr class=\"otbivka_6\">
	<span class=\"upravlenie\">Мы&nbsp;переводим ключевые слова в&nbsp;порядке убывания по&nbsp;их&nbsp;популярности. Переводим вручную, чтобы избежать неполноценности автоматического перевода. Ключевых слов не&nbsp;одна тысяча, и&nbsp;поэтому это&nbsp;долгий и&nbsp;кропотливый процесс. И&nbsp;хоть уже&nbsp;переведено достаточно ключевых слов, чтобы охватить наиболее популярные тематики среди авторов, всё&nbsp;равно встречаются менее используемые и&nbsp;поэтому пока непереведённые ключевые слова, которые автоматически попадают в список первоочерёдных на перевод при переходе к&nbsp;получению результата строками.
<hr class=\"otbivka_6\">
Данные ключевые слова к&nbsp;таковым и&nbsp;относится и&nbsp;мы&nbsp;их&nbsp;переведём в&nbsp;течение двух или&nbsp;более дней, в&nbsp;зависимости от&nbsp;нашей загрузки.</span>
	</div>";
	$_SESSION["_REZULTAT_russk_neperevedennye"] = $_REZULTAT_russk_neperevedennye;
}

$_SESSION["s_perevodom"] = $s_perevodom;

if ( isset( $pro_zayavku ) ) {
	$_SESSION["pro_zayavku"] = $pro_zayavku;
}

mysql_close( $podkluchenie );

header( "Location: http://meta.afoteris.com/shag_5.php" );

?>
<?php //error_reporting(0);

session_start();

unset(
$_SESSION["oshibka_kolichestva"],
$_SESSION["_REZULTAT_russk_neperevedennye"]
);

include ('/home/webart/www/_200slov.andrej.by/bd.php');

$rus = $_POST['spisok_mesto'];

for($i = 0; $i < count($rus); $i++)

{
	$SQL_p_z = mysql_query("
	select `l-ts`.`s`, `tz`.`z`
	from `k-ts`
	join `k_l` on `k-ts`.`ids`=`k_l`.`idk`
	join `l-ts` on `l-ts`.`ids`=`k_l`.`idl`
	join `tz` on `tz`.`idz`=`k_l`.`idz`
	where `k-ts`.`s`='".$rus[$i]."'
	");

	$n = 0;

	while ($rez = mysql_fetch_array($SQL_p_z))

	{
		$p[$n] = $rez['s']; //print_r($p[$n]); echo "<br>";
		$p2[$n] = preg_replace("/'/", "&#039;", $p[$n]);
		$z[$n] = $rez['z'];
		$p_z[$n] = "<span class=\"perevod\"><input type=\"checkbox\" name=\"angl[]\" value = '".$p2[$n]."'> ".$p[$n]."</span><span class=\"znachenie\"> — ".$z[$n]."</span>";
		$n++;
		}
		
	//if (isset($p_z) and count($p_z) == 1)

//	{
//		$p_z = "<span class=\"perevod\"><input type=\"checkbox\" name=\"angl[]\" checked value = '".$p[0]."'> ".$p[0]."</span><span class=\"znachenie\"> — ".$z[0]."</span>";
//		}

	if (isset($p_z) && count($p_z) > 1)

	{
		$p_z = implode("<hr class=\"otbivka_0\">", $p_z);
		$s_perevodom[$i] = "<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '".$rus[$i]."' hidden=\"true\">".$rus[$i]."</span><hr class=\"otbivka_6\">".$p_z;
		}
		else if (isset($p_z) && count($p_z) == 1)
		{
		$p_z = "<span class=\"perevod\"><input type=\"checkbox\" name=\"angl[]\" checked value = '".$p2[0]."'> ".$p[0]."</span><span class=\"znachenie\"> — ".$z[0]."</span>";
		$s_perevodom[$i] = "<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '".$rus[$i]."' hidden=\"true\">".$rus[$i]."</span><hr class=\"otbivka_6\">".$p_z;
			}
			else if (!isset($p_z))
			{
			$neperevedennye[$i] = $rus[$i];
			$s_perevodom[$i] = "<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '".$rus[$i]."' hidden=\"true\">".$rus[$i]."</span><hr class=\"otbivka_6\"><span class = \"perevoda_net\">* Перевода пока нет<input type=\"checkbox\" name=\"zayavka[]\" checked value = '".$rus[$i]."' hidden=\"true\"></span>";

				if(!isset($pro_zayavku))
				{
				$pro_zayavku = "<span class=\"upravlenie\">* Мы&nbsp;переводим ключевые слова в&nbsp;порядке убывания по&nbsp;их&nbsp;популярности. Переводим вручную, чтобы избежать неполноценности автоматического перевода. Ключевых слов не&nbsp;одна тысяча, и&nbsp;поэтому это&nbsp;долгий и&nbsp;кропотливый процесс. И&nbsp;хоть уже&nbsp;переведено достаточно ключевых слов, чтобы охватить наиболее популярные тематики среди авторов, всё&nbsp;равно встречаются менее используемые и&nbsp;поэтому пока непереведённые ключевые слова, которые автоматически попадают в список первоочерёдных на перевод при переходе к&nbsp;получению результата строками.
<hr class=\"otbivka_6\">
Данное ключевое слово к&nbsp;таковым и&nbsp;относится, и,&nbsp;если оно&nbsp;ещё&nbsp;не&nbsp;в&nbsp;списке первоочерёдных на&nbsp;перевод, оно&nbsp;будет в&nbsp;него добавлено, и&nbsp;мы&nbsp;его&nbsp;переведём в&nbsp;течение двух или&nbsp;более дней, в&nbsp;зависимости от&nbsp;нашей загрузки.
<hr class=\"otbivka_48\"></span>";
					}
		}
		
	unset($p_z, $p, $z);
	}

$s_perevodom = implode("</div><div class = \"blok_perevoda\">", $s_perevodom);//print_r($s_perevodom);

if(isset($neperevedennye))
{
	$neperevedennye_kol = count($neperevedennye);
	$neperevedennye = implode(", ", $neperevedennye);
	
	$_REZULTAT_russk_neperevedennye =
	"<div class = \"rezultat_fon_neperevedennye\">
	<span class = \"na_russk_angl\">Непереведённые</span>
	<hr class=\"otbivka_24\">"
	.$neperevedennye.
	"<hr class=\"otbivka_24\">
	<div class=\"statistika\">Ключевых слов в группе — <span class=\"statistika_czyfra\">" . $neperevedennye_kol . "</span>.</div>
	<hr class=\"otbivka_6\">
	<span class=\"upravlenie\">Мы&nbsp;переводим ключевые слова в&nbsp;порядке убывания по&nbsp;их&nbsp;популярности. Переводим вручную, чтобы избежать неполноценности автоматического перевода. Ключевых слов не&nbsp;одна тысяча, и&nbsp;поэтому это&nbsp;долгий и&nbsp;кропотливый процесс. И&nbsp;хоть уже&nbsp;переведено достаточно ключевых слов, чтобы охватить наиболее популярные тематики среди авторов, всё&nbsp;равно встречаются менее используемые и&nbsp;поэтому пока непереведённые ключевые слова, которые автоматически попадают в список первоочерёдных на перевод при переходе к&nbsp;получению результата строками.
<hr class=\"otbivka_6\">
Данные ключевые слова к&nbsp;таковым и&nbsp;относится и&nbsp;мы&nbsp;их&nbsp;переведём в&nbsp;течение двух или&nbsp;более дней, в&nbsp;зависимости от&nbsp;нашей загрузки.</span>
	</div>";
	$_SESSION["_REZULTAT_russk_neperevedennye"] = $_REZULTAT_russk_neperevedennye;
	}

$_SESSION["s_perevodom"] = $s_perevodom;

if(isset($pro_zayavku))

{
	$_SESSION["pro_zayavku"] = $pro_zayavku;
	}

mysql_close($podkluchenie);	

header("Location: http://200slov.andrej.by/shag_5.php");

?>
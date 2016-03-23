<?php //error_reporting(0);
session_start();
unset($_SESSION["oshibka_kolichestva"]);

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
		$p[$n] = $rez['s'];
		$z[$n] = $rez['z'];
		$p_z[$n] = "<span class=\"perevod\"><input type=\"checkbox\" name=\"angl[]\" value = '".$p[$n]."'> ".$p[$n]."</span><span class=\"znachenie\"> — ".$z[$n]."</span>";

		$n++;
		}
	if (isset($p_z))
	{
		$p_z = implode("<hr class=\"otbivka_0\">", $p_z);
		$s_perevodom[$i] = "<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '".$rus[$i]."' hidden=\"true\">".$rus[$i]."</span><hr class=\"otbivka_6\">".$p_z;
		}
		else
		{
			$s_perevodom[$i] = "<span class = \"russk\"><input type=\"checkbox\" name=\"russk[]\" checked value = '".$rus[$i]."' hidden=\"true\">".$rus[$i]."</span><hr class=\"otbivka_6\"><span class = \"perevoda_net\">…</span>";
			}

	unset($p_z, $p, $z);
	}
	
$s_perevodom = implode("</div><div class = \"blok_perevoda\">", $s_perevodom);//print_r($s_perevodom);

$_SESSION["s_perevodom"] = $s_perevodom;

mysql_close($podkluchenie);	

header("Location: http://200slov.andrej.by/shag_5.php");
?>
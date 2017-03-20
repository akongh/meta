<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 20.03.2017
 * Time: 23:00
 */

//var_dump(  );
//
//
//echo("  ");
//
//
//print_r(  );
//
//
//error_reporting(E_ALL ^E_NOTICE);
//
//
//echo "<pre>";
//print_r(array_keys(  ));
//echo "</pre>";


//из файла SQL_podbor_k.php
//$_SQL_zapros_podbor = "select `k-ts`.`s`, count(*)
//	  from (
//		select `k-t_s`.`id_n`
//		from  `k-ts`
//		join `k-t_s` on `k-t_s`.`id_s` = `k-ts`.`ids`
//		where `k-ts`.`s` in ('" . $_SQL_stroka_dlya_podbora . "')
//		group by `k-t_s`.`id_n` having count(/*distinct*/ `k-t_s`.`id_s`) = '" . $kolichestvo_opornyx_slov . "'
//		) `g`
//	  join `k-t_s` on `k-t_s`.`id_n` = `g`.`id_n`
//	  join `k-ts` on `k-ts`.`ids` = `k-t_s`.`id_s`
//	  /*where `k-ts`.`f` = 1*/
//	  group by `k-t_s`.`id_s`, `k-ts`.`s`
//	  order by count(*) desc, `k-ts`.`s` LIMIT 0," . $granicza . "
//	  ;
//	  ";


//из файла perevod_po_zayavke.php
//$slovo_kolichestvo = mysqli_query( $db_connect, "
//	SELECT `k-ts`.`s` slovo, count(*) kol
//	FROM `k-t_s`
//	join `k-ts` on `k-t_s`.`id_s` = `k-ts`.`ids`
//	where `k-ts`.`f` = 0
//	GROUP BY `k-t_s`.`id_s`
//	ORDER BY count(`k-t_s`.`id_s`) DESC
//	LIMIT 1
//	");
//
//$slovo_kolichestvo = mysqli_query( $db_connect, "
//	SELECT `s` slovo, `kol`
//	from `k-ts`
//	where `f` = 0 and `s` regexp ' '
//	ORDER BY `k-ts`.`kol` DESC
//	LIMIT 1
//	");
//
//mysqli_query( $db_connect, "
//	UPDATE `k-ts`
//	SET `f` = 10
//	WHERE `s` = '".$slovo."'
//	");


//из файла poluchit.php
//$russk_strokoj = implode("", $russk);
//$angl_strokoj = implode("", $angl);
//
//  if(!preg_match("/[а-яё]+/i", $russk_strokoj))
//  {
//  $angl = $russk;
//  unset($russk);
//  }
//////////////////////////////////////////////////////////////////////////////////////
//if(!preg_match("/[a-z]+/i", $massiv_itog_strokoj))
//{
//	include ('sql/SQL_sozdat_nabor_k.php');
//	}
//	else if (!preg_match("/[а-яё]+/i", $massiv_itog_strokoj))
//	{
//		include ('sql/SQL_sozdat_nabor_l.php');
//		}
//////////////////////////////////////////////////////////////////////////////////////
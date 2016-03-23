<?php //error_reporting(0);
include ('/home/webart/www/_z/bd.php');

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

$_SQL_zapros_podbor = "select `k-ts`.`s`, count(*)    
	  from (    
		select `k-t_s`.`id_n`    
		from  `k-ts`    
		join `k-t_s` on `k-t_s`.`id_s` = `k-ts`.`ids` 
		where `k-ts`.`s` in ('" . $_SQL_stroka_dlya_podbora . "')
		group by `k-t_s`.`id_n` having count(/*distinct*/ `k-t_s`.`id_s`) = '" . $kolichestvo_opornyx_slov . "'    
		) `g`   
	  join `k-t_s` on `k-t_s`.`id_n` = `g`.`id_n`    
	  join `k-ts` on `k-ts`.`ids` = `k-t_s`.`id_s`
	  where `k-ts`.`f` in (0, 1, 6, 7, 10)
	  group by `k-t_s`.`id_s`, `k-ts`.`s`    
	  order by count(*) desc, `k-ts`.`s` LIMIT 0," . $granicza . "
	  ;    
	  ";

$_SQL_rezultat_podbora = mysql_query($_SQL_zapros_podbor);
mysql_close($podkluchenie);
?>
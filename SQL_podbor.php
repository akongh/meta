<?php //error_reporting(0);
include ('bd.php');

$_SQL_zapros_podbor = "select `ts`.`s`, count(*)    
	  from (    
		select `t_s`.`id_n`    
		from  `ts`    
		join `t_s` on `t_s`.`id_s` = `ts`.`ids`    
		where `ts`.`s` in ('" . $_SQL_stroka_dlya_podbora . "')    
		group by `t_s`.`id_n` having count(/*distinct*/ `t_s`.`id_s`) = '" . $kolichestvo_opornyx_slov . "'    
		) `g`   
	  join `t_s` on `t_s`.`id_n` = `g`.`id_n`    
	  join `ts` on `ts`.`ids` = `t_s`.`id_s`    
	  group by `t_s`.`id_s`, `ts`.`s`    
	  order by count(*) desc, `ts`.`s` LIMIT 0, 200 
	  ;    
	  ";

$_SQL_rezultat_podbora = mysql_query($_SQL_zapros_podbor);
mysql_close($podkluchenie);
?>
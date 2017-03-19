<?php error_reporting(0);
include ('/home/webart/www/access_meta/db_connect.php');

$_SQL_zapros_podbor = "select `l-ts`.`s`, count(*)    
	  from (    
		select `l-t_s`.`id_n`    
		from  `l-ts`    
		join `l-t_s` on `l-t_s`.`id_s` = `l-ts`.`ids`    
		where `l-ts`.`s` in ('" . $_SQL_stroka_dlya_podbora . "')    
		group by `l-t_s`.`id_n` having count(/*distinct*/ `l-t_s`.`id_s`) = '" . $kolichestvo_opornyx_slov . "'    
		) `g`   
	  join `l-t_s` on `l-t_s`.`id_n` = `g`.`id_n`    
	  join `l-ts` on `l-ts`.`ids` = `l-t_s`.`id_s`    
	  group by `l-t_s`.`id_s`, `l-ts`.`s`    
	  order by count(*) desc, `l-ts`.`s` LIMIT 0," . $granicza . "
	  ;    
	  ";

$_SQL_rezultat_podbora = mysql_query($_SQL_zapros_podbor);
mysql_close($podkluchenie);
?>
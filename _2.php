<?php

ALTER TABLE t_s
ADD FOREIGN KEY vk_id_s(id_s)
REFERENCES ts(ids)
ON DELETE NO ACTION
ON UPDATE CASCADE;









tanglir 
Member

Откуда: 
 Сообщений: 21878	 1)
select ts.s, count(*)
from (
  select t_s.id_n
  from  ts -- 1.1, откуда берём данные
  join t_s on t_s.id_s = ts.ids -- 1.1, откуда берём данные
  where ts.s in ('" . $oporn_slova . "') -- 1.2, фильтр по словам
  group by t_s.id_n -- 1.3, группировка
  having count(/*distinct*/ t_s.id_s) = " . $kolichestvo_opornyx_slov . " 
-- 1.4 оставляем после группировки только такие id_n,
-- у которых количество id_s равно количеству нужных слов
  ) g -- 1
join t_s on t_s.id_n = g.id_n -- 1
join ts on ts.ids = t_s.id_s -- 1
group by t_s.id_s -- 2
order by count(*) desc, ts.s -- 3
;
 как-то так

2. Не джойнов, а запросов. "Вложенных джойнов", насколько я понимаю, не может быть в принципе.
3. Это на случай, если у вас могут быть дублирующиеся записи в таблице связей. В случае, когда у вас есть только связи, без какой-либо доп. информации о них (т.е. в таблице связей есть только 2 поля: ид1 и ид2), повторов быть и так не должно, ну и дистинкт тогда не нужен.
4. g - псевдоним для результата подзапроса. Того, что выполняется в скобках.
5. На верхнем уровне выводятся 2 поля: первое - само слово, второе - количество повторов этого слова. Сортировка выполняется после группировки; количество повторов - обычное поле результата, по нему спокойно можно сортировать.

Почитайте хотя бы Грабера, что ли. Для понимания этого запроса будет имхо вполне достаточно.












//для моей таблицы
mysql_query ("
select ts.s, count(*)
from (
  select t_s.id_n -- найденные id файлов, к которым привязаны сразу все наши заданные слова
  from  ts -- искомые слова отбираются по фильтру WHERE
  join t_s on t_s.id_s = ts.ids -- id всех файлов с заданнымим словами
  where ts.s in ('word2','word4','word6')
  -- оставить только файлы со всеми заданными словами сразу:
  group by t_s.id_n having count(/*distinct*/ t_s.id_s) = 3 
  ) g
join t_s on t_s.id_n = g.id_n -- получить id всех слов, привязанных к найденным файлам
join ts on ts.ids = t_s.id_s -- и сами слова по их id
group by t_s.id_s -- для каждого слова посчитать частоту (количество в выборке)
order by count(*) desc, ts.s -- отсортировать по частоте, для одинаковой частоты - по алфавиту
;
");
//######################################################################################################



//Нужен скрипт создания таблицы `tablizca_svyazej`, а лучше всех. 
//Если убрать INSERT INTO, а оставить только
mysql_query("
SELECT n.`id_nab` AS id_nabora, s.`id_sl` AS id_slov
FROM `tablizca_naborov` n
CROSS JOIN `tablizca_slov` s
WHERE n.`nabory` = '1405860994' AND s.`slova` = 'овпарвап'");
//так что-нибудь выдает?






//	#### ФОРМИРУЕМ ЗАПРОС #################################
//	$osnova_stroki_zaprosa = implode("', '", $oporn_slova_bez_probelov);//делаем из массива опорных слов основу строки для sql запроса
//	$stroka_zaprosa = "'" . $osnova_stroki_zaprosa . "'";//окончательно формируем строку для sql запроса
//	
//	$rezultat_podbora = mysql_query//подставляем строку для sql запроса в полный запрос
//	("
//	 SELECT `slova` FROM `tablizca_slov` WHERE `id` IN
//	(SELECT `id_slov` FROM `tablizca_svyazej` WHERE `id_naborov` IN 
//	(SELECT `id_naborov` FROM `tablizca_svyazej` WHERE `id_slov` IN 
//	(SELECT `id` FROM `tablizca_slov` WHERE `slova` IN (" . $stroka_zaprosa . "))))
//	");
//	//#######################################################

//############################################################################ отсюда начинается PHP #################################################
$vvod_slov = $_POST["vvod_slov"]; //помещаем в переменную опорные слова строкой
	$oporn_slova = explode("\n", $vvod_slov);//разбиваем строку опорных слов на части и заносим их в массив(есть лишние пробелы)

	for ($i = 0; $i < count($oporn_slova); $i++)//перебираем массив из строки в новый массив (без лишних пробелов)
		{
		$oporn_slova_bez_probelov[$i] = trim($oporn_slova[$i]);
		}
		
		$kolichestvo_opornyx_slov = count($oporn_slova_bez_probelov);//количество опорных слов
		
		
		for ($i = 0; i < $kolichestvo_opornyx_slov; $i++)
		{
			$massiv_osnovy_zaprosa[$i] = "
			(SELECT id_naborov FROM tablizca_svyazej WHERE id_slov = (SELECT id FROM tablizca_slov WHERE slovo = '" . $oporn_slova_bez_probelov[$i] . "')
			";
			}

$osnova_zaprosa = implode(" AND id_naborov IN ", $massiv_osnovy_zaprosa);

$rezultat_podbora = mysql_query("

SELECT slova FROM tablizca_slov WHERE id IN

(SELECT id_slov FROM tablizca_svyazej WHERE id_naborov IN

" . $osnova_zaprosa . "

");

//------------------------------------------------------------------------------------------------------
$osnova_zaprosa = "

(SELECT id_naborov FROM tablizca_svyazej WHERE id_slov = (SELECT id FROM tablizca_slov WHERE slova = '" . $slovo_N . "') AND id_naborov IN

…

(SELECT id_naborov FROM tablizca_svyazej WHERE id_slov = (SELECT id FROM tablizca_slov WHERE slova = '" . $slovo_2 . "') AND id_naborov IN

(SELECT id_naborov FROM tablizca_svyazej WHERE id_slov = (SELECT id FROM tablizca_slov WHERE slova = '" . $slovo_1 . "')

)

)

)

";
//------------------------------------------------------------------------------------------------------

// #############################################################################################
	$kluch_slovo = $_POST["vvod_slova"];
	
	$rezultat_podbora = mysql_query("
	SELECT `slova` 
	FROM `tablizca_slov` 
	WHERE `id` in
	
    (SELECT `id_slov` 
	FROM `tablizca_svyazej` 
	WHERE `id_naborov` in 
	
	(SELECT `id_naborov` 
	FROM `tablizca_svyazej` 
	WHERE `id_slov` in 
	
	(SELECT `id` 
	FROM `tablizca_slov` 
	WHERE `slova` = '".$kluch_slovo."')))
	", $podkluchenie);
// #############################################################################################	

/******************************************************************************
** Задача:                                                                   **
** — вносить в бд с одной стороны ключевые слова,                            **
**   а с другой информацию о файле (его имя и путь к нему)                   **
** — закреплять за этим файлом (привязывать к нему) некоторые ключевые слова **
******************************************************************************/

$q = mysql_query ("
create table tst_keywords (
  id int auto_increment primary key, 
  keyword varchar(100) unique
  );
insert tst_keywords (keyword) values
  ('word1'),('word2'),('word3'),('word4'),('word5'),('word6'),('word7'),('word8');

create table tst_files (
  id int auto_increment primary key, 
  name varchar(256), 
  fullpath varchar(256)
  );
insert tst_files (name,fullpath) values 
  ('file1','path1'),('file2','path2'),('file3','path3'),('file4','path4'),('file5','path5');

create table tst_filekeys (
  fid int, 
  wid int, 
  primary key PK_tst_filekeys_FW(fid,wid),
  key IX_tst_filekeys_WF(wid,fid),
  constraint FK_tst_filekeys_F foreign key(fid) references tst_files(id),
  constraint FK_tst_filekeys_W foreign key(wid) references tst_keywords(id)
  );
insert tst_filekeys (fid,wid) values
  (1,1),(1,2),      (1,4),      (1,6),
  (2,1),(2,2),      (2,4),(2,5),            (2,8),
        (3,2),(3,3),(3,4),      (3,6),      (3,8),
              (4,3),      (4,5),      (4,7),
  (5,1),      (5,3),                  (5,7)
  ;
  
");
?>

/******************************************************************************
** Задача:                                                                   **
** — по заданному ключевому слову искать в бд все другие ключевые слова,     **
**   привязанные к файлам, к которым привязано и заданное ключевое слово     **
** — выводить найденные ключевые слова списком с сортировкой                 **
**   по частоте встречания в пределах условия поиска.                        **
******************************************************************************/
<?php
$q = mysql_query ("
select
  wf.keyword, -- все ключевые слова, привязанные к файлам с заданным ключевым словом
  COUNT(*)qty -- частота встречания ключевых слов в пределах условия поиска
from tst_keywords w 
join tst_filekeys fw on fw.wid=w.id
join tst_filekeys fk on fk.fid=fw.fid
join tst_keywords wf on wf.id=fk.wid
where w.keyword = 'word7' -- заданное ключевое слово
group by wf.keyword
order by qty desc, wf.keyword
;
")
?>
/******************************************************************************
** Задача:                                                                   **
** Мы задаём, например, три ключевых слова для поиска.                       **
** Бд ищет все файлы, к которым привязаны сразу все три наши заданные слова. **
** Бд проверяет у всех найденных файлов связи с другими словами              **
** и выдаёт все связанные слова.                                             **
******************************************************************************/
<?php
$q = mysql_query ("

select w.keyword, count(*) qty
from (
  select fw.fid -- найденные id файлов, к которым привязаны сразу все наши заданные слова
  from  tst_keywords ws -- искомые слова отбираются по фильтру WHERE
  join tst_filekeys fw on fw.wid=ws.id -- id всех файлов с заданнымим словами
  where ws.keyword in ('word2','word4','word6')
  -- оставить только файлы со всеми заданными словами сразу:
  group by fw.fid having count(/*distinct*/ fw.wid)=3 
  )g
join tst_filekeys f on f.fid=g.fid -- получить id всех слов, привязанных к найденным файлам
join tst_keywords w on w.id=f.wid -- и сами слова по их id
group by f.wid -- для каждого слова посчитать частоту (количество в выборке)
order by qty desc,w.keyword -- отсортировать по частоте, для одинаковой частоты - по алфавиту
;
")
?>
select tst_keywords.keyword, count(*)
from (
  select tst_filekeys.fid -- найденные id файлов, к которым привязаны сразу все наши заданные слова
  from  tst_keywords -- искомые слова отбираются по фильтру WHERE
  join tst_filekeys on tst_filekeys.wid = tst_keywords.id -- id всех файлов с заданнымим словами
  where tst_keywords.keyword in ('word2','word4','word6')
  -- оставить только файлы со всеми заданными словами сразу:
  group by tst_filekeys.fid having count(/*distinct*/ tst_filekeys.wid) = 3 
  ) g
join tst_filekeys on tst_filekeys.fid = g.fid -- получить id всех слов, привязанных к найденным файлам
join tst_keywords on tst_keywords.id = tst_filekeys.wid -- и сами слова по их id
group by tst_filekeys.wid -- для каждого слова посчитать частоту (количество в выборке)
order by count(*) desc, tst_keywords.keyword -- отсортировать по частоте, для одинаковой частоты - по алфавиту
;
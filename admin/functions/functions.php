<?

//подсказка

function info($help)
{

echo"	<TABLE border=0 cellpadding=0 cellspacing=0 bgcolor=#FFFFFF class=b>
	<TR>
	<TD style='border-right: #CCCCCC 1px solid;' valign=top>

		<TABLE border=0 cellpadding=3 cellspacing=0>
		<TR><TD>Информация</TD></TR>
		</TABLE>
	
	</TD>
	<TD valign=top width=100%>

		<TABLE border=0 cellpadding=3 cellspacing=0 width=100%>
		<TR><TD>".$help."</TD></TR>
		</TABLE>

	</TD>
	</TR>
	</TABLE>";

}

function error_info($help)
{

echo"	<TABLE border=0 cellpadding=0 cellspacing=0 bgcolor=#FFFFFF class=b>
	<TR>
	<TD style='border-right: #CCCCCC 1px solid;' valign=top>

		<TABLE border=0 cellpadding=3 cellspacing=0>
		<TR><TD><FONT color=red>Ошибка</FONT></TD></TR>
		</TABLE>
	
	</TD>
	<TD valign=top>

		<TABLE border=0 cellpadding=3 cellspacing=0>
		<TR><TD><FONT color=red>".$help."</FONT></TD></TR>
		</TABLE>

	</TD>
	</TR>
	</TABLE>";

}

//проверка строки на 0-9a-z-_
function check_str($s)
{
	if (ereg("^[a-z0-9_-]{1,16}$",$s)) return true; else return false;
}


//проверка строки для модуля maillist
function check_str_maillist($s)
{
	if (ereg("^[a-z_-]{1,32}$",$s)) return true; else return false;
}




//
// проверяет мыло и возвращает
//  *  +1, если мыло пустое
//  *  -1, если не пустое, но с ошибкой
//  *  строку, если мыло верное
//

// доп. функция для удаления опасных сиволов
function pregtrim($str) {
   return preg_replace("/[^\x20-\xFF]/","",@strval($str));
}

function checkmail($mail) {
   // режем левые символы и крайние пробелы
   $mail=trim(pregtrim($mail)); // функцию pregtrim() возьмите выше в примере
   // если пусто - выход
   if (strlen($mail)==0) return 1;
   if (!preg_match("/^[a-z0-9_-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|".
   "edu|gov|arpa|info|biz|inc|name|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-".
   "9]{1,3}\.[0-9]{1,3})$/is",$mail))
   return -1;
   return $mail;

}

function pagebar($entries, $pbit, $pnow, $extra)
{
	global $lang;

	// количество страниц
	if ($pbit > 0) $numps = ceil($entries / $pbit);

	// защита от левого $pnow
	if ($pnow > $numps || $pnow < 1) $pnow = 1;

if ($numps > 1)
{
	$scripturl = explode("?" ,$_SERVER['REQUEST_URI']);
	$scripturl = $scripturl[0];


	echo "<BR>";
	echo "<TABLE cellpadding=1 cellspacing=0 border=0>\r\n";
	echo "<TR>\r\n";

	echo "<TD>\r\n";

	echo "<SPAN>".(($lang == "rus")?"Архив новостей":"News archive").":</SPAN> &nbsp;";
/*
	if ($pnow - 1 >= 1)
	{
		echo "&nbsp; <A title='Предыдущая страница' href=".$scripturl."?p=".($pnow-1).($extra!=""?$extra:"").">&laquo;&laquo;</A>&nbsp;";
		echo "&nbsp; <A title='Первая страница' href=".$scripturl."?p=1".($extra!=""?$extra:"").">&laquo;</A>&nbsp;";
	}
	else
	{
		echo "&nbsp;";
	}
	if ($numps > 5)
	{

		$start = $pnow - 2;
		$finish = $pnow + 2;

		if ($start <= 0)
		{
			$start = 1;
			$finish = 5;
		}
		elseif ($finish > $numps)
		{
			$finish = $numps;
			$start = $finish - 4;
		}
	}
	else
	{
		$start = 1;
		$finish = $numps;
	}
*/
	$start = 1;
	$finish = $numps;

	for ($i=$start; $i<=$finish; $i++)
	{
		$is = $i*10;

		if ($i != $pnow)
		{
			echo " <A href='".$scripturl."?p=".($i).($extra!=""?$extra:"")."'>".($i)."</A>";
		}
		else echo "&nbsp;<B>".$i."</B>";

		if ($i != $finish) echo "&nbsp;";
	}

/*
	if ($pnow < $numps)
	{
		echo "&nbsp;&nbsp;&nbsp;<A title='Последняя страница' href=".$scripturl."?p=".($numps).($extra!=""?$extra:"").">&raquo;</A>&nbsp;&nbsp;&nbsp;";
		echo "<A title='Следующая страница' href=".$scripturl."?p=".($pnow+1).($extra!=""?$extra:"").">&raquo;&raquo;</A> &nbsp;";
	}
	else
	{
		echo "&nbsp;";
	}
*/
	echo "</TD>\r\n";

	echo "</TR>\r\n";
	echo "</TABLE>\r\n";

}


}


//отдает данные страницы
function get_page_info($pageid)
{

	global $table, $MySQL;

	$page_url = "/";

	$sql_page = @mysql_fetch_array(@mysql_query("SELECT cleft, cright FROM ".$table['structure']." WHERE id='$pageid'"));

	$result = @mysql_query("SELECT cleft, cright, name, title FROM ".$table['structure']." WHERE cleft <= ".$sql_page['cleft']." AND cright >= ".$sql_page['cright']." AND clevel > 0 ORDER BY cleft");

	while ($sql = @mysql_fetch_array($result))
	{
		$page_url .= $sql['name']."/";
		$page_info['title'] = $sql['title'];
	}

	$page_info['url'] = $page_url;

	return $page_info;

}


?>
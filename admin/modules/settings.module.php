<?

switch ($action)
{

	case "modules":
	{
		//modules settings

		//нажали на "сохранить" :-)
		if ($save)
		{

			//база
			$result = @mysql_query("SELECT name, id FROM ".$table['modules']." GROUP BY name ORDER BY position");
			while ($sql = @mysql_fetch_array($result))
			{
				$publish_table[] = $sql['name'];
			}
			@mysql_free_result($result);

			//submit checkbox
			if (sizeof($publish) > 0)
			{
				foreach ($publish as $publish_name => $publish_value)
				{
					$publish_one[] = $publish_name;
				}
			}
			else $publish_one[] = "";

				for ($i=0; $i<sizeof($publish_table); $i++)
				{
					$flag = false;

					for ($j=0; $j<sizeof($publish_one); $j++)
					{
						if ($publish_table[$i] == $publish_one[$j]) $flag = true;
					}

					if (!$flag && $publish_table[$i] != $module && $publish_table[$i] != "users" && $publish_table[$i] != "cabinet") $publish_zero[] = $publish_table[$i];
				}


				for($i=0; $i<sizeof($publish_zero); $i++) //echo $publish_zero[$i]."<BR>";
					@mysql_query("UPDATE ".$table['modules']." SET publish='0' WHERE name='$publish_zero[$i]'");

				//echo "<HR>";

				for($i=0; $i<sizeof($publish_one); $i++) //echo $publish_one[$i]."<BR>";
					@mysql_query("UPDATE ".$table['modules']." SET publish='1' WHERE name='$publish_one[$i]'");


			// тут обработчик порядка модуля в навигации

			for ($i=0; $i<sizeof($sel); $i++)
			{
				@mysql_query("UPDATE ".$table['modules']." SET position='$sel[$i]' WHERE name='$publish_table[$i]'");
//				echo $publish_table[$i]." - ".$sel[$i]."<BR>";
			}

			exit(header("Location: redirect.php?".$QUERY_STRING));
		}

?>

	<FORM method="post" action="<?=$PHP_SELF."?".$QUERY_STRING?>">

	<INPUT type="hidden" name="submit_flag" value="true">

	<TABLE border="0" cellpadding="1">

	<TR bgcolor="#E3E3E3" height="19">
	<TD>&nbsp;<B>Модуль</B>&nbsp;</TD>
	<TD>&nbsp;<B>Файл</B>&nbsp;</TD>
	<TD align="center">&nbsp;<B>Использовать</B>&nbsp;</TD>
	<TD align="center">&nbsp;<B>Порядок в навигации</B>&nbsp;</TD>
	</TR>

<?

		$i=0;
		
		//для selected в порядке вывода меню
		$tmp_n = 1;

		$result = @mysql_query("SELECT * FROM ".$table['modules']." WHERE module != \"\" GROUP BY name ORDER BY position, id");
		while ($sql = @mysql_fetch_array($result))
		{

			echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";
			echo "\t<TD nowrap>&nbsp;<LABEL style=\"cursor: hand;\" for=\"label".$i."\">".$sql['title']."</LABEL>&nbsp;</TD>\r\n";
			echo "\t<TD>&nbsp;".$sql['module']."&nbsp;</TD>\r\n";
			echo "\t<TD align=\"center\"><INPUT style=\"cursor: hand;\" name=\"publish[".$sql['name']."]\" id=\"label".$i."\" type=\"checkbox\"".(($sql['publish'])?" checked":"").(($sql['module'] == $module || $sql['module'] == "users" || $sql['module'] == "cabinet")?" disabled":"")."></TD>\r\n";
			echo "\t<TD align=\"center\">\r\n\t<SELECT name=\"sel[".$i."]\">\r\n";

			for ($n=1; $n <= @mysql_num_rows($result); $n++)
			{
				echo "\t<OPTION value=\"".$n."\"".(($tmp_n == $n)?" selected":"").">".$n."\r\n";
			}
				
			$tmp_n++;

			echo "\t</SELECT>\r\n\t</TD>\r\n";
			echo "\t</TR>\r\n\r\n";

			$i++;
		}

		@mysql_free_result($result);

?>

	<TR>
		<TD colspan="4" align="center">
			<BR><INPUT type="submit" value="Сохранить" name="save" class="button">
		</TD>
	</TR>
	</TABLE>

	</FORM>

<?


	}
	break;
	default:
	{
		//general settings

		//нажали на кнопку "сохранить"
		if (isset($save))
		{
			foreach ($s as $s_var => $s_value)
			{
				@mysql_query("UPDATE ".$table['settings']." SET value='$s_value' WHERE var='$s_var'");
			}

			exit(header("Location: redirect.php?".$QUERY_STRING));
		}

		$result = @mysql_query("SELECT * FROM ".$table['settings']);
		while ($sql_settings = @mysql_fetch_array($result))
		{
			$settings2[$sql_settings['var']] = $sql_settings['value'];
		}

?>

	<FORM method="post" action="<?=$PHP_SELF."?".$QUERY_STRING?>">
	
	<INPUT type="hidden" name="submit_flag" value="true">

	<TABLE width="100%" border="0" cellpadding="1">
	<TR bgcolor="#E3E3E3" height="19">
		<TD colspan="2"><B>Общие настройки сайта</B></TD>
	</TR>
	<TR bgcolor="#FFFFFF">
		<TD nowrap>&nbsp;Адрес сайта:</TD>
		<TD width="100%"><INPUT type="text" size="50" style="width: 90%" value="<?=$settings['url'];?>" name="s[url]"></TD>
	</TR>
	<TR bgcolor="#F5F5F5">
		<TD nowrap>&nbsp;Название сайта:</TD>
		<TD><INPUT type="text" size="50" style="width: 90%" value="<?=$settings['title'];?>" name="s[title]"></TD>
	</TR>
	<TR bgcolor="#FFFFFF">
		<TD nowrap>&nbsp;Описание сайта (META DESCRIPTION):&nbsp;&nbsp;</TD>
		<TD><INPUT type="text" size="50" style="width: 90%" value="<?=$settings['meta_description'];?>" name="s[meta_description]"></TD>
	</TR>
	<TR bgcolor="#F5F5F5">
		<TD nowrap>&nbsp;Ключевые слова (META KEYWORDS):</TD>
		<TD><INPUT type="text" size="50" style="width: 90%" value="<?=$settings['meta_keywords'];?>" name="s[meta_keywords]"></TD>
	</TR>
	<!--TR bgcolor="#FFFFFF">
		<TD nowrap>&nbsp;E-mail для обратной связи:</TD>
		<TD><INPUT type="text" size="50" style="width: 90%" value="<?=$settings['email'];?>" name="s[email]"></TD>
	</TR-->
	<TR bgcolor="#F5F5F5" valign="top">
		<TD nowrap>&nbsp;Адрес:</TD>
		<TD>
<?
$oFCKeditor = new FCKeditor('s[contacts1]') ;
$oFCKeditor->BasePath	= "/admin/fckeditor/" ;
$oFCKeditor->Value	= $settings2['contacts1'] ;
$oFCKeditor->Width  = '90%' ;
$oFCKeditor->Height = '150' ;
$oFCKeditor->Create() ;
?>
		</TD>
	</TR>
	<TR bgcolor="#FFFFFF" valign="top">
		<TD nowrap>&nbsp;Контакты:</TD>
		<TD>
<?
$oFCKeditor = new FCKeditor('s[contacts2]') ;
$oFCKeditor->BasePath	= "/admin/fckeditor/" ;
$oFCKeditor->Value	= $settings2['contacts2'] ;
$oFCKeditor->Width  = '90%' ;
$oFCKeditor->Height = '150' ;
$oFCKeditor->Create() ;
?>
		</TD>
	</TR>
	<TR>
		<TD>&nbsp;</TD>
		<TD>
			<BR><INPUT type="submit" value="Сохранить" name="save" class="button">
		</TD>
	</TR>
	</TABLE>

	</FORM>



<?
	}
}


?>
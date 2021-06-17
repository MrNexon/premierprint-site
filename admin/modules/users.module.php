<?
	

switch($action)
{
	case "create":
	{
		
		if ($save)
		{
			$name = htmlspecialchars($name);
			$comments = htmlspecialchars($comments);

			if (sizeof($ch_mods) > 0)
			{
				foreach ($ch_mods as $ch_mod_name => $ch_mod_value)
				{
					$acc_mods .= $ch_mod_name." ";
				}
			}
			else $acc_mods = "";

			//доступные страницы структуры сайта (28.08.2004)
			if (isset($ch))
			{

				$struct_access = "";

				foreach ($ch as $ch_id => $ch_value)
				{
					$struct_access .= $ch_id."\r\n";
				}

			}

			if ($id == "")
			{
				if ($password == $password2 && check_str($password) && $password != "" && check_str($login))
				{
					//новая запись
					@mysql_query("INSERT INTO ".$table['users']." (name, login, password, access, modules, comments, structure) VALUES ('$name', '$login', '".md5($password)."', '$access', '$acc_mods', '$comments', '$struct_access')");
				}
				else exit(header("Location: ?module=".$module."&action=".$action."&error=2"));
			}
			else
			{

       				// изменение существующей
				if ($password == "" && $password2 == "")
				{//ok
					@mysql_query("UPDATE ".$table['users']." SET name='$name', access='$access', modules='$acc_mods', comments='$comments', structure='$struct_access' WHERE id='$id'");
				}
				elseif ($password == $password2)
				{
					@mysql_query("UPDATE ".$table['users']." SET name='$name', password='".md5($password)."', access='$access', modules='$acc_mods', comments='$comments', structure='$struct_access' WHERE id='$id'");
				}//ok
				else exit(header("Location: ?module=".$module."&action=".$action."&id=".$id."&error=1"));

			}

			exit(header("Location: redirect.php?module=".$module));
			
		}
		
		if (isset($id))
		{
			//выборка существующего пользователя для редактирования

			$result = @mysql_query("SELECT * FROM ".$table['users']." WHERE id='$id'");

			$sql_now = @mysql_fetch_array($result);

			@mysql_free_result($result);

		}

		info("Логин и пароль могут содержать только цифры, буквы латинского алфавита, а также тире и знак подчеркивания.");

		if ($error == 1)
		{
			echo "<BR>";
			error_info("Данные не обновлены! Проверьте правильность ввода данных и попробуйте еще раз.");
		}

		if ($error == 2)
		{
			echo "<BR>";
			error_info("Пользователь не создан! Проверьте правильность ввода данных и попробуйте еще раз.");
		}

?>

<FORM method="POST" action="<?=$PHP_SELF."?".$QUERY_STRING?>">

<INPUT type="hidden" name="submit_flag" value="true">

<INPUT name="id" value="<?=$sql_now['id']?>" type="hidden">

<TABLE cellpadding="3" cellspacing="2" border="0" width="430">

<TR>
	<TD colspan="2" bgcolor="#E3E3E3"><B>Редактирование профиля пользователя</B></TR>
</TR>

<TR bgcolor="#FFFFFF">
	<TD>Имя пользователя:</TD>
	<TD><INPUT type="text" name="name" maxlength="64" size="32" value="<?=$sql_now['name']?>"></TD>
</TR>
<TR bgcolor="#F5F5F5">
	<TD>Логин:<I><?=(!isset($id)?"<BR>(обязательно для заполнения)</I>":"")?></TD>
	<TD><?=(($sql_now['login'] != '')?$sql_now['login']:"<INPUT type=\"text\" name=\"login\" maxlength=\"16\" size=\"32\">")?></TD>
</TR>
<TR bgcolor="#FFFFFF">
	<TD>Пароль:<BR>(<I><?=(isset($id)?"оставьте это поле пустым, если не хотите менять пароль":"обязательно для заполнения")?>)</I></TD>
	<TD><INPUT type="password" name="password" maxlength="16" size="32"></TD>
</TR>
<TR bgcolor="#F5F5F5">
	<TD>Повторите пароль:<BR>(<I><?=(isset($id)?"оставьте это поле пустым, если не хотите менять пароль":"обязательно для заполнения")?>)</I></TD>
	<TD><INPUT type="password" name="password2" maxlength="16" size="32"></TD>
</TR>
<TR bgcolor="#FFFFFF">
	<TD>Права доступа:</TD>
	<TD>

<?

	if ($sql_now['login'] == $user['login'])
	{
		echo $user_access[$sql_now['access']]."\n";
		echo "<INPUT type=\"hidden\" name=\"access\" value=\"1\">\n";
	}
	else
	{

?>

		<SELECT name="access" style="width: 208px;">
		<OPTION value="0"<?=((!$sql_now['access'])?" selected":"")?>><?=$user_access[0]."\n"?>
		<OPTION value="1"<?=(($sql_now['access'])?" selected":"")?>><?=$user_access[1]."\n"?>
		</SELECT>

<?

	}

?>

	</TD>
</TR>
<TR bgcolor="#F5F5F5">
	<TD valign="top" nowrap>Доступные модули:<BR><I>(администратор имеет полный доступ ко<BR>всей системе)</I></TD>
	<TD width="100%">


		
		<TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
<?
		if (isset($id))
		{
			$user_mods = explode(" ",$sql_now['modules']);
		}

		$i=0;

		$result = @mysql_query("SELECT * FROM ".$table['modules']." WHERE publish && module != \"\" && name != \"settings\" && name != \"users\" && name!= \"cabinet\" && publish GROUP BY name ORDER BY position");
		while ($sql_mods = @mysql_fetch_array($result))
		{
			echo "\t\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";
			echo "\t\t<TD><INPUT name=\"ch_mods[".$sql_mods['name']."]\" id=\"l".$i."\" type=\"checkbox\" style=\"cursor:hand;\" ";
			
			for($j=0; $j<sizeof($user_mods); $j++)
			{
				if (trim($user_mods[$j]) == $sql_mods['name'] && trim($user_mods[$j]) != "cabinet")
				{
					echo "checked";
					break;
				}
			}

			echo "><LABEL style=\"cursor:hand;\" for=\"l".$i."\">".$sql_mods['title']."</LABEL></TD>\r\n";
			echo "\t\t</TR>\r\n\r\n";

			$i++;
		}

		@mysql_free_result($result);

?>		
		</TABLE>
		
	
	</TD>
</TR>
<TR bgcolor="#FFFFFF">
	<TD valign="top" colspan="2"><BR>Доступные разделы и страницы для редактирования в структуре сайта:</TD>
</TR>
<TR bgcolor="#FFFFFF">
	<TD valign="top" colspan="2">

		<TABLE width="100%" cellpadding="0">
	
<?	
		$struct_access = explode("\r\n", $sql_now['structure']);

		$result = @mysql_query("SELECT * FROM ".$table['structure']." WHERE is_rubric = '1' ORDER BY position, id");
		while ($sql = @mysql_fetch_array($result))
		{

			echo "\t<TR bgcolor=#E3E3E3><TD><INPUT ".(((in_array ($sql['id'], $struct_access)))?"checked":"")." name=ch[".$sql['id']."] value='1' type=checkbox id=ch".$sql['id']."><LABEL for=ch".$sql['id']."><B><FONT color=black>".$sql['heading']."</FONT></B></LABEL></TD></TR>\r\n\r\n";

				$result2 = @mysql_query("SELECT * FROM ".$table['structure']." WHERE is_rubric = '0' && rubric = '".$sql['id']."' ORDER BY position, id");
				while ($sql2 = @mysql_fetch_array($result2))
				{

					echo "\t\t<TR bgcolor=#F5F5F5><TD>&nbsp; &nbsp; &nbsp;<INPUT ".(((in_array ($sql2['id'], $struct_access)))?"checked":"")." name=ch[".$sql2['id']."] value='1' type=checkbox id=ch".$sql2['id']."><LABEL for=ch".$sql2['id']."><FONT color=black>".$sql2['heading']."</FONT></LABEL></TR>\r\n";

				}
		
				@mysql_free_result($result2);

				echo "\r\n";
		}

		@mysql_free_result($result);

?>
		</TABLE>

		<BR>

	</TD>
</TR>
<TR bgcolor="#F5F5F5">
	<TD valign="top">Комментарии:<BR><I>(до 255 символов)</I></TD>
	<TD><TEXTAREA name="comments" cols="31" rows="5"><?=$sql_now['comments']?></TEXTAREA></TD>
</TR>
<TR>
	<TD colspan="2" align="center">
		<BR><INPUT type="submit" value="Сохранить" class="button" name="save">

<?
		if (isset($id))
		{

			echo "&nbsp;&nbsp;<INPUT type=\"button\" value=\"Вернуться\" class=\"button\" onclick=\"if (confirm('Выйти без сохранения изменений?')){history.back(-1);}\">\n\n";

		}
?>

	</TD>
</TR>

</TABLE>

</FORM>

<?
	}
	break;
	default:
	{
		//удаляем пользователя
		if (isset($del))
		{
			if ($user['id'] != $del) @mysql_query("DELETE FROM ".$table['users']." WHERE id='$del'");
			exit(header("Location: redirect.php?module=users&action=list"));
		}

		info("Пользователи ниже статуса &#171;Администратор&#187; не имеют доступа к модулю &#171;Пользователи системы&#187;.");
?>

	<SCRIPT language="javascript">
	<!--
	function del(id){
	if (confirm("Вы действительно хотите удалить пользователя?")){parent.location='?<?=$QUERY_STRING?>&submit_flag=1&del=' + id;}}
	//-->
	</SCRIPT>

	<BR>

	<TABLE width="100%" border="0" cellpadding="3">


	<TR bgcolor="#E3E3E3">
	<TD><B>Пользователь</B></TD>
	<TD><B>Логин</B></TD>
	<TD><B>Права</B></TD>
	<TD><B>Разрешенные модули</B></TD>
	<TD><B>Комментарии</B></TD>
	<TD><B>Редактировать</B></TD>
	<TD><B>Удалить</B></TD>
	</TR>


<?

		$i=0;

		$k=0;

		$result = @mysql_query("SELECT * FROM ".$table['modules']." WHERE publish && module != \"\" && name != \"settings\" && name != \"users\" && publish GROUP BY name ORDER BY position DESC");
		while ($sql_mods = @mysql_fetch_array($result))
		{
			$mods_acc[$k]['title'] = $sql_mods['title'];
			$mods_acc[$k]['name'] = $sql_mods['name'];

			$k++;
		}

		unset($k);

		@mysql_free_result($result);

		$result = @mysql_query("SELECT * FROM ".$table['users']." ORDER BY id");
		while ($sql_users = @mysql_fetch_array($result))
		{
			if (!$sql_users['access'])
			{
				$mods_str = "";
				$user_mods = explode(" ",$sql_users['modules']);

				for ($j=0; $j<sizeof($user_mods); $j++)
				{
					for ($k=0; $k<sizeof($mods_acc); $k++)
					{
						if (trim($user_mods[$j]) == $mods_acc[$k]['name'])
						{
							$mods_str .= $mods_acc[$k]['title'];
							if ($j < sizeof($user_mods)-1) $mods_str .= "<BR>";
							break;
						}
					}
				}
				
			}


			echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF")." valign=\"top\">\r\n";
			
			echo "\t<TD nowrap>".$sql_users['name']."</TD>\r\n";
			echo "\t<TD>".$sql_users['login']."</TD>\r\n";
			echo "\t<TD>".$user_access[$sql_users['access']]."</TD>\r\n";
			echo "\t<TD>".(($sql_users['access'])?"<B>Полный доступ</B>":$mods_str."&nbsp;")."</TD>\r\n";
			echo "\t<TD>".str_replace("\r\n","<BR>",$sql_users['comments'])."&nbsp;</TD>\r\n";
			echo "\t<TD><A href=\"./?module=".$module."&action=create&id=".$sql_users['id']."\">Редактировать</A></TD>\r\n";
			echo "\t<TD>".(($sql_users['login'] == $user['login'])?"&nbsp;":"<A href=\"javascript:del('".$sql_users['id']."');\">Удалить</A>")."</TD>\r\n";

			echo "\t</TR>\r\n\r\n";

			$i++;
		}

		@mysql_free_result($result);

?>


	</TABLE>

        
<?
	}
}

?>


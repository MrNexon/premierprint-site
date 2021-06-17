<?

if ($save)
{
	if (md5($old_password) == $user['password'] && $new_password1 == $new_password2 && check_str($new_password1))
	{
		@mysql_query("UPDATE ".$table['users']." SET password='".md5($new_password1)."' WHERE login='$user[login]'");

		//чтобы не выкинуло подменяем session['password']
		$session['password'] = md5($new_password1);
		exit(header("Location: redirect.php?module=cabinet"));
	}
	else exit(header("Location: ?module=".$module."&action=".$action."&error=1"));
}

info("Пароль может содержать только цифры, буквы латинского алфавита, а также тире и знак подчеркивания.");

if ($error)
{
	echo "<BR>";
	error_info("Данные не сохранены! Проверьте правильность ввода данных и попробуйте еще раз.");
}

?>


<FORM method="post" action="<?=$PHP_SELF."?".$QUERY_STRING?>">

<INPUT type="hidden" name="submit_flag" value="true">

<TABLE cellpadding="0" border="0" width="350">

<TR bgcolor="#E3E3E3" height="18">
	<TD colspan="2"><B>&nbsp;Пользователь</B><BR></TD>
</TR>

<TR bgcolor="#FFFFFF" height="18">
	<TD>&nbsp;Имя:</TD>
	<TD><?=$user['name']?></TD>
</TR>

<TR bgcolor="#F5F5F5" height="18">
	<TD>&nbsp;Логин:</TD>
	<TD><?=$user['login']?></TD>
</TR>

<TR bgcolor="#FFFFFF" height="18">
	<TD>&nbsp;Права:</TD>
	<TD><?=$user_access[$user['access']]?></TD>
</TR>

<TR>
	<TD colspan="2"><BR><BR></TD>
</TR>

<TR bgcolor="#E3E3E3" height="18">
	<TD colspan="2"><B>&nbsp;Смена пароля</B></TD>
</TR>

<TR bgcolor="#FFFFFF">
	<TD nowrap>&nbsp;Старый пароль:</TD>
	<TD><INPUT type="password" maxlength="16" name="old_password"></TD>
</TR>

<TR bgcolor="#F5F5F5">
	<TD nowrap>&nbsp;Новый пароль:</TD>
	<TD><INPUT type="password" maxlength="16" name="new_password1"></TD>
</TR>

<TR bgcolor="#FFFFFF">
	<TD nowrap>&nbsp;Повторите новый пароль:</TD>
	<TD><INPUT type="password" maxlength="16" name="new_password2"></TD>
</TR>

<TR>
	<TD colspan=2 align="center"><BR><INPUT type="submit" value="Сохранить" class="button" name="save"></TD>
</TR>

</TABLE>


</FORM>
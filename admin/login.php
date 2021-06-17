<?

//инициализация сессии
unset($session);
session_start();
session_register("session");

$session['login'] = $user_login;
$session['password'] = md5($user_password);


include("init.php");
include("classes/auth.php");

$auth = new User;


if ($QUERY_STRING == "logout") $auth -> LogOut();

if ($login_btn)
{
	if ($auth -> Auth()) exit(header("Location: index.php"));
	else exit(header("Location: login.php"));
}


?>

<HTML>
<HEAD>
	<TITLE>Вход в систему</TITLE>
	<LINK href="style.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY bgcolor="#FAFAFA" link="#777777" alink="#777777" vlink="#777777" text="#000000" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">

<FORM method="post" action="<?=$PHP_SELF?>">

<TABLE width="100%" height="100%" border="0">
<TR><TD align="center">

	<TABLE border="0" cellpadding="10" cellspacing="0" bgcolor="#FFFFFF" class="b">
	<TR><TD align="center">

		<TABLE cellpadding="0" cellspacing="7" border="0" width="240" class="b" bgcolor="#f5f5f5">
		<TR>
			<TD align="center"><B>Вход в систему</B></TD>
		</TR>
		</TABLE>

		<TABLE cellpadding="2" cellspacing="5" border="0" width="250">
		<TR>
			<TD>Логин:</TD>
			<TD align="right"><INPUT type="text" size="17" maxlength="16" name="user_login"></TD>
		</TR>
		<TR>
			<TD>Пароль:</TD>
			<TD align="right"><INPUT type="password" size="17" maxlength="16" name="user_password"></TD>
		</TR>
		<TR>
			<TD colspan="2" align="center"><INPUT type="submit" value="Войти" name="login_btn"></TD>
		</TR>
		</TABLE>

	
	</TD></TR>
	</TABLE>


<BR><BR>
Для входа в систему опция &#171;cookies&#187; в броузере должна быть включена.

<TD></TR>
</TABLE>

</FORM>


</BODY>
</HTML>
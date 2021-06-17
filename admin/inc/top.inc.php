
<HTML>
<HEAD>
	<TITLE>Административная панель</TITLE>
	<LINK href="/admin/style.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY bgcolor="#FFFFFF" link="#777777" alink="#777777" vlink="#777777" text="#000000" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">

<!-- top -->

<TABLE cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#B7B7B7" background="images/topbg.gif">
<TR><TD colspan="3">

	<IMG align="absmiddle" alt="" src="images/1x1.gif" width="760" height="1" border="0"><BR>

</TD></TR>
<TR><TD>

	<IMG align="absmiddle" alt="" src="images/1x1.gif" width="1" height="32" border="0"><BR>

</TD>
<TD class="top" nowrap>

	&nbsp;<?=$settings['title']."\n";?>
	&nbsp;<IMG align="absmiddle" alt="" src="images/topbr.gif" width="2" height="21" border="0">&nbsp;
	<A href="<?=$settings['url'];?>" class="top"><?=$settings['url'];?></A>

</TD>
<TD class="top" align="right" nowrap>

	<A href="/admin/filemanager/" target="_blank" class="top">File Manager</A>&nbsp;
	&nbsp;<IMG align="absmiddle" alt="" src="images/topbr.gif" width="2" height="21" border="0">&nbsp;
	<A href="login.php?logout" class="top" title="Выйти из системы">Выход</A>&nbsp;

</TD></TR>
</TABLE>

<!-- /top -->

<BR>


<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
<TR><TD bgcolor="#9C9C9C" valign="top" colspan="4">

	<IMG alt="" src="images/1x1.gif" width="1" height="1" border="0"><BR>

</TD></TR>
<TR>

	<TD valign="top" bgcolor="#B7B7B7" background="images/leftbg.gif">

		<IMG alt="" src="images/1x1.gif" width="30" height="1" border="0"><BR>
		<IMG alt="" src="images/1x1.gif" width="1" height="300" border="0"><BR>

	</TD>
	<TD bgcolor="#EEEEEE" valign="top" class="menu">


		<TABLE cellpadding="1" cellspacing="0" border="0" width="100%">
		<TR><TD bgcolor="<?=(($inc_module == "default")?"#FDFDFD":"#DDDDDD")?>" class="menuoff">

			<IMG align="absmiddle" alt="" src="images/marker.gif" height="18" border="0">
			<A href="./" class="menu">Главная</A>

		</TD></TR>
		<TR><TD bgcolor="#9C9C9C" valign="top">

			<IMG alt="" src="images/1x1.gif" width="200" height="1" border="0"><BR>

		</TD></TR>


		<TR><TD bgcolor="#EEEEEE" valign="top">

			<IMG alt="" src="images/1x1.gif" width="1" height="1" border="0"><BR>

		</TD></TR>

<?
		//генерация меню

		$result = @mysql_query("SELECT * FROM ".$table['modules']." WHERE module != \"\" AND publish = \"1\" GROUP BY name ORDER BY position, id");
		while ($sql_menu = @mysql_fetch_array($result))
		{
			if (!$user['access'])
			{
				for ($i=0; $i<sizeof($acc_mods); $i++)
				{
					if (trim($acc_mods[$i]) == $sql_menu['name'] && $acc_mods[$i] != "settings" && $acc_mods[$i] != "users")
					{

						echo "\t\t<TR><TD class=\"".(($module == $sql_menu['name'])?"menuon":"menuoff")."\">\r\n";

						echo "\t\t<IMG align=\"absmiddle\" alt=\"\" src=\"images/marker.gif\" height=\"18\" border=\"0\">\r\n";
						echo "\t\t<A href=\"./?module=".$sql_menu['name']."\" class=\"menu\">".$sql_menu['title']."</A><BR>\r\n";

						echo "\t\t</TD></TR>\r\n\r\n";

						break;
					}
				}
			}
			else
			{
				echo "\t\t<TR><TD class=\"".(($module == $sql_menu['name'])?"menuon":"menuoff")."\">\r\n";

				echo "\t\t<IMG align=\"absmiddle\" alt=\"\" src=\"images/marker.gif\" height=\"18\" border=\"0\">\r\n";
				echo "\t\t<A href=\"./?module=".$sql_menu['name']."\" class=\"menu\">".$sql_menu['title']."</A><BR>\r\n";

				echo "\t\t</TD></TR>\r\n\r\n";
			}

		}

		@mysql_free_result($result);
?>

		</TABLE>

	</TD>
	<TD bgcolor="#9C9C9C" valign="top">

		<IMG alt="" src="images/1x1.gif" width="1" height="1" border="0"><BR>

	</TD>
	<TD width="100%" valign="top" bgcolor="#FAFAFA">

		<TABLE cellpadding="1" cellspacing="0" border="0" width="100%">
		<TR><TD bgcolor="#EEEEEE" class="menuoff">

		<IMG align="absmiddle" alt="" src="images/1x1.gif" width="1" height="18" border="0">

<?
		//генерация подменю

		$result = @mysql_query("SELECT * FROM ".$table['modules']." WHERE name='$module' AND module = '' ORDER BY id");
		while ($sql_submenu = @mysql_fetch_array($result))
		{

			echo "\t\t<IMG align=\"absmiddle\" alt=\"\" src=\"images/marker.gif\" height=\"18\" border=\"0\">\r\n";
			echo "\t\t<A href=\"./?module=".$sql_submenu['name']."&action=".$sql_submenu['action']."\" class=\"menu\">".$sql_submenu['title']."</A>&nbsp;&nbsp;&nbsp;\r\n\r\n";

		}

		@mysql_free_result($result);
?>

		</TD></TR>
		<TR><TD bgcolor="#9C9C9C" valign="top">

			<IMG alt="" src="images/1x1.gif" width="1" height="1" border="0"><BR>

		</TD></TR>
		<TR><TD>

			<TABLE cellpadding="15" cellspacing="0" border="0" width="100%">
			<TR><TD>


<!-- include module "<?=$inc_module.".module.php"?>" -->


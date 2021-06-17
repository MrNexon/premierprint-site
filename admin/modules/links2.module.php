<?

if ($action == "create")
{
	if (isset($save))
	{

		if ($id == "")
		{
			@mysql_query("INSERT INTO ".$table['links2']." (id) VALUES ('')");
			$lastid = @mysql_fetch_array(@mysql_query("SELECT LAST_INSERT_ID() as id FROM ".$table['links2']));
			$id = $lastid['id'];
		}

		@mysql_query("UPDATE ".$table['links2']." SET 

			  position	= '".addslashes($position)."',
			  link		= '".addslashes($link)."',
			  publish	= '".addslashes($publish)."',
			  name		= '".addslashes($name)."'

		WHERE id='".$id."'");

		exit(header("Location: redirect.php?module=".$module));

	}

		if (isset($id))
		{
			//выборка существующей записи для редактирования
			$result = @mysql_query("SELECT * FROM ".$table['links2']." WHERE id='$id'");
			$sql_now = @mysql_fetch_array($result);

			$sql_now_date = getdate(strtotime($sql_now['adddate']));
		}


?>

		<FORM method="POST" action="<?=$PHP_SELF."?module=".$module?>" ENCTYPE="multipart/form-data">

		<INPUT type="hidden" name="submit_flag" value="true">
		<INPUT type="hidden" name="action" value="<?=$action?>">

		<INPUT type="hidden" name="id" value="<?=$sql_now['id']?>">

		<TABLE cellpadding="5" cellspacing="0" border="0" width="100%">
		<TR>

			<TD>Публиковать:</TD>

			<TD>

			<SELECT name="publish">

			<OPTION value="1" <?=($sql_now['publish']=="1")?"selected":""?>>Да
			<OPTION value="0" <?=($sql_now['publish']=="0")?"selected":""?>>Нет

			</SELECT>

			</TD>

		</TR>
		<TR>
			<TD nowrap>Название:</TD>
			<TD width="100%"><INPUT type="text" name="name" maxlength="255" size="55" value="<?=htmlspecialchars(stripslashes($sql_now['name']))?>"></TD>
		</TR>
		<TR>
			<TD nowrap>Ссылка:</TD>
			<TD width="100%"><INPUT type="text" name="link" maxlength="255" size="55" value="<?=htmlspecialchars(stripslashes($sql_now['link']))?>"></TD>
		</TR>
		<TR>
			<TD nowrap>Позиция:</TD>
			<TD><INPUT type="text" name="position" maxlength="5" size="5" value="<?=htmlspecialchars(stripslashes($sql_now['position']))?>"></TD>
		</TR>
		<TR>
			<TD>&nbsp;</TD>
			<TD><INPUT type="submit" value="Сохранить" name="save" class="button"></TD>
		</TR>
		</TABLE>

		</FORM>

<?


}
else
{
	if (isset($del))
	{
		@mysql_query("DELETE FROM ".$table['links2']." WHERE id='$del'");
		exit(header("Location: redirect.php?module=".$module));
	}

?>

	<SCRIPT language="javascript">
	<!--
	function del(id){
	if (confirm("Удалить?")){parent.location='?<?=$QUERY_STRING?>&submit_flag=1&del=' + id;}}
	//-->
	</SCRIPT>


	<TABLE width="100%" border="0" cellpadding="3">

	<TR bgcolor="#E3E3E3">
	<TD width="50%"><B>Ссылка</B></TD>
	<TD><B>Опубликована</B></TD>
	<TD><B>Позиция</B></TD>
	<TD><B>Редактировать</B></TD>
	<TD><B>Удалить</B></TD>
	</TR>

<?
	$i=0;

	$result = @mysql_query("SELECT * FROM ".$table['links2']." ORDER BY position, name, id DESC");
	while ($sql = @mysql_fetch_array($result))
	{
		echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";

		echo "\t<TD>".$sql['name']."</TD>\r\n";
		echo "\t<TD>".(($sql['publish'] == 1)?"Да":"Нет")."</TD>\r\n";
		echo "\t<TD>".$sql['position']."</TD>\r\n";
		echo "\t<TD><A href=\"./?module=".$module."&action=create&id=".$sql['id']."\">Редактировать</A></TD>\r\n";
		echo "\t<TD><A href=\"javascript:del('".$sql['id']."');\">Удалить</A></TD>\r\n";

		echo "\t</TR>\r\n\r\n";

		$i++;

	}


?>
	
	</TABLE>


<?


}


?>

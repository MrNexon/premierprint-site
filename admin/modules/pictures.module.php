<?

$action = "create";
$id = 1;

if ($action == "create")
{
	if (isset($save))
	{

		if ($id == "")
		{
			@mysql_query("INSERT INTO ".$table['pictures']." (id) VALUES ('')");
			$lastid = @mysql_fetch_array(@mysql_query("SELECT LAST_INSERT_ID() as id FROM ".$table['pictures']));
			$id = $lastid['id'];
		}

		@mysql_query("UPDATE ".$table['pictures']." SET 

			  text		= '".addslashes($text)."',
			  announce	= '".addslashes($announce)."',
			  engname	= '".addslashes($engname)."',
			  engtext	= '".addslashes($engtext)."',
			  engannounce	= '".addslashes($engannounce)."'

		WHERE id='".$id."'");

		//////////////////////////////////////

		if (is_uploaded_file($picture))
		{
			if (!file_exists($DOCUMENT_ROOT."/media/pictures/".$id."/"))
			{
				mkdir($DOCUMENT_ROOT."/media/pictures/".$id."/");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_picture) && $old_picture != "")
			{
				@unlink($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_picture);
			}

			move_uploaded_file($picture,$DOCUMENT_ROOT."/media/pictures/".$id."/".$picture_name);
			@mysql_query("UPDATE ".$table['pictures']." SET picture='".$picture_name."' WHERE id='$id'");

			chmod($DOCUMENT_ROOT."/media/pictures/".$id."/".$picture_name, 0755);
		}

		if ($delpic == 1 && $picture_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_picture);
			@mysql_query("UPDATE ".$table['pictures']." SET picture='' WHERE id='$id'");
		}

		//////////////////////////////////////

		//////////////////////////////////////

		if (is_uploaded_file($picture2))
		{
			if (!file_exists($DOCUMENT_ROOT."/media/pictures/".$id."/"))
			{
				mkdir($DOCUMENT_ROOT."/media/pictures/".$id."/");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_picture2) && $old_picture2 != "")
			{
				@unlink($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_picture2);
			}

			move_uploaded_file($picture2,$DOCUMENT_ROOT."/media/pictures/".$id."/".$picture2_name);
			@mysql_query("UPDATE ".$table['pictures']." SET picture2='".$picture2_name."' WHERE id='$id'");

			chmod($DOCUMENT_ROOT."/media/pictures/".$id."/".$picture2_name, 0755);
		}

		if ($delpic1 == 1 && $picture2_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_picture2);
			@mysql_query("UPDATE ".$table['pictures']." SET picture2='' WHERE id='$id'");
		}

		//////////////////////////////////////

		//////////////////////////////////////

		if (is_uploaded_file($smallpicture))
		{
			if (!file_exists($DOCUMENT_ROOT."/media/pictures/".$id."/"))
			{
				mkdir($DOCUMENT_ROOT."/media/pictures/".$id."/");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_smallpicture) && $old_smallpicture != "")
			{
				@unlink($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_smallpicture);
			}

			move_uploaded_file($smallpicture,$DOCUMENT_ROOT."/media/pictures/".$id."/".$smallpicture_name);
			@mysql_query("UPDATE ".$table['pictures']." SET smallpicture='".$smallpicture_name."' WHERE id='$id'");

			chmod($DOCUMENT_ROOT."/media/pictures/".$id."/".$smallpicture_name, 0755);
		}

		if ($delpicsmall == 1 && $smallpicture_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/pictures/".$id."/".$old_smallpicture);
			@mysql_query("UPDATE ".$table['pictures']." SET smallpicture='' WHERE id='$id'");
		}

		//////////////////////////////////////

		exit(header("Location: redirect.php?module=".$module));

	}

		if (isset($id))
		{
			//выборка существующей записи для редактирования
			$result = @mysql_query("SELECT * FROM ".$table['pictures']." WHERE id='$id'");
			$sql_now = @mysql_fetch_array($result);

			$sql_now_date = getdate(strtotime($sql_now['adddate']));
		}


?>

		<FORM method="POST" action="<?=$PHP_SELF."?module=".$module?>" ENCTYPE="multipart/form-data">

		<INPUT type="hidden" name="submit_flag" value="true">
		<INPUT type="hidden" name="action" value="<?=$action?>">

		<INPUT type="hidden" name="id" value="<?=$sql_now['id']?>">

		<INPUT name="old_picture" value="<?=$sql_now['picture']?>" type="hidden">
		<INPUT name="old_picture2" value="<?=$sql_now['picture2']?>" type="hidden">
		<INPUT name="old_smallpicture" value="<?=$sql_now['smallpicture']?>" type="hidden">

		<TABLE cellpadding="5" cellspacing="0" border="0" width="100%">
		<TR>

			<TD valign="top" nowrap>Подпись или alt-текст:</TD>
			<TD width="100%"><INPUT type="text" name="announce" maxlength="255" size="75" value="<?=htmlspecialchars(stripslashes($sql_now['announce']))?>"></TD>

		</TR>
		<TR>
			<TD nowrap>Ссылка (если есть):</TD>
			<TD width="100%"><INPUT type="text" name="engname" maxlength="255" size="75" value="<?=htmlspecialchars(stripslashes($sql_now['engname']))?>"></TD>
		</TR>
		<!--TR>

			<TD valign="top">Должность (Англ.):</TD>
			<TD width="100%"><INPUT type="text" name="engannounce" maxlength="255" size="55" value="<?=htmlspecialchars(stripslashes($sql_now['engannounce']))?>"></TD>

		</TR>
		<TR>

			<TD valign="top">Биография:</TD>
			<TD>
<?
$oFCKeditor = new FCKeditor('text') ;
$oFCKeditor->BasePath	= "/admin/fckeditor/" ;
$oFCKeditor->Value		= $sql_now['text'] ;
$oFCKeditor->Width  = '100%' ;
$oFCKeditor->Height = '400' ;
$oFCKeditor->Create() ;
?>
			</TD>

		</TR>
		<TR>

			<TD valign="top">Биография (Англ.):</TD>
			<TD>
<?
$oFCKeditor = new FCKeditor('engtext') ;
$oFCKeditor->BasePath	= "/admin/fckeditor/" ;
$oFCKeditor->Value		= $sql_now['engtext'] ;
$oFCKeditor->Width  = '100%' ;
$oFCKeditor->Height = '400' ;
$oFCKeditor->Create() ;
?>
			</TD>

		</TR-->
		<TR>
			<TD nowrap>Баннер:</TD>
			<TD width=100% valign="top"><INPUT type="file" name="smallpicture" size="65">
	
<?
			if (is_file($DOCUMENT_ROOT."/media/pictures/".$id."/".$sql_now['smallpicture']))
			{
				echo "<BR>сейчас загружено: <A href=\"/media/pictures/".$id."/".$sql_now['smallpicture']."\" target=_blank><B>".$sql_now['smallpicture']."</B></A>";
				echo "<BR><INPUT type=checkbox value=1 name=delpicsmall id=dpicsmall> <LABEL for=dpicsmall>Удалить</LABEL><BR><BR>";
			}
	
?>
	
			</TD>
		</TR>
<!--
		<TR>
			<TD nowrap>Фотография №1:</TD>
			<TD width=100% valign="top"><INPUT type="file" name="picture" size="45">
	
<?
			if (is_file($DOCUMENT_ROOT."/media/pictures/".$id."/".$sql_now['picture']))
			{
				echo "<BR>сейчас загружено: <A href=\"/media/pictures/".$id."/".$sql_now['picture']."\" target=_blank><B>".$sql_now['picture']."</B></A>";
				echo "<BR><INPUT type=checkbox value=1 name=delpic id=dpic> <LABEL for=dpic>Удалить</LABEL><BR><BR>";
			}
	
?>
	
			</TD>
		</TR>
		<TR>
			<TD nowrap>Фотография №2:</TD>
			<TD width=100% valign="top"><INPUT type="file" name="picture2" size="45">
	
<?
			if (is_file($DOCUMENT_ROOT."/media/pictures/".$id."/".$sql_now['picture2']))
			{
				echo "<BR>сейчас загружено: <A href=\"/media/pictures/".$id."/".$sql_now['picture2']."\" target=_blank><B>".$sql_now['picture2']."</B></A>";
				echo "<BR><INPUT type=checkbox value=1 name=delpic1 id=dpic1> <LABEL for=dpic1>Удалить</LABEL><BR><BR>";
			}
	
?>
	
			</TD>
		</TR>
-->
		<!--TR>
			<TD nowrap>Позиция:</TD>
			<TD><INPUT type="text" name="position" maxlength="5" size="5" value="<?=htmlspecialchars(stripslashes($sql_now['position']))?>"></TD>
		</TR-->
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
		
		@mysql_query("DELETE FROM ".$table['pictures']." WHERE id='$del'");
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
	<TD width="100%"><B>Баннер</B></TD>
	<!--TD><B>Опубликован</B></TD-->
	<!--TD><B>Позиция</B></TD-->
	<TD><B>Редактировать</B></TD>
	<!--TD><B>Удалить</B></TD-->
	</TR>

<?
	$i=0;

	$result = @mysql_query("SELECT * FROM ".$table['pictures']." ORDER BY position, name, id DESC");
	while ($sql = @mysql_fetch_array($result))
	{
		echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";

		echo "\t<TD>".$sql['name']."</TD>\r\n";
//		echo "\t<TD>".(($sql['publish'] == 1)?"Да":"Нет")."</TD>\r\n";
//		echo "\t<TD>".$sql['position']."</TD>\r\n";
		echo "\t<TD><A href=\"./?module=".$module."&action=create&id=".$sql['id']."\">Редактировать</A></TD>\r\n";
//		echo "\t<TD><A href=\"javascript:del('".$sql['id']."');\">Удалить</A></TD>\r\n";

		echo "\t</TR>\r\n\r\n";

		$i++;

	}


?>
	
	</TABLE>


<?


}


?>

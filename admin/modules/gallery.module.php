<?


if ($action == "create")
{

	if (isset($save))
	{

		if ($id == "")
		{
			//новая запись
			mysql_query("INSERT INTO ".$table['gallery']." VALUES ('', '', '$name', '', '', '$position', '', '0', '', '')");
		}
		else
		{
			// изменение существующей
			@mysql_query("UPDATE ".$table['gallery']." SET name='$name', position='$position' WHERE id='$id'");
		}

		exit(header("Location: redirect.php?module=".$module));

	}

	if (isset($id))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$id'");

		$sql_now = @mysql_fetch_array($result);

	}

?>



<FORM method="POST" action="<?=$PHP_SELF."?module=".$module."&action=create"?>">

<INPUT type="hidden" name="submit_flag" value="true">

<INPUT name="id" value="<?=$sql_now['id']?>" type="hidden">
<INPUT name="section" type="hidden" value="0">

<TABLE cellpadding="5" cellspacing="0" border="0" width="100%">
<TR>
	<TD nowrap>Раздел:</TD>
	<TD width="100%"><INPUT size="50" type="text" name="name" value="<?=htmlspecialchars($sql_now['name'])?>"></TD>
</TR>
<TR>
	<TD nowrap>Позиция в каталоге:</TD>
	<TD><INPUT type="text" name="position" value="<?=$sql_now['position']?>"></TD>
</TR>
<TR>
	<TD>&nbsp;</TD>
	<TD><INPUT type="submit" value="Сохранить" name="save" class="button"></TD>
</TR>
</TABLE>

</FORM>





<?

}

elseif ($action == "createsub")
{

	if (isset($save))
	{

		if ($id == "")
		{
			//новая запись
//			mysql_query("INSERT INTO ".$table['gallery']." VALUES ('', '$logo', '$name', '$description', '$link', '$position', '$announce', '$section', '$size', '$additional')");

			@mysql_query("INSERT INTO ".$table['gallery']." (id, section) VALUES ('', '$section')");
			$lastid = @mysql_fetch_array(@mysql_query("SELECT LAST_INSERT_ID() as id FROM ".$table['gallery']));
			$id = $lastid['id'];
		}

		/////////////

		if (is_uploaded_file($logo))
		{

			if (!file_exists($DOCUMENT_ROOT."/media/gallery/$id/"))
			{
				mkdir($DOCUMENT_ROOT."/media/gallery/$id");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo1) && $old_logo1 != "")
			{
				unlink($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo1);
			}


			$upimage =  getimagesize($logo);

			//gif, jpg, 81x81
			if (($upimage[2] == 2 || $upimage[2] == 1))
			{
				move_uploaded_file($logo,$DOCUMENT_ROOT."/media/gallery/$id/".$logo_name);
			}
		}

		if ($delpic1 == 1 && $logo_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo1);
		}


		// изменение существующей
		@mysql_query("UPDATE ".$table['gallery']." SET name='$name', position='$position', engname='$engname', description='$description', link='$link', size='$size', announce='$announce', additional='$additional' WHERE id='$id'");
		if ($logo_name != "") @mysql_query("UPDATE ".$table['gallery']." SET logo='$logo_name' WHERE id='$id'");

		exit(header("Location: redirect.php?module=".$module));

	}

	if (isset($id))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$id'");

		$sql_now = @mysql_fetch_array($result);

	}

	if (isset($section))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$section'");

		$sid = @mysql_fetch_array($result);

	}

?>



<FORM method="POST" action="<?=$PHP_SELF."?module=".$module."&action=createsub"?>" ENCTYPE="multipart/form-data">

<INPUT type="hidden" name="submit_flag" value="true">

<INPUT name="old_logo1" value="<?=$sql_now['logo']?>" type="hidden">
<INPUT name="id" value="<?=$sql_now['id']?>" type="hidden">
<INPUT name="section" value="<?=$section?>" type="hidden">

<TABLE cellpadding="5" cellspacing="0" border="0" width="100%">
<TR>
	<TD nowrap>Галерея:</TD>
	<TD width="100%"><INPUT size="75" type="text" name="name" value="<?=htmlspecialchars($sql_now['name'])?>"></TD>
</TR>

<?

/*

?>

<TR>
	<TD nowrap>Альбом (Англ.):</TD>
	<TD width="100%"><INPUT size="50" type="text" name="engname" value="<?=htmlspecialchars($sql_now['engname'])?>"></TD>
</TR>
<TR>
	<TD valign="top">Адрес:</TD>
	<TD><TEXTAREA cols="70" rows="3" name="announce"><?=htmlspecialchars($sql_now['announce'])?></TEXTAREA></TD>
</TR>
<TR>
	<TD valign="top">Описание:</TD>
	<TD><TEXTAREA cols="70" rows="10" name="description"><?=htmlspecialchars($sql_now['description'])?></TEXTAREA></TD>
</TR>
<?

//if (isset($id))
//{

?>

<TR>
	<TD valign="top">Изображение:</TD>
	<TD valign="top"><INPUT type="file" name="logo" size="35">
	
	<?
		if (file_exists($DOCUMENT_ROOT."/media/gallery/$id/".$sql_now['logo']) && $sql_now['logo'] != "")
		{
			echo "<BR>сейчас загружено: <A href=\"/media/gallery/$id/".$sql_now['logo']."\" target=_blank><B>".$sql_now['logo']."</B></A>";
			echo "<BR><INPUT type=checkbox value=1 name=delpic1 id=dpic1> <LABEL for=dpic1>Удалить</LABEL><BR><BR>";
		}
	
	
	?>
	
	</TD>
</TR>

*/

?>

<TR>
	<TD nowrap>Позиция:</TD>
	<TD width="100%"><INPUT size="5" type="text" name="position" value="<?=htmlspecialchars($sql_now['position'])?>"></TD>
</TR>

<?

//}


?>
<TR>
	<TD>&nbsp;</TD>
	<TD><INPUT type="submit" value="Сохранить" name="save" class="button"></TD>
</TR>
</TABLE>

</FORM>



<?

}
elseif ($action == "items")
{

	if (isset($del))
	{
		@mysql_query("DELETE FROM ".$table['gallery']." WHERE id='$del'");
		exit(header("Location: redirect.php?module=".$module));
	}

	if (isset($id))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$id'");

		$sql_now = @mysql_fetch_array($result);

	}

	if (isset($section))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$section'");

		$sid = @mysql_fetch_array($result);

	}

	if (isset($subsection))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$subsection'");

		$subsid = @mysql_fetch_array($result);

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
	<TD colspan="2"><B><?=$sid['name']." - ".$subsid['name']?></B></TD>
	<TD><B>Позиция</B></TD>
	<TD><B>Редактировать</B></TD>
	<TD><B>Удалить</B></TD>
	</TR>

<?
	$i=0;

	$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE section='$subsection' ORDER BY position");
	while ($sql = @mysql_fetch_array($result))
	{

		echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";
			
		if (file_exists($DOCUMENT_ROOT."/media/gallery/".$sql['id']."/sm_".$sql['logo']) && $sql['logo'] != '')
		{
			echo "\t<TD><IMG alt=\"\" align=\"absmiddle\" src=\"/media/gallery/".$sql['id']."/sm_".$sql['logo']."\" border=\"\"></TD>\r\n";
		}
		else
		{
			echo "\t<TD>&nbsp;</TD>\r\n";
		}


		echo "\t<TD width=100%>".$sql['description']."</TD>\r\n";
		echo "\t<TD>".$sql['position']."</TD>\r\n";
		echo "\t<TD><A href=\"./?module=".$module."&action=createitem&section=$section&subsection=$subsection&id=".$sql['id']."\">Редактировать</A></TD>\r\n";
		echo "\t<TD><A href=\"javascript:del('".$sql['id']."');\">Удалить</A></TD>\r\n";

		echo "\t</TR>\r\n\r\n";
	

		$i++;

	}


?>
	
	</TABLE>

<BR>
&nbsp; <B><A href="./?module=<?=$module?>&action=createitem&subsection=<?=$subsection?>&section=<?=$section?>">Добавить фотографию</A></B>

<?


}
elseif ($action == "createitem")
{


	if (isset($save))
	{
		/////////////



		if ($id == "")
		{
			//новая запись
			mysql_query("INSERT INTO ".$table['gallery']." (id, section) VALUES ('', '$subsection')");
			$lastid = @mysql_fetch_array(@mysql_query("SELECT LAST_INSERT_ID() as id FROM ".$table['gallery']));
			$id = $lastid['id'];

		}

		if (is_uploaded_file($logo))
		{

			if (!file_exists($DOCUMENT_ROOT."/media/gallery/$id/"))
			{
				mkdir($DOCUMENT_ROOT."/media/gallery/$id");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo1) && $old_logo1 != "")
			{
				unlink($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo1);
				unlink($DOCUMENT_ROOT."/media/gallery/$id/sm_".$old_logo1);
			}


			move_uploaded_file($logo,$DOCUMENT_ROOT."/media/gallery/$id/".$logo_name);


			//image_resize
			$big_img = ImageCreateFromJPEG ($DOCUMENT_ROOT."/media/gallery/$id/".$logo_name);
			$size = GetImageSize($DOCUMENT_ROOT."/media/gallery/$id/".$logo_name);

			$height=120;
			//$width=120;
			if (!$width) 	$width = floor(($height/$size[1])*$size[0]);
			if (!$height) 	$height = floor(($width/$size[0])*$size[1]);

			$small_img = imagecreatetruecolor($width,$height);
			imagecopyresampled($small_img, $big_img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			ImageJPEG($small_img, $DOCUMENT_ROOT."/media/gallery/$id/sm_".$logo_name, 85);

		}

		if ($delpic1 == 1 && $logo_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo1);
		}

		/////////////

		if (is_uploaded_file($link))
		{

			if (!file_exists($DOCUMENT_ROOT."/media/gallery/$id/"))
			{
				mkdir($DOCUMENT_ROOT."/media/gallery/$id");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo2) && $old_logo2 != "")
			{
				unlink($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo2);
			}


			move_uploaded_file($link,$DOCUMENT_ROOT."/media/gallery/$id/".$link_name);
		}

		if ($delpic2 == 1 && $link_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/gallery/$id/".$old_logo2);
		}

		// изменение существующей
		@mysql_query("UPDATE ".$table['gallery']." SET name='$name', engdescription='$engdescription', description='$description', position='$position' WHERE id='$id'");
		if ($logo_name != "") @mysql_query("UPDATE ".$table['gallery']." SET logo='$logo_name' WHERE id='$id'");
		if ($link_name != "") @mysql_query("UPDATE ".$table['gallery']." SET link='$link_name' WHERE id='$id'");

		exit(header("Location: redirect.php?module=".$module."&action=items&section=$section&subsection=$subsection"));

	}

	if (isset($id))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$id'");

		$sql_now = @mysql_fetch_array($result);

	}

	if (isset($section))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$section'");

		$sid = @mysql_fetch_array($result);

	}

	if (isset($subsection))
	{
		//выборка существующей записи для редактирования

		$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$subsection'");

		$subsid = @mysql_fetch_array($result);

	}


info("Уменьшенное изображение будет создано автоматически"); echo "<BR>";

?>



<FORM method="POST" action="<?=$PHP_SELF."?module=".$module."&action=createitem"?>" ENCTYPE="multipart/form-data">

<INPUT type="hidden" name="submit_flag" value="true">
<INPUT name="old_logo1" value="<?=$sql_now['logo']?>" type="hidden">
<INPUT name="old_logo2" value="<?=$sql_now['link']?>" type="hidden">
<INPUT name="cfolder" value="<?=$subsid['logo']?>" type="hidden">

<INPUT name="id" value="<?=$sql_now['id']?>" type="hidden">
<INPUT name="subsection" value="<?=$subsection?>" type="hidden">
<INPUT name="section" value="<?=$section?>" type="hidden">

<TABLE cellpadding="5" cellspacing="0" border="0">
<TR>
	<TD nowrap><B>Галерея:</B></TD>
	<TD><B><?=$subsid['name']?></B></TD>
</TR>
<!--
<TR>
	<TD>Название:</TD>
	<TD><INPUT size="50" type="text" name="name" value="<?=htmlspecialchars($sql_now['name'])?>"></TD>
</TR>
-->
<TR>
	<TD valign="top">Описание:</TD>
	<TD><INPUT name="description" value="<?=htmlspecialchars($sql_now['description'])?>" style="width:550px;"></TD>
</TR>
<!--
<TR>
	<TD valign="top">Описание (Англ.):</TD>
	<TD><INPUT name="engdescription" value="<?=htmlspecialchars($sql_now['engdescription'])?>" style="width:550px;"></TD>
</TR>
	<TD><INPUT size="50" type="text" name="link" value="<?=htmlspecialchars($sql_now['link'])?>"></TD>
</TR>
<TR>
	<TD>Розница:</TD>
	<TD><INPUT size="50" type="text" name="description" value="<?=htmlspecialchars($sql_now['description'])?>"></TD>
</TR>
<TR>
	<TD>Мелкий опт:</TD>
	<TD><INPUT size="50" type="text" name="announce" value="<?=htmlspecialchars($sql_now['announce'])?>"></TD>
</TR>
<TR>
	<TD>Опт:</TD>
	<TD><INPUT size="50" type="text" name="additional" value="<?=htmlspecialchars($sql_now['additional'])?>"></TD>
</TR>
-->
<?

//if (isset($id))
//{

?>

<TR>
	<TD valign="top">Фотография:</TD>
	<TD valign="top"><INPUT type="file" name="logo" size="50">
	
	<?
		if (file_exists($DOCUMENT_ROOT."/media/gallery/$id/".$sql_now['logo']) && $sql_now['logo'] != "")
		{
			echo "<BR>сейчас загружено: <A href=\"/media/gallery/$id/".$sql_now['logo']."\" target=_blank><B>".$sql_now['logo']."</B></A>";
			echo "<BR><INPUT type=checkbox value=1 name=delpic1 id=dpic1> <LABEL for=dpic1>Удалить</LABEL><BR><BR>";
		}
	
	
	?>
	
	</TD>
</TR>
<TR>
	<TD>Позиция:</TD>
	<TD><INPUT size="5" type="text" name="position" value="<?=htmlspecialchars($sql_now['position'])?>"></TD>
</TR>
<!--
<TR>
	<TD nowrap valign="top">Увеличенное изображение:</TD>
	<TD valign="top"><INPUT type="file" name="link">

	<?
		if (file_exists($DOCUMENT_ROOT."/media/gallery/$id/".$sql_now['link']) && $sql_now['link'] != "")
		{
			echo "<BR>сейчас загружено: <A href=\"/media/gallery/$id/".$sql_now['link']."\" target=_blank><B>".$sql_now['link']."</B></A>";
			echo "<BR><INPUT type=checkbox value=1 name=delpic2 id=dpic2> <LABEL for=dpic2>Удалить</LABEL><BR><BR>";
		}
	
	
	?>
<TR>
-->
<?

//}


?>
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
		@mysql_query("DELETE FROM ".$table['gallery']." WHERE id='$del' || section='$del'");
		exit(header("Location: redirect.php?module=".$module));
	}

?>

	<SCRIPT language="javascript">
	<!--
//	function del(id){
//	if (confirm("Удалить раздел?\nБудут удалены также все коллекции и ковры!")){parent.location='?<?=$QUERY_STRING?>&submit_flag=1&del=' + id;}}

	function del2(id){
	if (confirm("Удалить галерею?\nБудут удалены также все материалы!")){parent.location='?<?=$QUERY_STRING?>&submit_flag=1&del=' + id;}}

	//-->
	</SCRIPT>

	<TABLE width="100%" border="0" cellpadding="3">

<?
	$result = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE section='0' ORDER BY id, position");
	while ($sql = @mysql_fetch_array($result))
	{

		echo "\t<TR bgcolor=e3e3e3>\r\n";
			
		echo "\t<TD colspan=2><B>".$sql['name']."</B></TD>\r\n";
		echo "\t<TD><B>Позиция</B></TD>\r\n";
		echo "\t<TD><B>Редактировать</B></TD>\r\n";
		echo "\t<TD><B>Удалить</B></TD>\r\n";
//		echo "\t<TD nowrap><A href=\"./?module=".$module."&action=createsub&section=".$sql['id']."\"><B>Добавить коллекцию</B></A></TD>\r\n";
//		echo "\t<TD><B>".$sql['position']."</B></TD>\r\n";
//		echo "\t<TD><A href=\"./?module=".$module."&action=create&id=".$sql['id']."\">Редактировать</A></TD>\r\n";
//		echo "\t<TD><A href=\"javascript:del('".$sql['id']."');\">Удалить</A></TD>\r\n";

		echo "\t</TR>\r\n\r\n";
	
		$i=0;
		$result2 = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE section='".$sql['id']."' ORDER BY position, id");
		while ($sql2 = @mysql_fetch_array($result2))
		{

			echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";
			
			echo "\t<TD width=100%><LI>".$sql2['name']."</TD>\r\n";
			echo "\t<TD nowrap align=right><A href=\"./?module=".$module."&action=items&subsection=".$sql2['id']."&section=".$sql['id']."\">Фотографии</A></TD>\r\n";
			echo "\t<TD>".$sql2['position']."</TD>\r\n";
			echo "\t<TD><A href=\"./?module=".$module."&action=createsub&id=".$sql2['id']."&section=".$sql['id']."\">Редактировать</A></TD>\r\n";
			echo "\t<TD><A href=\"javascript:del2('".$sql2['id']."');\">Удалить</A></TD>\r\n";

			echo "\t</TR>\r\n\r\n";

			$i++;

		}
	}


?>
	
	</TABLE>


<?

}

?>
<?

//������ ��������, �����-�������, ������ � ����� ������ ��������� ����������

if ($action == "create")
{


	if (isset($save))
	{
/*
		if (is_uploaded_file($newspic))
		{
			if (!file_exists($DOCUMENT_ROOT."/media/news/".$id."/"))
			{
				mkdir($DOCUMENT_ROOT."/media/news/".$id."/");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/news/".$id."/".$old_newspic) && $old_newspic != "")
			{
				unlink($DOCUMENT_ROOT."/media/news/".$id."/".$old_newspic);
			}

			move_uploaded_file($newspic,$DOCUMENT_ROOT."/media/news/".$id."/".$newspic_name);
		}

		if ($delpic == 1 && $newspic_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/news/".$id."/".$old_newspic);
			@mysql_query("UPDATE ".$table['text']." SET pic='' WHERE id='$id'");
		}

		//////////////////

		if (is_uploaded_file($newspic2))
		{


			if (!file_exists($DOCUMENT_ROOT."/media/news/".$id."/"))
			{
				mkdir($DOCUMENT_ROOT."/media/news/".$id."/");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/news/".$id."/".$old_newspic2) && $old_newspic2 != "")
			{
				unlink($DOCUMENT_ROOT."/media/news/".$id."/".$old_newspic2);
			}

//			$upimage =  getimagesize($newspic2);

			//gif, jpg, 81x81
//			if ($upimage[0] == 81 && $upimage[1] == 81 && ($upimage[2] == 2 || $upimage[2] == 1))
//			{
				move_uploaded_file($newspic2,$DOCUMENT_ROOT."/media/news/".$id."/".$newspic2_name);
//			}
		}

		if ($delpic2 == 1 && $newspic2_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/news/".$id."/".$old_newspic2);
			@mysql_query("UPDATE ".$table['text']." SET author='' WHERE id='$id'");
		}

//		if ($newauthor != "") $author = $newauthor;

	//	if ($publish) $publish = 1; else $publish = 0;

	/*
		//�������� �������� $news � $heading, ���� ��� �������

		if ($type == "news") 
		{
			$author = "";
			$heading = "";
		}
	*/

		//����, ������, �������
		//$H = date("H"); $M = date("M"); $S = date("S");

		$datenow = mktime(date("H"), date("i"), date("s"), $month, $day, $year);
		$heading = htmlspecialchars($heading);

		if ($id == "")
		{
			//����� ������
			@mysql_query("INSERT INTO ".$table['text']." (type, date, author, heading, announce, text, publish) VALUES ('$rubric', '$datenow', '$author', '$heading', '$announce', '$text', '$publish')");
		}
		else
		{
			// ��������� ������������
			@mysql_query("UPDATE ".$table['text']." SET type='$rubric', date='$datenow', heading='$heading', announce='$announce', text='$text', publish='$publish' WHERE id='$id'");

			if ($newspic_name != "") @mysql_query("UPDATE ".$table['text']." SET pic='$newspic_name' WHERE id='$id'");
			if ($newspic2_name != "") @mysql_query("UPDATE ".$table['text']." SET author='$newspic2_name' WHERE id='$id'");
		}

		exit(header("Location: redirect.php?module=".$module."&month=all&year=$year&rubric=$rubric&show=1"));
	}


	if (isset($id))
	{
		//������� ������������ ������ ��� ��������������

		$result = @mysql_query("SELECT * FROM ".$table['text']." WHERE id='$id'");

		$sql_now = @mysql_fetch_array($result);

		$sql_now_date = getdate($sql_now['date']);

		@mysql_free_result($result);


		//�������� ����� ��� ��������������� �������
		//if (!file_exists($DOCUMENT_ROOT."/media/news/".$id)) mkdir($DOCUMENT_ROOT."/media/news/".$id);
	}

?>

<FORM method="POST" action="<?=$PHP_SELF."?module=".$module."&action=create"?>" ENCTYPE="multipart/form-data">

<INPUT type="hidden" name="submit_flag" value="true">

<INPUT name="id" value="<?=$sql_now['id']?>" type="hidden">
<INPUT name="old_newspic" value="<?=$sql_now['pic']?>" type="hidden">
<INPUT name="old_newspic2" value="<?=$sql_now['author']?>" type="hidden">

<?//if (!isset($id)) {info("������� ����������� ����� �������� ������ ����� �������� ���������. ��� ����� ����� �������� ��������� ��������� � ����� �� ��������������."); echo "<BR>";}?>


<TABLE cellpadding="5" cellspacing="0" border="0" width="100%">
<TR>

	<TD>����:</TD>

	<TD width="100%">


<SELECT name="day">

<?

	if ($sql_now_date['mday']) $tmp = $sql_now_date['mday']; else $tmp = date("d");

        for ($i=1; $i<32; $i++)
	{
		echo "<OPTION value='".$i."'";

		if ($i == $tmp) echo " selected";

		echo ">".$i."\r\n";
	}

	unset($tmp);

?>

</SELECT>

<SELECT name="month">

<?

	if ($sql_now_date['mon']) $tmp = $sql_now_date['mon']; else $tmp = date("m");

        for ($i=0; $i<sizeof($months); $i++)
	{
		echo "<OPTION value='".($i+1)."'";

		if ($i == $tmp-1) echo " selected";

		echo ">".$months[$i]."\r\n";
	}

	unset($tmp);

?>

</SELECT>

<SELECT name="year">

<?
	if ($sql_now_date['year']) $tmp = $sql_now_date['year']; else $tmp = date("Y");

        for ($i=2009; $i<=date("Y"); $i++)
	{
		echo "<OPTION value='".$i."'";

		if ($i == $tmp) echo " selected";

		echo ">".$i."\r\n";
	}

	unset($tmp);

?>

</SELECT>


	</TD>

</TR>
<!--
<TR>

	<TD>�����:</TD>

	<TD>

<SELECT name="author" style="width: 182px;">
<OPTION value=''>���

<?

	//������

	$result = @mysql_query("SELECT author FROM ".$table['text']." WHERE type='$module' GROUP BY author ORDER BY author");
	while ($sql = @mysql_fetch_array($result))
	{
		if ($sql['author'])
		{
			echo "<OPTION value='".$sql['author']."'";

			if ($sql_now['author'] == $sql['author']) echo " selected";
			
			echo ">".$sql['author']."\r\n";

		}
	}

	@mysql_free_result($result);

?>

</SELECT>

		&nbsp;&nbsp;&nbsp;����� �����:

		<INPUT type="text" value="" size="23" maxlength="64" name="newauthor">

	</TD>

</TR>
-->
<!--
<TR>

	<TD>�������:</TD>

	<TD>

<SELECT name="rubric">

<?

	//������

	$result = @mysql_query("SELECT * FROM ".$table['text_rubrics']." ORDER BY id");
	while ($sql = @mysql_fetch_array($result))
	{
			echo "<OPTION value='".$sql['id']."'";

			if ($sql_now['type'] == $sql['id']) echo " selected";
			
			echo ">".$sql['title']."\r\n";

	}

	@mysql_free_result($result);

?>

</SELECT>

	</TD>

</TR>
<TR>

	<TD>���������:</TD>

	<TD width="100%">

		<INPUT type="text" size="70" maxlength="255" name="heading" value="<?=$sql_now['heading']?>">

	</TD>

</TR>
-->
<TR>

	<TD>�����������:</TD>

	<TD>

	<SELECT name="publish">

	<OPTION value="1" <?=($sql_now['publish'])?"selected":""?>>��
	<OPTION value="0" <?=(!$sql_now['publish'])?"selected":""?>>���

	</SELECT>

	</TD>

</TR>
<TR>

	<TD valign="top" colspan="2">

<?
$oFCKeditor = new FCKeditor('announce') ;
$oFCKeditor->BasePath	= "/admin/fckeditor/" ;
$oFCKeditor->Value		= $sql_now['announce'] ;
$oFCKeditor->Width  = '100%' ;
$oFCKeditor->Height = '200' ;
$oFCKeditor->Create() ;
?>
		
			</TD>

		</TR>

<TR>

	<TD colspan="2">
	
		<NOBR>
		<B>Enter</B> &#151; ����� �������� / <B>Shift + Enter</B> &#151; ����� ������
		</NOBR>

	</TD>

</TR>
<!--
<TR>

	<TD valign="top" colspan="2">������ �����:<BR>

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
-->
<?

if (isset($id))
{

?>
<!--
<TR>
	<TD nowrap valign="top">��������� �����������:</TD>
	<TD width=100% valign="top"><INPUT type="file" name="newspic2">
	
	<?
	
		if (file_exists($DOCUMENT_ROOT."/media/news/".$id."/".$sql_now['author']) && $sql_now['author'] != "")
		{
			echo "<BR>������ ���������: <A href=\"/media/news/".$id."/".$sql_now['author']."\" target=_blank><B>".$sql_now['author']."</B></A>";
			echo "<BR><INPUT type=checkbox value=1 name=delpic2 id=dpic2> <LABEL for=dpic2>�������</LABEL><BR><BR>";
		}
	
	
	?>
	
	</TD>
</TR>
<TR>
	<TD nowrap valign="top">�����������:</TD>
	<TD width=100% valign="top"><INPUT type="file" name="newspic">
	
	<?
	
		if (file_exists($DOCUMENT_ROOT."/media/news/".$id."/".$sql_now['pic']) && $sql_now['pic'] != "")
		{
			echo "<BR>������ ���������: <A href=\"/media/news/".$id."/".$sql_now['pic']."\" target=_blank><B>".$sql_now['pic']."</B></A>";
			echo "<BR><INPUT type=checkbox value=1 name=delpic id=dpic> <LABEL for=dpic>�������</LABEL><BR><BR>";
		}
	
	
	?>
	
	</TD>
</TR>
-->


<?

}



?>
<TR>

	<TD colspan="2">

		<INPUT type="submit" value="���������" name="save" class="button">
		
<?
		if (isset($id))
		{
		
			echo "&nbsp;&nbsp;<INPUT type=\"button\" value=\"���������\" class=\"button\" onclick=\"if (confirm('����� ��� ���������� ���������?')){history.back(-1);}\">\n\n";

		}
?>
	</TD>

</TR>
</TABLE>


<?

//endif
}
elseif ($action == "rubrics")
{
	if (isset($save))
	{
		foreach ($rubric as $rid => $rtitle)
		{
			@mysql_query("UPDATE ".$table['text_rubrics']." SET title='$rtitle' WHERE id='$rid'");
		}

		exit(header("Location: redirect.php?module=".$module."&action=".$action));
	}

	if (isset($addrubric))
	{
		if ($newrubric != "")
		{
			@mysql_query("INSERT INTO ".$table['text_rubrics']." VALUES ('', '$newrubric')");
		}

		exit(header("Location: redirect.php?module=".$module."&action=".$action));
	}

	//�������� ���������
	if (isset($del))
	{
		@mysql_query("DELETE FROM ".$table['text_rubrics']." WHERE id='$del'");
		exit(header("Location: redirect.php?module=".$module."&action=".$action));
	}


?>


	<SCRIPT language="javascript">
	<!--
	function del(id){
	if (confirm("�������?")){parent.location='?<?=$QUERY_STRING?>&submit_flag=1&del=' + id;}}
	//-->
	</SCRIPT>

	<FORM method="POST" action="<?=$PHP_SELF."?module=".$module."&action=rubrics"?>">

	<INPUT type="hidden" name="submit_flag" value="true">

	<TABLE width="100%" border="0" cellpadding="3">
	<TR bgcolor="#E3E3E3">
	<TD><B>ID</B></TD>
	<TD><B>�������</B></TD>
	<TD><B>�������</B></TD>
	</TR>

<?

	$i=0;

	$result = @mysql_query("SELECT * FROM ".$table['text_rubrics']." ORDER BY id");
	while ($sql = @mysql_fetch_array($result))
	{
			echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";
			
			echo "\t<TD><B>".$sql['id']."</B></TD>\r\n";
			echo "\t<TD width=100%><INPUT type=text name=rubric[".$sql['id']."] value='".$sql['title']."' size=55></TD>\r\n";
			echo "\t<TD><A href=\"javascript:del('".$sql['id']."');\">�������</A></TD>\r\n";

			echo "\t</TR>\r\n\r\n";

			$i++;

	}

	@mysql_free_result($result);

?>
	<TR>
		<TD>&nbsp;</TD>
		<TD colspan="2"><INPUT type="submit" value="���������" name="save" class="button"></TD>
	</TR>

	</TABLE>

	</FORM>

	<BR>


	<FORM method="POST" action="<?=$PHP_SELF."?module=".$module."&action=rubrics"?>">

	<INPUT type="hidden" name="submit_flag" value="true">

	<TABLE width="100%" border="0" cellpadding="3">
	<TR bgcolor="#E3E3E3">
		<TD colspan="2"><B>����� �������</B></TD>
	</TR>
	<TR>
		<TD><INPUT type="text" value="" name="newrubric" size="35"></TD>
		<TD width="100%"><INPUT type="submit" value="��������" name="addrubric" class="button"></TD>
	</TR>
	</TABLE>

	</FORM>


<?

}
else
{

//������ ����������

//�������� ���������
if (isset($del))
{
	@mysql_query("DELETE FROM ".$table['text']." WHERE id='$del'");
	exit(header("Location: redirect.php?module=".$module."&action=".$action."&month=".$month."&year=".$year."&show=".$show));
}

?>

	<SCRIPT language="javascript">
	<!--
	function del(id){
	if (confirm("�������?")){parent.location='?<?=$QUERY_STRING?>&submit_flag=1&del=' + id;}}
	//-->
	</SCRIPT>


	<FORM method="get">

	<INPUT type="hidden" name="module" value="<?=$module?>">
	<INPUT type="hidden" name="action" value="<?=$action?>">

	<?=$sql_menu_now['title']?> ��

	<SELECT name="month">

	<OPTION value="all">��� ������

<?

	for ($i=0; $i<sizeof($months_im); $i++)
	{
		echo "<OPTION value='".($i+1)."'";

		if ($i == $month-1) echo " selected";

		echo ">".$months_im[$i]."\r\n";
	}

	unset($tmp);

?>

	</SELECT>
	
	<SELECT name="year">

<?

        for ($i=2009; $i<=date("Y"); $i++)
	{
		echo "<OPTION value='".$i."'";

		if ($i == $year) echo " selected";

		echo ">".$i."\r\n";
	}

	unset($tmp);

?>
	</SELECT>

	����

<!--	
	�� �������

<SELECT name="rubric">
<OPTION value='0'>��� �������

<?

	//������

	$result = @mysql_query("SELECT * FROM ".$table['text_rubrics']." ORDER BY id");
	while ($sql = @mysql_fetch_array($result))
	{
			echo "<OPTION value='".$sql['id']."'";

			if ($rubric == $sql['id']) echo " selected";
			
			echo ">".$sql['title']."\r\n";

	}

	@mysql_free_result($result);

?>

</SELECT>

-->


	<IMG alt="" align="absmiddle" src="images/1x1.gif" width="20" height="1" border="0">
	
	<INPUT type="submit" value="��������" name="show" class="button">

	</FORM>


<?

	if ($show)
	{

	//������� ����������

	$flag = false;

?>

	<TABLE width="100%" border="0" cellpadding="3">

<?
	if ($rubric) $where_rubric = "type='$rubric' && "; else $where_rubric = "";


	$i=0;

	$result = @mysql_query("SELECT id, type, date, author, heading, announce, publish FROM ".$table['text']." WHERE $where_rubric year(FROM_UNIXTIME(date))='$year' ORDER BY date DESC, id DESC");
	while ($sql = @mysql_fetch_array($result))
	{
		$sql_date = getdate($sql['date']);

		if (($month == "all" || $month == $sql_date['mon']))
		{

			if ($i == 0)
			{

?>

	<TR bgcolor="#E3E3E3">
	<TD><B>����</B></TD>
	<!--TD><B>���������</B></TD>
	<TD><B>�������</B></TD-->
	<TD><B>�������</B></TD>
	<TD><B>������������</B></TD>
	<TD><B>�������������</B></TD>
	<TD><B>�������</B></TD>
	</TR>

<?
			}

			$rubric_name = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['text_rubrics']." WHERE id='".$sql['type']."' LIMIT 1"));

			echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF")." valign=\"top\">\r\n";
			
			echo "\t<TD nowrap>".$sql_date['mday']." ".$months[$sql_date['mon']-1].", ".$sql_date['year']."</TD>\r\n";
//			echo "\t<TD>".(($sql['heading'] == "")?"���":$sql['heading'])."</TD>\r\n";
//			echo "\t<TD>".(($rubric_name['title'] == "")?"<B>����������</B>":$rubric_name['title'])."</TD>\r\n";
			echo "\t<TD>".strip_tags($sql['announce'])."</TD>\r\n";
			echo "\t<TD align=\"center\">".(($sql['publish'] == 1)?"��":"���")."</TD>\r\n";
			echo "\t<TD><A href=\"./?module=".$module."&action=create&id=".$sql['id']."\">�������������</A></TD>\r\n";
			echo "\t<TD><A href=\"javascript:del('".$sql['id']."');\">�������</A></TD>\r\n";

			echo "\t</TR>\r\n\r\n";

			$flag = true;

			$i++;
		}

	}

	if (!$flag) echo "<TR><TD colspan=6><B>���������� �� ��������� ������ ���.</B></TD></TR>\r\n";

	@mysql_free_result($result);

?>

	</TABLE>

<?

	}

//endelse
}

?>
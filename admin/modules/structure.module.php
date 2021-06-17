<?

$id_name="id";
$field_names = array(
   'left' => 'cleft', 
   'right'=> 'cright', 
   'level'=> 'clevel', 
); 

require_once "functions/dbtreedatabase.php"; 
require_once "functions/dbtree.php"; 

$dbh=new CDataBase($dbname, $dbhost, $dbuser, $dbpasswd); 
$Tree = new CDBTree($dbh, $table['structure'], $id_name, $field_names); 


//права пользователя
if ($user['access'])
{


if ($action == "create")
{
	if (isset($save))
	{
		$datavalues = array("title" => trim(htmlspecialchars($title)), "publish" => $publish, "name" => trim(htmlspecialchars($name)), "meta_keywords" => trim(htmlspecialchars($meta_keywords)), "meta_description" => trim(htmlspecialchars($meta_description)), "pagedata1" => stripslashes($pagedata1), "pagedata2" => stripslashes ($pagedata2),  "pagedata_php" => stripslashes($pagedata_php), "submenu" => $submenu);

		if ($addcategory == 1)
		{
			$Tree -> insert($parentid, $datavalues);
		}
		else
		{
			$Tree -> update($id, $datavalues);

			if ($parentid != $parentnow)
				$Tree -> moveAll($id, $parentid);
		}

		if (is_uploaded_file($pagedata3))
		{
			if (!file_exists($DOCUMENT_ROOT."/media/bg/".$id."/"))
			{
				mkdir($DOCUMENT_ROOT."/media/bg/".$id."/");
			}

			elseif (file_exists($DOCUMENT_ROOT."/media/bg/".$id."/".$old_pic) && $old_pic != "")
			{
				unlink($DOCUMENT_ROOT."/media/bg/".$id."/".$old_pic);
			}

			move_uploaded_file($pagedata3,$DOCUMENT_ROOT."/media/bg/".$id."/".$pagedata3_name);
		}

		if ($delpic == 1 && $pagedata3_name == "")
		{
			unlink($DOCUMENT_ROOT."/media/bg/".$id."/".$old_pic);
			@mysql_query("UPDATE ".$table['structure']." SET pagedata3='' WHERE id='$id'");
		}

		if ($pagedata3_name != "") @mysql_query("UPDATE ".$table['structure']." SET pagedata3='$pagedata3_name' WHERE id='$id'");


		exit(header("Location: redirect.php?module=".$module));

	}

	if (isset($id) && $addcategory != 1)
	{
		$result = @mysql_query("SELECT * FROM ".$table['structure']." WHERE id='$id'");
		$sql_now = @mysql_fetch_array($result);
	}
	elseif (isset($id) && $addcategory == 1)
	{
		$result = @mysql_query("SELECT id, cleft, cright, clevel FROM ".$table['structure']." WHERE id='$id'");
		$sql_now = @mysql_fetch_array($result);
	}


	if (isset($id) && $addcategory != 1)
	{
		$result = @mysql_query("SELECT * FROM ".$table['structure']." WHERE id='$id'");
		$sql_now = @mysql_fetch_array($result);
	}
	elseif (isset($id) && $addcategory == 1)
	{
		$result = @mysql_query("SELECT id, cleft, cright, clevel FROM ".$table['structure']." WHERE id='$id'");
		$sql_now = @mysql_fetch_array($result);
	}

	if (!file_exists($DOCUMENT_ROOT."/media/structure/".$id)) mkdir($DOCUMENT_ROOT."/media/structure/".$id);


?>

<?if ($addcategory) {info("Вставка изображений будет доступна только после создания страницы. Для этого после создания страницы перейдите в режим ее редактирования."); echo "<BR>";}?>

		<FORM method="POST" action="<?=$PHP_SELF?>" ENCTYPE="multipart/form-data">

		<INPUT type="hidden" name="submit_flag" value="true">
		<INPUT type="hidden" name="module" value="<?=$module?>">
		<INPUT type="hidden" name="action" value="<?=$action?>">
		<INPUT type="hidden" name="addcategory" value="<?=$addcategory?>">
		<INPUT name="id" value="<?=$sql_now['id']?>" type="hidden">
		<INPUT name="old_pic" value="<?=$sql_now['pagedata3']?>" type="hidden">

		<TABLE cellpadding="5" cellspacing="0" border="0" width="100%">
		<TR>
			<TD nowrap>Название страницы:</TD>
			<TD width="100%"><INPUT type="text" name="title" size="55" value="<?=$sql_now['title']?>"></TD>
		</TR>
		<?
		
		if ($id != 1 || $addcategory == 1)
		{

		?>

		<TR>
			<TD nowrap>Английский синоним:</TD>
			<TD width="100%"><INPUT type="text" name="name" size="55" value="<?=$sql_now['name']?>"></TD>
		</TR>
		<TR>
			<TD>Родитель:</TD>
			<TD>
			<SELECT name="parentid" style="width:350px;">

<?
		$parentnow = 0;

		$query="SELECT * FROM ".$table['structure']." ORDER BY cleft ASC"; 
		$result=$dbh->query($query); 
		while($row = $dbh->fetch_array($result)) 
		{
			if ($addcategory != 1)
			{
				echo "\t<OPTION value='".$row['id']."' ".(($row['clevel'] == ($sql_now['clevel']-1) && ($sql_now['cleft'] >= $row['cleft'] && $sql_now['right'] <= $row['cright']))?" selected":"").">".str_repeat("&#151;",2*$row['clevel'])."&raquo; ".$row['title']."</OPTION>\r\n";
				if ($row['clevel'] == ($sql_now['clevel']-1) && ($sql_now['cleft'] >= $row['cleft'] && $sql_now['right'] <= $row['cright'])) $parentnow = $row['id'];
			}
			else
			{
				echo "\t<OPTION value='".$row['id']."' ".(($row['clevel'] == ($sql_now['clevel']) && ($sql_now['cleft'] >= $row['cleft'] && $sql_now['right'] <= $row['cright']))?" selected":"").">".str_repeat("&#151;",2*$row['clevel'])."&raquo; ".$row['title']."</OPTION>\r\n";
			}
		}

?>
			</SELECT>

<?

		if ($parentnow)
		{
?>
			<INPUT type="hidden" name="parentnow" value="<?=$parentnow?>">

<?
		}

?>

			</TD>
		</TR>
		<TR>
			<TD nowrap>Ссылка на другую страницу:</TD>
			<TD width="100%"><INPUT type="text" name="pagedata2" size="55" value="<?=$sql_now['pagedata2']?>"></TD>
		</TR>
		<!--TR>
			<TD nowrap>Тип страницы:</TD>
			<TD>

			<SELECT name="pagedata2">
			<OPTION value='txt'<?=(($sql_now['pagedata2']=='txt')?" selected":"")?>>Текстовая
			<OPTION value='gallery'<?=(($sql_now['pagedata2']=='gallery')?" selected":"")?>>Галерея

			</SELECT>

			</TD>
		</TR-->
		<TR>
			<TD nowrap>Показывать в навигации:</TD>
			<TD>

			<SELECT name="publish">
			<OPTION value='1'<?=(($sql_now['publish'])?" selected":"")?>>Да
			<OPTION value='0'<?=((!$sql_now['publish'])?" selected":"")?>>Нет

			</SELECT>

			</TD>
		</TR>
<?
		}
		else
		{
		?>
		
			<INPUT type="hidden" name="name" value="/">
			<INPUT type="hidden" name="publish" value="1">
		
		
		<?
		}

		?>

		<TR>
			<TD nowrap valign="top">Описание страницы:<BR><I>(Если данные не заполнены, то для<BR>страницы будет использоваться<BR>описание главной страницы)</I></TD>
			<TD width="100%"><TEXTAREA name="meta_description" cols="55" rows="5"><?=$sql_now['meta_description']?></TEXTAREA></TD>
		</TR>
		<TR>
			<TD nowrap valign="top">Поисковые слова:<BR><I>(Если данные не заполнены, то для<BR>страницы будут использоваться<BR>ключевые слова главной страницы)</I></TD>
			<TD width="100%"><TEXTAREA name="meta_keywords" cols="55" rows="5"><?=$sql_now['meta_keywords']?></TEXTAREA></TD>
		</TR>

<?

if ($sql_now['clevel'] == 1)
{


?>

		<TR>
			<TD nowrap valign="top">Изображение страницы:</TD>
			<TD width=100% valign="top"><INPUT type="file" name="pagedata3" size="45">
	
	<?
	
		if (file_exists($DOCUMENT_ROOT."/media/bg/".$id."/".$sql_now['pagedata3']) && $sql_now['pagedata3'] != "")
		{
			echo "<BR>сейчас загружено: <A href=\"/media/bg/".$id."/".$sql_now['pagedata3']."\" target=_blank><B>".$sql_now['pagedata3']."</B></A>";
			echo "<BR><INPUT type=checkbox value=1 name=delpic id=dpic> <LABEL for=dpic>Удалить</LABEL><BR><BR>";
		}
	
	
	?>
	
			</TD>
		</TR>
<?

}

?>

		<TR>
			<TD colspan="2">

<?
$oFCKeditor = new FCKeditor('pagedata1') ;
$oFCKeditor->BasePath	= "/admin/fckeditor/" ;
$oFCKeditor->Value		= $sql_now['pagedata1'] ;
$oFCKeditor->Width  = '100%' ;
$oFCKeditor->Height = '400' ;
$oFCKeditor->Create() ;
?>
		
			</TD>

		</TR>
		<TR>
			<TD colspan="2">Блок содержания №2 (PHP):</TD>
		</TR>
		<TR>
			<TD colspan="2"><TEXTAREA name="pagedata_php" cols="55" rows="5" style="width:100%;"><?=$sql_now['pagedata_php']?></TEXTAREA></TD>
		</TR>
<!--
		<TR>
			<TD colspan="2">Блок содержания №3 (HTML или PHP):</TD>
		</TR>
		<TR>
			<TD colspan="2"><TEXTAREA name="pagedata3" cols="55" rows="15" style="width:100%;"><?=$sql_now['pagedata3']?></TEXTAREA></TD>
		</TR>
		-->
<?

if (!$addcategory)
{

?>


<TR>
	<TD><B>Медиаматериалы:</B></TD>
	<TD><B><A href="/admin/photomanager.php?type=structure&id=<?=$id?>" target="_blank">Добавить/Редактировать медиаматериалы</A></B></TD>
</TR>



<?

}


?>
		<TR>
			<TD colspan="2"><INPUT type="submit" value="Сохранить" name="save" class="button"></TD>
		</TR>
		</TABLE>

		</FORM>


<?

}
elseif ($action == "access" && $user['access'])
{

	if (isset($save))
	{
		@mysql_query("UPDATE ".$table['structure']." SET access='".addslashes(serialize($ch_users))."' WHERE id='".$id."'");
		exit(header("Location: redirect.php?module=".$module."&action=create&id=".$id));
	}

	$page_now = @mysql_fetch_array(@mysql_query("SELECT access, title FROM ".$table['structure']." WHERE id='".$id."'"));

	$sql_access = unserialize($page_now['access']);


?>
	Страница <B>&laquo;<?=$page_now['title']?>&raquo;</B> доступна для редактирования следующим пользователям (кроме администраторов):<BR>

	<FORM method="POST" action="<?=$PHP_SELF?>">

	<INPUT type="hidden" name="submit_flag" value="true">
	<INPUT type="hidden" name="module" value="<?=$module?>">
	<INPUT type="hidden" name="action" value="<?=$action?>">
	<INPUT name="id" value="<?=$id?>" type="hidden">

	<?
	
	echo "\t<TABLE width=\"30%\" border=\"0\" cellpadding=\"3\">\r\n";
	echo "\t<TR bgcolor=#E3E3E3>\r\n";
	echo "\t<TD><B>Пользователи</B></TD>\r\n";
	echo "\t</TR>\r\n";

	$i=0;

	$users_result = @mysql_query("SELECT * FROM ".$table['users']." WHERE access='0' ORDER BY `name`");

	while ($sql_users = @mysql_fetch_array($users_result))
	{
		echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";
		echo "\t<TD><INPUT type=\"checkbox\" name=\"ch_users[".$sql_users['id']."]\" value=\"1\" id=\"".$sql_users['login']."\"".(($sql_access[$sql_users['id']])?" checked":"").">\r\n";
		echo "\t<LABEL for=\"".$sql_users['login']."\">".$sql_users['name']." (".$sql_users['login'].")</LABEL>\r\n</TD>";
		echo "\t</TR>\r\n";

		$i++;
	}

	echo "<TR>";
	echo "<TD colspan=\"2\"><INPUT type=\"submit\" value=\"Сохранить\" name=\"save\" class=\"button\"></TD>";
	echo "</TR>";
	echo "\t</TABLE>\r\n";
	
	
	?>

	</FORM>

<?

}
else
{

		if (isset($movetree))
		{

			$childrens = $Tree -> enumChildren($id, $start_level=1, $end_level=1);
			$sosedchildrens = $Tree -> enumChildren($sosedid, $start_level=1, $end_level=1);

			if ($movetree == "down")
			{
				$sql_now = @mysql_fetch_array(@mysql_query("SELECT id, cleft, cright, clevel FROM ".$table['structure']." WHERE id='$id'"));
				$sql_down = @mysql_fetch_array(@mysql_query("SELECT id, cleft, cright, clevel FROM ".$table['structure']." WHERE cleft='".($sql_now['cright']+1)."'"));

				@mysql_query("UPDATE ".$table['structure']." SET cleft=".$sql_down['cleft'].", cright=".$sql_down['cright']." WHERE id='".$sql_now['id']."'");
				@mysql_query("UPDATE ".$table['structure']." SET cleft=".$sql_now['cleft'].", cright=".$sql_now['cright']." WHERE id='".$sql_down['id']."'");
	
			}

			if ($movetree == "up")
			{
				$sql_now = @mysql_fetch_array(@mysql_query("SELECT id, cleft, cright, clevel FROM ".$table['structure']." WHERE id='$id'"));
				$sql_up = @mysql_fetch_array(@mysql_query("SELECT id, cleft, cright, clevel FROM ".$table['structure']." WHERE cright='".($sql_now['cleft']-1)."'"));

				@mysql_query("UPDATE ".$table['structure']." SET cleft=".$sql_up['cleft'].", cright=".$sql_up['cright']." WHERE id='".$sql_now['id']."'");
				@mysql_query("UPDATE ".$table['structure']." SET cleft=".$sql_now['cleft'].", cright=".$sql_now['cright']." WHERE id='".$sql_up['id']."'");
	
			}

			//move all childrens of parent

			if (@mysql_num_rows($childrens) > 0)
			{

				while($movechildren = @mysql_fetch_array($childrens))
				{
					$Tree -> moveAll($movechildren['id'], $id);
				}
				
			}

			if (@mysql_num_rows($sosedchildrens) > 0)
			{

				while($movechildren = @mysql_fetch_array($sosedchildrens))
				{
					$Tree -> moveAll($movechildren['id'], $sosedid);
				}
				
			}

			exit(header("Location: ?module=".$module."&action=".$action));
			
		}

		if (isset($del))
		{
			$Tree -> deleteAll($del);
			exit(header("Location: redirect.php?module=".$module."&action=".$action));
		}


?>

	<SCRIPT language="javascript">
	<!--
	function del(id){
	if (confirm("Вы действительно хотите удалить раздел со всеми подразделами?")){parent.location='?<?=$QUERY_STRING?>&submit_flag=1&del=' + id;}}
	//-->
	</SCRIPT>

<TABLE width="100%" border="0" cellpadding="3">
<TR bgcolor=#E3E3E3>
	<TD><B>Заголовок</B></TD>
	<TD nowrap><B>Добавить подраздел</B></TD>
	<TD><B>Опубликована</B></TD>
	<TD><B>Удалить</B></TD>
	<TD><B>Перемещение</B></TD>
</TR>


<?

$i=0;

$query="SELECT * FROM ".$table['structure']." ORDER BY cleft ASC"; 

$result=$dbh->query($query); 
while($row = $dbh->fetch_array($result)) 
{
	$i++;

	$is_down = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['structure']." WHERE cleft='".($row['cright']+1)."'"));
	$is_up = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['structure']." WHERE cright='".($row['cleft']-1)."'"));

	echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";

	if (!$row['clevel'])
	{
		echo "\t\t<TD><LI><A href=\"./?module=".$module."&action=create&id=".$row['id']."\">".$row['title']." [".$row['name']."]</A></LI></TD>\r\n";
		echo "\t\t<TD><A href=\"./?module=".$module."&action=create&id=".$row['id']."&addcategory=1\">Добавить подраздел</A></TD>\r\n";
		echo "\t\t<TD>&nbsp;</TD>\r\n";
		echo "\t\t<TD>&nbsp;</TD>\r\n";
		echo "\t\t<TD>&nbsp;</TD>\r\n";
	}
	else
	{
		echo "\t\t<TD width=\"100%\" style='padding-left:".(20*($row['clevel']))."'><LI><A href=\"./?module=".$module."&action=create&id=".$row['id']."\">".$row['title']." [".$row['name']."]</A></LI></TD>\r\n";
		echo "\t\t<TD nowrap><A href=\"./?module=".$module."&action=create&id=".$row['id']."&addcategory=1\">Добавить подраздел</A></TD>\r\n";
		echo "\t\t<TD>".(($row['publish'])?"Да":"Нет")."</TD>\r\n";
		echo "\t\t<TD><A href=\"javascript:del('".$row['id']."');\">Удалить</A></TD>\r\n";
		echo "\t\t<TD nowrap>";

		if ($is_up['id'] != "") echo "<A href=\"./?module=".$module."&action=".$action."&id=".$row['id']."&sosedid=".$is_up['id']."&movetree=up&submit_flag=1\">Вверх</A> &nbsp;  &nbsp;";
		else echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";

		if ($is_down['id'] != "") echo "<A href=\"./?module=".$module."&action=".$action."&id=".$row['id']."&sosedid=".$is_down['id']."&movetree=down&submit_flag=1\">Вниз</A>";

//		echo " [".$row['cleft']."-".$row['cright']."]";

		echo "</TD>\r\n";
	}

	echo "\t\t</TR>\r\n";
}

?> 


</TABLE>

<?

}



}
//права пользователя
else
{

	if ($action == "editpage")
	{

		if (isset($save))
		{
			@mysql_query("UPDATE ".$table['structure']." SET pagedata1='$pagedata1', pagedata2='$pagedata2', pagedata3='$pagedata3', pagedata_php='$pagedata_php', meta_keywords='$meta_keywords', meta_description='$meta_description' WHERE id='$id'");
			exit(header("Location: redirect.php?module=".$module));
		}


		$sql_now = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['structure']." WHERE id='".$id."'"));

		$sql_access = unserialize($sql_now['access']);

		if ($sql_access[$user['id']])
		{

?>

		<FORM method="POST" action="<?=$PHP_SELF?>">

		<INPUT type="hidden" name="submit_flag" value="true">
		<INPUT type="hidden" name="module" value="<?=$module?>">
		<INPUT type="hidden" name="action" value="<?=$action?>">
		<INPUT name="id" value="<?=$sql_now['id']?>" type="hidden">

		<TABLE cellpadding="5" cellspacing="0" border="0" width="100%">
		<TR>
			<TD nowrap valign="top">Описание страницы:<BR><I>(Если данные не заполнены, то для<BR>страницы будет использоваться<BR>описание главной страницы)</I></TD>
			<TD width="100%"><TEXTAREA name="meta_description" cols="55" rows="5"><?=$sql_now['meta_description']?></TEXTAREA></TD>
		</TR>
		<TR>
			<TD nowrap valign="top">Поисковые слова:<BR><I>(Если данные не заполнены, то для<BR>страницы будут использоваться<BR>ключевые слова главной страницы)</I></TD>
			<TD width="100%"><TEXTAREA name="meta_keywords" cols="55" rows="5"><?=$sql_now['meta_keywords']?></TEXTAREA></TD>
		</TR>
		<TR>
			<TD colspan="2">Блок содержания №1:</TD>
		</TR>
		<TR>
			<TD colspan="2">

<?
$oFCKeditor = new FCKeditor('pagedata1') ;
$oFCKeditor->BasePath	= "/admin/fckeditor/" ;
$oFCKeditor->Value		= $sql_now['pagedata1'] ;
$oFCKeditor->Width  = '100%' ;
$oFCKeditor->Height = '400' ;
$oFCKeditor->Create() ;
?>
			</TD>
		</TR>
		<TR>
			<TD colspan="2">Блок содержания №2 (HTML или PHP):</TD>
		</TR>
		<TR>
			<TD colspan="2"><TEXTAREA name="pagedata2" cols="55" rows="15" style="width:100%;"><?=$sql_now['pagedata2']?></TEXTAREA></TD>
		</TR>
		<!--
		<TR>
			<TD colspan="2">Блок содержания №3 (HTML или PHP):</TD>
		</TR>
		<TR>
			<TD colspan="2"><TEXTAREA name="pagedata3" cols="55" rows="15" style="width:100%;"><?=$sql_now['pagedata3']?></TEXTAREA></TD>
		</TR>
		-->
		<TR>
			<TD colspan="2"><INPUT type="submit" value="Сохранить" name="save" class="button"></TD>
		</TR>
		</TABLE>

		</FORM>

<?

		}
		else
		{
			echo "Доступ запрещен";
		}

	
	}
	else
	{



?>

		<TABLE width="100%" border="0" cellpadding="3">
		<TR bgcolor=#E3E3E3>
			<TD><B>Страницы</B></TD>
		</TR>


<?

		$i=0;

		$query="SELECT * FROM ".$table['structure']." WHERE access!='' ORDER BY cleft ASC";

		$result=$dbh->query($query); 
		while($row = $dbh->fetch_array($result))
		{
			$i++;

			$sql_access = unserialize($row['access']);

			if ($sql_access[$user['id']])
			{
				echo "\t<TR bgcolor=".(($i%2)?"#F5F5F5":"#FFFFFF").">\r\n";
				echo "\t\t<TD width=\"100%\"><LI><A href=\"?module=".$module."&action=editpage&id=".$row['id']."\">".$row['title']." [".$row['name']."]</LI></TD>\r\n";
				echo "\t\t</TR>\r\n";
			}
		}
//проверять доступность страницы на редактирование пользователем при редактировании и сохранении
//

?> 


		</TABLE>

<?

	}


}

?>
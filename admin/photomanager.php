<?

session_start();

//загрузка модуля

include("init.php");
include("classes/auth.php");
include("functions/functions.php");

$auth = new User;

if (!$auth -> Auth()) exit(header("Location: login.php"));
else
{


$shortpath = "/media/".$type."/".$id."/";
$path = $DOCUMENT_ROOT.$shortpath;

if (!is_dir($DOCUMENT_ROOT.$shortpath)) mkdir($DOCUMENT_ROOT.$shortpath);



if (isset($del))
{
	$del = str_replace("%20", " ", $del);	
	unlink($path.$del);

	header("Location: photomanager.php?type=$type&id=$id");
}

if (isset($newfile))
{
	rename($path.$oldfile, $path.$newfile);
	header("Location: photomanager.php?type=$type&id=$id");
}

if ($upload)
{
	for ($i=0;$i<4;$i++)
	{
//		chdir($path);
		if (is_uploaded_file($up[$i])) {move_uploaded_file($up[$i],$path.$up_name[$i]);}
	}

	header("Location: photomanager.php?type=$type&id=$id");
}


function pagebar1()
{

	global $numpages, $page;

	for ($i=0; $i<$numpages; $i++)
	{
		if ($i != $page) echo "<A href=?page=".$i.">[".($i+1)."]</A>";
		else echo "[".($i+1)."]";

		echo "&nbsp;\n";
	}

}

?>

<html>
<head>
<title>ak.photomanager</title>
<STYLE>
body, td, select, input{font-family: verdana; font-size:11px;}
.w	{color:#ffffff;}
.bw	{color:#ffffff; font-weight:bold;}
form	{margin:0px;}
.b	{border: #aaaaaa 1px solid;}
</STYLE>
<SCRIPT language="javascript">
<!--

function Del(id){
if (confirm("Удаляем?")){parent.location='?type=<?=$type?>&id=<?=$id?>&del=' + id;}}


function Ren(file){
newfile = prompt("Введите новое имя файла \"" + file + "\"",file);
if (newfile) location.reload("photomanager.php?type=<?=$type?>&id=<?=$id?>&newfile=" + newfile + "&oldfile=" + file);}

//-->
</SCRIPT>
</head>
<body>

<?

$handle = opendir($path);
$path="";

while ($f = readdir($handle))
{
//	if(!is_dir($path.$f) && $f != "index.php" && $f != "photomanager.php") {$fs[]=$f;}
	if(!is_dir($path.$f) && $f != "pic") {$fs[]=$f;}
}
closedir($handle); 

if (sizeof($fs)>0) sort($fs);


//pagebar1
if (!isset($page)) $page=0;

$numpages = ceil(sizeof($fs) / 10);


?>

<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" width="100%" align="center">
<TR><TD>

<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR>
<TD class="bw">Страницы:</TD>
<TD width="100%" bgcolor=#ffffff>
&nbsp;

<?

pagebar1();


?>

</TD>
<TD class="bw"><NOBR>ak.photomanager ver 1.0</NOBR></TD>
</TR>
</TABLE>

</TD></TR>
</TABLE>

<BR>

<FORM action="photomanager.php" method="post" ENCTYPE="multipart/form-data">
<INPUT type="hidden" name="id" value="<?=$id?>">
<INPUT type="hidden" name="type" value="<?=$type?>">
<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" width="100%" align="center">
<TR><TD>

<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR align="center">
<TD class="bw" rowspan="2"><NOBR>Закачать картинки:</NOBR></TD>
<TD bgcolor=#ffffff><INPUT type="file" name="up[0]"></TD>
<TD bgcolor=#ffffff><INPUT type="file" name="up[1]"></TD>
<TD bgcolor=#ffffff rowspan="2"><INPUT type="submit" value="Закачать" name="upload"></TD>
</TR>
<TR align="center">
<TD bgcolor=#ffffff><INPUT type="file" name="up[2]"></TD>
<TD bgcolor=#ffffff><INPUT type="file" name="up[3]"></TD>
</TR>
</TABLE>

</TD></TR>
</TABLE>
</FORM>

<BR>

<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" width="100%" align="center">
<TR><TD>
<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR class="bw" align="center"><TD>Картинка</TD><TD>Код вставки</TD><TD>Действия</TD></TR>

<?

//вывод файлов
//for ($i=0;$i<sizeof($fs);$i++)
for ($i=$page*10; $i<(($page+1)*10); $i++)
{

	if (isset($fs[$i]))
	{

	$fs20 = str_replace(" ","%20",$fs[$i]);	

	echo "<TR bgcolor=#ffffff align=center><td><IMG class=b border=0 src=".$shortpath.$fs20."></td>\n";
	echo "<TD rowspan=2><B>HTML код для вставки изображения:</B><BR>&lt;IMG src=\"".$shortpath.$fs20."\" border=\"0\" alt=\"\" align=\"left\"&gt;<BR><BR><BR><B>Ссылка для вставки в интерактивную область редактирования текста:</B><BR>".$shortpath.$fs20."</TD>\n";
	echo "<TD rowspan=2><A href=\"javascript:Ren('".$fs20."');\">Переименовать</A><BR><BR>\n";
	echo "<A href=\"javascript:Del('".$fs20."');\">Удалить</A></TD></TR>\n";

	echo "<TR bgcolor=#ffffff align=center><TD><B>".$fs[$i]."</B></TD></TR>\n\n";

	}
}	

?>

</TD></TR>
</TABLE>

</TD></TR>
</TABLE>


<BR>

<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" width="100%" align="center">
<TR><TD>

<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR>
<TD class="bw">Страницы:</TD>
<TD width="100%" bgcolor=#ffffff>
&nbsp;

<?

pagebar1();


?>

</TD>
</TR>
</TABLE>

</TD></TR>
</TABLE>


</body>
</html>

<?

}

?>
<?

                	
session_start();

include("../init.php");
include("../classes/auth.php");
include("../functions/functions.php");

$auth = new User;

if (!$auth -> Auth()) exit(header("Location: ../login.php"));
else
{


//начальная директория
$defpath = "/";

if (!is_dir($DOCUMENT_ROOT.$defpath)) $defpath = "/";

$path = $defpath;

parse_str($QUERY_STRING);

include("functions.php");

freepath();

include("dos.php");

if (!is_dir($DOCUMENT_ROOT.$path)) $path = $defpath;

if (is_dir($DOCUMENT_ROOT.$newpath) && $newpath){header("Location: index.php?path=".$newpath);}

?>
<html>
<head>
<title>ak.filemanager</title>
<link href="style.css" type="text/css" rel="stylesheet">
<script>
function t1(obj){obj.style.background='#eeeeee';}
function t2(obj){obj.style.background='#ffffff';}
function t3(obj){obj.style.background='#f7f7f7';}
function ren(file){
newfile = prompt("Введите новое имя файла или папки \"" + file + "\" (без пробелов!)",file);
if (newfile) location.reload("dos.php?newfile=" + newfile + "&action=ren&oldfile=" + file + "&path=<?=$path?>");}
</script>
</head>
<body onload='document.np.newpath.focus();'>

<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" width="100%" align="center">
<TR><TD>
<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR><TD class=bw>&nbsp;URL:&nbsp;</TD><TD width="100%" bgcolor=#ffffff>
&nbsp;<A href=http://<?=$SERVER_NAME.$path?>>http://<?=$SERVER_NAME.$path?></A> | <?=$DOCUMENT_ROOT?>
</TD><TD><NOBR> <A href="todo.txt" class=bw>ak.filemanager</A> </NOBR></TD></TR>
</TD></TR></TABLE>
</TD></TR></TABLE>

<BR>

<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" width="100%" align="center">
<TR><TD>
<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR><TD width="16">&nbsp;</TD><TD class=bw>Имя</TD><TD width="33">&nbsp;</TD><TD class=bw width="20">[x]</TD><TD class=bw width="125">Изменен</TD><TD class=bw width="65">Размер</TD></TR>
<FORM action="dos.php?action=copydel&path=<?=$path?>" method=post>
<?

$handle = opendir($DOCUMENT_ROOT.$path);

while ($f = readdir($handle))
{
	if(is_dir($DOCUMENT_ROOT.$path.$f) && $f != ".") {$dir[]=$f;}
	elseif($f != ".") {$fs[]=$f;}
}
closedir($handle); 

if (sizeof($dir)>0) sort($dir);
if (sizeof($fs)>0) sort($fs);

//вывод директорий
for ($i=0;$i<sizeof($dir);$i++)
{
	$dir20 = str_replace(" ","%20",$dir[$i]);

	if ($path.$dir20 != "/..")
	{

	echo "<tr class=d onmouseover=t1(this) onmouseout=t3(this)><td><img src=i/d.gif></td>";
	echo "<td><A href=./?path=".$path.$dir20."/>";
	echo $dir[$i]."</A></td>";
	
	if ($dir[$i] != "..")
	{
		echo "<TD align=right><A title=Переименовать href=javascript:ren('".$dir[$i]."');><IMG src=i/r.gif border=0></A></TD>";
		echo "<td><INPUT type=checkbox name=deldir[".$i."] value=".$dir[$i]."></td>";
//		echo "<td class=s>".createdate('d','c')."</td><td class=s>".createdate('d','ch')."</td>";
		echo "<td class=s>".createdate('d','ch')."</td>";
	}
//	else echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	else echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	echo "<td height=24>&nbsp;</td></tr>\n";

	}
}

//вывод файлов
for ($i=0;$i<sizeof($fs);$i++)
{
	$fs20 = str_replace(" ","%20",$fs[$i]);	

	$fsize =  filesize($DOCUMENT_ROOT.$path.$fs[$i])/100;
	if ($fsize > 10) $fsize = round($fsize/10);
	else  $fsize = $fsize/10;

	echo "<tr class=f onmouseover=t1(this) onmouseout=t2(this)><td><img src=i/f.gif></td>";
	echo "<td><A href=".$path.$fs20.">";
	echo $fs[$i]."</A></td>";
	
	if (bin())
	{
		echo "<TD><A title=Редактировать href=editfile.php?file=".$fs[$i]."&path=".$path."><IMG src=i/e.gif border=0></A> ";
	}
	else	echo "<TD align=right>";
	
	echo "<A title=Переименовать href=javascript:ren('".$fs[$i]."');><IMG src=i/r.gif border=0></A></TD>";
	echo "<td><INPUT type=checkbox name=delfile[".$i."] value=".$fs[$i]."></td>";
//	echo "<td class=s>".createdate('f','c')."</td><td class=s>".createdate('f','ch')."</td>";
	echo "<td class=s>".createdate('f','ch')."</td>";
	echo "<td>".$fsize." Kb</td></tr>\n";
}

echo "<input type=hidden name=dirsize value=".sizeof($dir).">";
echo "<input type=hidden name=fssize value=".sizeof($fs).">";

?>
</TABLE>
</TD></TR>
</TABLE>

<BR>

<TABLE cellpadding="0" cellspacing="0" width="100%" bgcolor="#aaaaaa"><TR><TD>

<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR>
<TD class="bw" bgcolor#aaaaaa align=center>&nbsp;Отмеченные&nbsp;</TD>
<TD align="center" bgcolor=#ffffff>
<SELECT name=copytype><OPTION selected value="optcopy">Копировать<OPTION value="optcut">Переместить</SELECT>
Новое место: <INPUT type="text" size="30" name=newplace>
<INPUT type="submit" value="Поехали" name="cpy">
</TD>
<TD align="center" bgcolor=#ffffff>
<INPUT type="submit" name=dlt value="Удалить" onclick='if(!confirm("Уверен?")){return false;}'>
</TD>
</TR>
</TABLE>
</FORM>
</TD></TR></TABLE>

<BR>

<TABLE cellpadding="0" cellspacing="0">
<TR>
<TD valign="top">

<!-- col1 -->

	<TABLE cellpadding="0" cellspacing="0" width="100%" bgcolor="#aaaaaa"><TR><TD>

	<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
	<TR><TD class="bw">Закачка</TD></TR>

	<TR bgcolor="#ffffff"><TD>
	<FORM action="upload.php?path=<?=$path?>" method=post ENCTYPE="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
	Файл №1: <INPUT type="file" name=f[1] size="32"><BR>
	Файл №2: <INPUT type="file" name=f[2] size="32"><BR>
	Файл №3: <INPUT type="file" name=f[3] size="32"><BR>
	Файл №4: <INPUT type="file" name=f[4] size="32"><BR>
	Файл №5: <INPUT type="file" name=f[5] size="32"><BR>
	<INPUT type="submit" value="Закачать" name="submit">
	&nbsp;&nbsp;&nbsp;<A href="upload.php?type=more&path=<?=$path?>">Закачать много файлов</A>
	</FORM>
	</TD></TR>
	</TABLE>

	</TD></TR></TABLE>

<!-- /col1 -->

</TD>
<TD>&nbsp;&nbsp;&nbsp;<TD>
<TD valign="top">

<!-- col2 -->

	<TABLE cellpadding="0" cellspacing="0" width="100%" bgcolor="#aaaaaa"><TR><TD>

	<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
	<TR><TD class="bw">Переход в папку (относительно корневого каталога)</TD></TR>

	<TR bgcolor="#ffffff"><TD align="center">
	<FORM action="index.php?path=<?=$path?>" method=post name=np>

	Путь: <INPUT type=text name="newpath" size="40" value="<?=$path?>">
	<INPUT type="submit" value="Перейти"><BR>

	</FORM>
	</TD></TR>
	</TABLE>

	</TD></TR></TABLE>

	<BR>

	<TABLE cellpadding="0" cellspacing="0" width="100%" bgcolor="#aaaaaa"><TR><TD>

	<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
	<TR><TD class="bw">Создание</TD></TR>

	<TR bgcolor="#ffffff"><TD align="center">
	<FORM action="dos.php?action=create&path=<?=$path?>" method=post>
	<SELECT name="type"><OPTION selected value="folder">Папка<OPTION value="cfile">Файл</SELECT>
	Имя: <INPUT type="text" size="30" name="str">
	<INPUT type="submit" value="Создать">	
	</FORM>
	</TD></TR>
	</TABLE>

	</TD></TR></TABLE>

<!-- /col2 -->

</TD>
</TR>
</TABLE>

</body>
</html>


<?


}

?>

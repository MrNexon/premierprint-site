<?

                	
session_start();

include("../init.php");
include("../classes/auth.php");
include("../functions/functions.php");

$auth = new User;

if (!$auth -> Auth()) exit(header("Location: ../login.php"));
else
{

if ($save)
{
	$textfile = str_replace('\\"',"\"",$textfile);
	$textfile = str_replace('\\\\','\\',$textfile);

	$fp = fopen($DOCUMENT_ROOT.$path.$file,"w");
	fwrite($fp, $textfile);
	fclose($fp);

	header("Location: index.php?path=".$path);
}
elseif ($cancel) header("Location: index.php?path=".$path);

if ($file && $path)
{

?>

<html>
<head>
<title>ak.filemanager</title>
<link href="style.css" type="text/css" rel="stylesheet">
</head>
<body onload="document.frm.textfile.focus();">

<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" align="center">
<TR><TD>
<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR><TD class=bw>Редактирование файла "<?=$SERVER_NAME.$path.$file?>"</TD></TR>
<FORM action="editfile.php?action=save&path=<?=$path?>" method=post name=frm>
<TR bgcolor=#ffffff><TD align=center>

<TEXTAREA cols=80 rows=25 name=textfile wrap=off>
<?

if (file_exists($DOCUMENT_ROOT.$path.$file))
{
	$f = file($DOCUMENT_ROOT.$path.$file);
	for ($i=0; $i<sizeof($f); $i++) {echo htmlspecialchars($f[$i]);}
}

?>
</TEXTAREA><BR>
<INPUT type=hidden name="file" value=<?=$file?>>
<INPUT type="submit" value="Сохранить" name=save>
<INPUT type="submit" value="Отмена" name=cancel>

</TD></TR>
</TABLE>

</TD></TR>
</TABLE>
</FORM>

</body>
</html>

<?

}


}


?>

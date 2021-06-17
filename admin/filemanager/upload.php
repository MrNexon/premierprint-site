<?

                	
session_start();

include("../init.php");
include("../classes/auth.php");
include("../functions/functions.php");

$auth = new User;

if (!$auth -> Auth()) exit(header("Location: ../login.php"));
else
{

parse_str($QUERY_STRING);

if ($submit)
{
	Chdir($DOCUMENT_ROOT.$path);
	for ($i=1;$i<6;$i++)
	{
		if (is_uploaded_file($f[$i])) {
			move_uploaded_file($f[$i],$f_name[$i]);
			chmod($f_name[$i], 0777);
		}
	}
	exit(header("Location: ./?path=".$path));
}

if ($submany)
{
	Chdir($DOCUMENT_ROOT.$path);
	for ($i=1;$i<51;$i++)
	{
		if (is_uploaded_file($f[$i])) {
			move_uploaded_file($f[$i],$f_name[$i]);
			chmod($f_name[$i], 0777);
		}
	}
	exit(header("Location: ./?path=".$path));
}
elseif ($cancel) header("Location: ./?path=".$path);

if ($type == "more")
{
?>
<html>
<head>
<title>ak.filemanager</title>
<link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<FORM action="upload.php?path=<?=$path?>" method=post ENCTYPE="multipart/form-data">

<TABLE cellpadding="0" cellspacing="0" border="0" bgcolor="#aaaaaa" align="center">
<TR><TD>
<TABLE cellpadding="2" cellspacing="1" border="0" width="100%">
<TR><TD class=bw colspan="4">Закачка в директорию <?=$SERVER_NAME.$path?></TD></TR>

<?

for ($i=1;$i<51;$i=$i+2)
{
	echo "<TR bgcolor=ffffff><TD>Файл №".$i.":</TD><TD><INPUT type=file name=f[".$i."] size=32></TD><TD>Файл № ".($i+1).":</TD><TD><INPUT type=file name=f[".($i+1)."] size=32></TD></TR>";
}

?>

<TR><TD bgcolor=#ffffff colspan="4" align=center><BR>
<INPUT type="submit" value="Закачать" name="submany">
<INPUT type="submit" value="Отмена" name="cancel">
<BR><BR></TD></TR>

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
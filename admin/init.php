<?

setlocale(LC_ALL, 'ru_RU.CP1251', 'ru_RU', 'ru');

//������� � �����������

$table['structure']	=	"premier_structure";
$table['modules']	=	"premier_modules";
$table['users']		=	"premier_system_users";
$table['settings']	=	"premier_settings";
$table['text']		=	"premier_news";
$table['pictures']	=	"premier_pictures";
$table['links1']	=	"premier_links1";
$table['links2']	=	"premier_links2";
$table['gallery']	=	"premier_gallery";


//mysql settings

$dbhost		= "localhost";
$dbuser		= "premierprint";
$dbpasswd	= "polymer25none";

$dbname		= "premierprint";


class DB
{

	//��������� �� ������
	function Error($msg)
	{
		echo "<FONT color='#ff0000'><B>".$msg."</B></FONT>";
	}


	//����������� � ��
	function Connect()
	{
		mysql_connect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpasswd']) or die($this -> Error("Can't connect to mysql"));
		$tilt = mysql_connect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpasswd']);
		mysql_set_charset('cp1251',$tilt);
		mysql_select_db($GLOBALS['dbname']);
	}


	//�������� ���������� � ��
	function Close()
	{
		mysql_close();
	}


	//���������� ��������� �������
	function NumRows($result)
	{
		return mysql_num_rows($result);
	}


	//������ � ��
	function Query($sql)
	{
		return mysql_query($sql);
	}


	//������� �������
	function FetchArray($result)
	{
		return mysql_fetch_array($result);
	}

}


$MySQL = new DB;
$MySQL -> Connect();
//$MySQL -> Close();

/////////////////////////////////////////////////
//
// ������ ����������, ������� ����� ��� �������
//
/////////////////////////////////////////////////

//������ ������������

$user = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['users']." WHERE login='".$session['login']."'"));


// ������ $settings

$result = @mysql_query("SELECT * FROM ".$table['settings']);
while ($sql_settings = @mysql_fetch_array($result))
{
	$settings2[$sql_settings['var']] = $sql_settings['value'];

	$sql_settings['value'] = htmlspecialchars($sql_settings['value']);
	$settings[$sql_settings['var']] = $sql_settings['value'];

}

@mysql_free_result($result);

//������������ �������
$user_access =	array(
			'������������',
			'�������������'
		);

$years	=	array(
		);

$months	=	array(
			'������',
			'�������',
			'�����',
			'������',
			'���',
			'����',
			'����',
			'�������',
			'��������',
			'�������',
			'������',
			'�������'
		);

$months_im =	array(
			'������',
			'�������',
			'����',
			'������',
			'���',
			'����',
			'����',
			'������',
			'��������',
			'�������',
			'������',
			'�������'
		);


parse_str(substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "?")+1));


include("fckeditor/fckeditor.php");

?>

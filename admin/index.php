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

//сессия прошла нормально

	// текущий пункт меню
	if (isset($module))
	{
		$sql_menu_now = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['modules']." WHERE name='$module' AND module != '' GROUP BY name LIMIT 1"));
	}

	// разрешенный данный модуль пользователю

	$flag = true;

	if (!$user['access'])
	{

		$flag = false;

		$acc_mods = explode(" ",$user['modules']);
		$acc_mods[] = "cabinet";

		for ($i=0; $i<sizeof($acc_mods); $i++)
		{
			if (trim($acc_mods[$i]) == $sql_menu_now['name']) $flag = true;
		}
	}

	// подключаем модуль
	if (!file_exists("modules/".$sql_menu_now['module'].".module.php") || !isset($module) || !$sql_menu_now['publish'] || !$flag)
	{
		$inc_module = "default";
	}
	else
	{
		$inc_module = $sql_menu_now['module'];
	}


	if (!$submit_flag) include("inc/top.inc.php");


	include("modules/".$inc_module.".module.php");


	if (!$submit_flag) include("inc/bottom.inc.php");

}


$MySQL -> Close();

?>
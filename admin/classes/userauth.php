<?

class UserAuth
{
	//функция проверки правильности ввода логина и пароля
	function Auth()
	{
		global $usess, $siteuser;

		if ($usess['login'] == $siteuser['login'] && $usess['password'] == $siteuser['password'] && $usess['login'] !="" && $usess['password'] !="") return true;
		else return false;
	}

	//функция завершения работы с системой
	function LogOut()
	{
		session_destroy();
	}

}



?>
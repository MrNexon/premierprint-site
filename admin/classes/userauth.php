<?

class UserAuth
{
	//������� �������� ������������ ����� ������ � ������
	function Auth()
	{
		global $usess, $siteuser;

		if ($usess['login'] == $siteuser['login'] && $usess['password'] == $siteuser['password'] && $usess['login'] !="" && $usess['password'] !="") return true;
		else return false;
	}

	//������� ���������� ������ � ��������
	function LogOut()
	{
		session_destroy();
	}

}



?>
<?

//ak, 10.08.2002 - 5.04.2003 :-)

//����� ��� �����������
//global s;

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!! �� �������� ��� ���������� ���������� !!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

class User
{
	//������� �������� ������������ ����� ������ � ������
	function Auth()
	{
		global $session, $user;

//		echo $session['login']."\n".$session['password']."<BR>";
//		echo $sql_user['login']."\n".$sql_user['password']."<BR>";

		if ($session['login'] == $user['login'] && $session['password'] == $user['password'] && $session['login'] !="" && $session['password'] !="") return true;
		else return false;
	}

	//������� ���������� ������ � ��������
	function LogOut()
	{

		session_destroy();
		exit(header("Location: login.php"));

	}

}



?>
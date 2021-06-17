<?

function bin()
{
	global $fs, $i;

	$b = Array('exe','gif','jpg','zip','rar','arj','lzh','com','psd','mp3','avi','rm','wav','mid','bmp','dll','jpeg','jpe','tiff','pcx');

	$a = explode(".", $fs[$i]);

	$f = true;

	for ($j=0;$j<sizeof($b);$j++)
		if (strtolower($a[1]) == $b[$j]) {$f = false; break;}

	return $f;
}

function zero($UNIXDate)
{
	if ($UNIXDate['mday']/10<1){$UNIXDate['mday'] = "0".$UNIXDate['mday'];}
	if ($UNIXDate['mon']/10<1){$UNIXDate['mon'] = "0".$UNIXDate['mon'];}
	if ($UNIXDate['minutes']/10<1){$UNIXDate['minutes'] = "0".$UNIXDate['minutes'];}
	if ($UNIXDate['hours']/10<1){$UNIXDate['hours'] = "0".$UNIXDate['hours'];}
	if ($UNIXDate['seconds']/10<1){$UNIXDate['seconds'] = "0".$UNIXDate['seconds'];}

	return $UNIXDate;
}

function createdate($k, $t)
{
	global $DOCUMENT_ROOT, $path, $dir, $fs, $i;

	if ($k == 'd') $a = stat($DOCUMENT_ROOT.$path.$dir[$i]);
	else $a = stat($DOCUMENT_ROOT.$path.$fs[$i]);

	if ($t == 'c') $b = getdate($a[10]);
	else $b = getdate($a[9]);

	$b = zero($b);

	return $b['mday']."/".$b['mon']."/".$b['year']." - ".$b['hours'].":".$b['minutes'].":".$b['seconds'];
}

function freepath()
{
	global $path;

	$s = explode("/",$path);

//	unset($path);

	for ($i=1; $i<sizeof($s); $i++)
	{
		if ($s[$i] == "..")
		{
			unset($s[$i]);
			unset($s[$i-1]);
		}
	}

	$path = "";

	for ($i=0; $i<sizeof($s); $i++)
	{
		if (isset($s[$i]))
		{
			$path = $path.$s[$i]."/";
		}
	}

	$path = str_replace("//","/",$path);
	$path = str_replace(" ","%20",$path);	

}

?>
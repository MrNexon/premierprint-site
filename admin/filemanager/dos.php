<?

switch ($action)
{
	case "ren":
	{
		rename($DOCUMENT_ROOT.$path.$oldfile, $DOCUMENT_ROOT.$path.$newfile);
	}

	case "create":
	{
		if ($type == "folder")
		{
			mkdir($DOCUMENT_ROOT.$path.$str, 0755);
		}

		if ($type == "cfile")
		{
			exit(header("Location: editfile.php?file=".$str."&path=".$path));
		}

	}

	case "copydel":
	{
		if ($dlt)
		{
			for ($i=0; $i<$dirsize; $i++)
			{
				if (isset($deldir[$i]))
				{
					rmdir($DOCUMENT_ROOT.$path.$deldir[$i]);
				}
			}

			for ($i=0; $i<$fssize; $i++)
			{
				if (isset($delfile[$i]))
				{
					unlink($DOCUMENT_ROOT.$path.$delfile[$i]);
				}
			}
		}

		if ($cpy)
		{
			for ($i=0; $i<$fssize; $i++)
			{
				if (isset($delfile[$i]))
				{
					if (is_dir($DOCUMENT_ROOT.$newplace))
					{
						copy($DOCUMENT_ROOT.$path.$delfile[$i],$DOCUMENT_ROOT.$newplace."/".$delfile[$i]);

						if ($copytype == "optcut")
						{
							if (file_exists($DOCUMENT_ROOT.$newplace."/".$delfile[$i]))
							{
								unlink($DOCUMENT_ROOT.$path.$delfile[$i]);
							}
						}
					}
				}
			}
		}

	}

        header("Location: ./?path=".$path);
}


?>
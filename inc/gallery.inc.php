<script src="/js/prototype.js" type="text/javascript"></script>
<script src="/js/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="/js/lightbox.js" type="text/javascript"></script>

<?

$id = $galleryid;

if (isset($galleryid))
{
	$gal_rubric = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['gallery']." WHERE id='$id'"));

	//print_r($gal_sql);

	$res_gallery = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE section='$id' ORDER BY position DESC, id DESC");
	$n = @mysql_num_rows($res_gallery);

	if ($n)
	{

		if ($page_tree_sql2['id'] == 32)
		{

?>

		<H2>Наши работы</H2>

<?

		}

		$i = 1;

?>
		<TABLE cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:39px;">
		<TR valign="top">

<?

		while ($gal_sql = @mysql_fetch_array($res_gallery))
		{
			if (file_exists($DOCUMENT_ROOT."/media/gallery/".$gal_sql['id']."/sm_".$gal_sql['logo']) && $gal_sql['logo'] != '')
			{

?>
			<TD width="25%" align="center"><A href="/media/gallery/<?=$gal_sql['id']?>/<?=$gal_sql['logo']?>" rel="lightbox[roadtrip]" title="<?=$gal_sql['description']?>" target="_blank"><IMG alt="" align="absmiddle" src="/media/gallery/<?=$gal_sql['id']?>/sm_<?=$gal_sql['logo']?>" height="120" border="0"></A></TD>

<?

			}

			if ($i%4==0 && $i != $n)
			{

?>
			</TR>
			<TR>
				<TD><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="90" border="0"></TD>
			</TR>
			<TR valign="top">

<?

			}

			$i++;
		}

?>
		</TR>
		</TABLE>

<?

	}

}


// вывод случайных 5 работ из раздела "Возможности трафаретной печати"
if ($page_tree_sql2['id'] == 32)
{

?>

	<H2><A href="/company/ability/">Возможности</A> трафаретной печати</H2>

<?

	$res_gallery = @mysql_query("SELECT * FROM ".$table['gallery']." WHERE section='2' ORDER BY RAND()");
	$n = @mysql_num_rows($res_gallery);

	if ($n)
	{
		$i = 1;

?>
		<TABLE cellpadding="0" cellspacing="0" border="0" width="100%">
		<TR valign="top">

<?

		while ($gal_sql = @mysql_fetch_array($res_gallery))
		{
			if ($i <= 8 )
			{
				if (file_exists($DOCUMENT_ROOT."/media/gallery/".$gal_sql['id']."/sm_".$gal_sql['logo']) && $gal_sql['logo'] != '')
				{

?>
				<TD width="25%" align="center"><A href="/media/gallery/<?=$gal_sql['id']?>/<?=$gal_sql['logo']?>" rel="lightbox2[roadtrip]" title="<?=$gal_sql['description']?>" target="_blank"><IMG alt="" align="absmiddle" src="/media/gallery/<?=$gal_sql['id']?>/sm_<?=$gal_sql['logo']?>" height="120" border="0"></A></TD>

<?

				}

				if ($i%4==0 && $i != 8)
				{

?>
				</TR>
				<TR>
					<TD><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="90" border="0"></TD>
				</TR>
				<TR valign="top">

<?
				}
			}
			else
			{

?>
				<DIV style="display:none;"><A href="/media/gallery/<?=$gal_sql['id']?>/<?=$gal_sql['logo']?>" rel="lightbox2[roadtrip]" title="<?=$gal_sql['description']?>" target="_blank">&nbsp;</A></DIV>

<?
			}

			$i++;
		}

?>
		</TR>
		</TABLE>

<?

	}

}


?>
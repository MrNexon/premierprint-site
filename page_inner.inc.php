

	<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
	<TR valign="top">
		<TD style="padding:75px 0px 0px 75px;" width="50%">
			<DIV><IMG alt="<?=$page_tree_sql1['title']?>" align="absmiddle" src="/img/title_<?=$page_tree_sql1['name']?>.gif" border="0"></DIV>

<?
		// внутри раздела "Оборудование"
		if ($page_tree_sql1['id'] == 3 && $page_curr['id'] != 3)
		{

?>
			<DIV style="margin:12px 0px 0px 0px;"><IMG alt="" align="absmiddle" src="/img/pic_equipment_<?=$page_tree_sql2['name']?>.gif" width="96" height="96" border="0"></DIV>

<?
		}

?>
		</TD>
		<TD style="padding:75px 0px 0px 0px;" width="50%">


<?

		// не выводить меню на главной раздела "Оборудование"
		if ($page_curr['id'] != 3)
		{
			$submenu_result = @mysql_query("SELECT name, id, cleft, cright, title FROM ".$table['structure']." WHERE clevel = '2' && cleft > '".$page_tree_sql1['cleft']."' && cright < '".$page_tree_sql1['cright']."' && publish = '1' ORDER BY cleft");
			
			$i = 1;

			while($submenu_sql =  @mysql_fetch_array($submenu_result))
			{
//				$page_info  = get_page_info($submenu_sql['id']);

				if ($submenu_sql['id'] != $page_tree_sql2['id'])
				{
?>
					<TABLE cellspacing="0" cellpadding="0" border="0">
					<TR valign="top">
					<TD nowrap class="submenu" onmouseover="document.getElementById('menu1<?=$i?>').className='on'" onmouseout="document.getElementById('menu1<?=$i?>').className='off'"><DIV id="menu1<?=$i?>" class="off"><A href="/<?=$page_tree_sql1['name']?>/<?=$submenu_sql['name']?>/"><?=$submenu_sql['title']?></A></DIV></TD>
					</TR>
					</TABLE>

<?
				}
				else
				{

?>
					<TABLE cellspacing="0" cellpadding="0" border="0">
					<TR valign="top">
					<TD nowrap class="submenu"><DIV id="menu1<?=$i?>" class="on"><A href="/<?=$page_tree_sql1['name']?>/<?=$submenu_sql['name']?>/"><?=$submenu_sql['title']?></A></DIV></TD>
					</TR>
					</TABLE>

<?
				}

				$i++;
			}
		}

?>

		</TD>
	</TR>
	</TABLE>
			
	<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
	<TR valign="top">
		<TD style="padding:37px 80px 37px 75px;" width="100%"><IMG  style="background:url('/img/line-h.gif') repeat-x top left;" alt="" align="absmiddle" src="/img/1x1.gif" width="100%" height="1" border="0"></TD>
	</TR>
	<TR valign="top">
		<TD style="padding:0px 80px 75px 75px;">

<?

		// раздел "Оборудование"
		if ($page_curr['id'] == 3)
		{

?>

				<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
				<TR valign="top" align="center">
					<TD style="padding:10px 50px 0px 50px;"><A href="/equipment/rotary/"><IMG alt="" align="absmiddle" src="/img/pic_equipment_rotary.gif" width="96" height="96" border="0"></A></TD>
					<TD width="100%" style="padding:10px 0px 0px 0px;"><A href="/equipment/flat-bed/"><IMG alt="" align="absmiddle" src="/img/pic_equipment_flat-bed.gif" width="96" height="96" border="0"></A></TD>
					<TD style="padding:10px 50px 0px 50px;"><A href="/equipment/cylindrical/"><IMG alt="" align="absmiddle" src="/img/pic_equipment_cylindrical.gif" width="96" height="96" border="0"></A></TD>
				</TR>
				<TR align="center">
					<TD style="padding:37px 0px 48px 0px"><A href="/equipment/rotary/">Карусельные станки<BR>для трафаретной печати</A></TD>
					<TD style="padding:37px 0px 48px 0px"><A href="/equipment/flat-bed/">Плоскопечатные станки<BR>для трафаретной печати</A></TD>
					<TD style="padding:37px 0px 48px 0px"><A href="/equipment/cylindrical/">Станки для цилиндрических<BR>и конических поверхностей</A></TD>
				</TR>
				<TR valign="top" align="center">
					<TD style="padding:0px 50px 0px 50px;"><A href="/equipment/prepress/"><IMG alt="" align="absmiddle" src="/img/pic_equipment_prepress.gif" width="96" height="96" border="0"></A></TD>
					<TD width="100%"><A href="/equipment/drying/"><IMG alt="" align="absmiddle" src="/img/pic_equipment_drying.gif" width="96" height="96" border="0"></A></TD>
					<TD style="padding:0px 50px 0px 50px;"><A href="/equipment/stencil/"><IMG alt="" align="absmiddle" src="/img/pic_equipment_stencil.gif" width="96" height="96" border="0"></A></TD>
				</TR>
				<TR align="center">
					<TD style="padding:37px 0px 48px 0px"><A href="/equipment/prepress/">Оборудование<BR>для допечатной подготовки</A></TD>
					<TD style="padding:37px 0px 48px 0px"><A href="/equipment/drying/">Сушильные<BR>устройства</A></TD>
					<TD style="padding:37px 0px 48px 0px"><A href="/equipment/stencil/">Трафаретные<BR>рамы и сетки</A></TD>
				</TR>
				</TABLE>

<?
		}
		// остальные страницы и разделы
		else
		{

			$submenu_result2 = @mysql_query("SELECT name, id, cleft, cright, title FROM ".$table['structure']." WHERE clevel = '3' && cleft > '".$page_tree_sql2['cleft']."' && cright < '".$page_tree_sql2['cright']."' && publish = '1' ORDER BY cleft");
			$n = @mysql_num_rows($submenu_result2);

			if ($n)
			{

?>

				<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
				<TR valign="top">
				<TD>

<?
				// раздел "Оборудование"
				if ($page_tree_sql1['id'] == 3)
				{

?>

				<DIV style="float:left; margin:2px 3px 0px 0px;">Все <?=strtolower($page_tree_sql2['title'])?>:</DIV>


<?
				}
				else
				{

?>

				<DIV style="float:left; margin:2px 3px 0px 0px;"><?=$page_tree_sql2['title']?>:</DIV>


<?
				}

				$i = 1;

				while($submenu_sql2 =  @mysql_fetch_array($submenu_result2))
				{
//					$page_info  = get_page_info($submenu_sql['id']);

					if ($submenu_sql2['id'] != $page_tree_sql3['id'])
					{

?>
					<DIV style="float:left;">
					<TABLE cellspacing="0" cellpadding="0" border="0">
					<TR valign="top">
					<TD nowrap class="submenu" onmouseover="document.getElementById('menu2<?=$i?>').className='on'" onmouseout="document.getElementById('menu2<?=$i?>').className='off'"><DIV id="menu2<?=$i?>" class="off"><A href="/<?=$page_tree_sql1['name']?>/<?=$page_tree_sql2['name']?>/<?=$submenu_sql2['name']?>/"><?=$submenu_sql2['title']?></A></DIV></TD>

<?
					if ($i != $n)
					{

?>
					<TD>,&nbsp;</TD>

<?
					}
					else
					{

?>
					<TD>.</TD>

<?
					}

?>
					</TR>
					</TABLE>
					</DIV>

<?
					}
					else
					{

?>
					<DIV style="float:left;">
					<TABLE cellspacing="0" cellpadding="0" border="0">
					<TR valign="top">
					<TD nowrap class="submenu"><DIV id="menu2<?=$i?>" class="on"><A href="/<?=$page_tree_sql1['name']?>/<?=$page_tree_sql2['name']?>/<?=$submenu_sql2['name']?>/"><?=$submenu_sql2['title']?></A></DIV></TD>

<?
					if ($i != $n)
					{

?>
					<TD>,&nbsp;</TD>

<?
					}
					else
					{

?>
					<TD>.</TD>

<?
					}

?>
					</TR>
					</TABLE>
					</DIV>

<?
					}

					$i++;
				}

?>

				</TD>
				</TR>
				</TABLE>

				<BR clear="all"><BR>

<?

			}

			if ($page_curr['clevel'] > 1)
			{

?>

			<H1><?=$page_curr['title']?></H1>

<?

			}

?>

			<?eval("?>".$page_curr['pagedata1']."<?");?>

			<?eval("?>".$page_curr['pagedata_php']."<?");?>

<?

		}

?>

		</TD>
	</TR>
	</TABLE>


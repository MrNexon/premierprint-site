<?

	include("admin/init.php");
	include("admin/functions/functions.php");

	$tmp_page_url = explode("?", $_SERVER['REQUEST_URI']);
	$page_url = explode("/", $tmp_page_url[0]);

	if ($page_url[sizeof($page_url)-1] != "") 	{$page_level = sizeof($page_url)-1;}
	else 						{$page_level = sizeof($page_url)-2;}

	if ($page_url[$page_level] == "index.html")	$page_level = $page_level-1;

	$page_title = "";

	$page_tree_sql0 = @mysql_fetch_array(@mysql_query("SELECT id, cleft, cright, clevel, name, title, publish FROM ".$table['structure']." WHERE clevel ='0' && name='/'"));

	for ($page_tree = 1; $page_tree <= $page_level; $page_tree++)
	{
		${"page_tree_sql".$page_tree} = @mysql_fetch_array(@mysql_query("SELECT id, cleft, cright, clevel, name, title, publish, pagedata3 FROM ".$table['structure']." WHERE cleft > '".${"page_tree_sql".($page_tree-1)}['cleft']."' AND cright < '".${"page_tree_sql".($page_tree-1)}['cright']."' AND clevel='".$page_tree."' AND name='".$page_url[$page_tree]."'"));

		$page_title .= " / ".${"page_tree_sql".$page_tree}['title'];
	}

	$page_curr = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['structure']." WHERE id='".${"page_tree_sql".$page_level}['id']."'"));

	//redirect
	if ($page_curr['pagedata2'] != "") exit(header("Location: ".$page_curr['pagedata2']));

	$page_first = @mysql_fetch_array(@mysql_query("SELECT meta_keywords, meta_description FROM ".$table['structure']." WHERE id='1'"));

	if ($page_curr['id'] == "") exit(header("Location: /"));

?>

<HTML>
<HEAD>
	<TITLE><?=$settings['title'].$page_title?></TITLE>
	<META name="Description" content="<?=(($page_curr['meta_description'] == "")?$page_first['meta_description']:$page_curr['meta_description'])?>">
	<META name="Keywords" content="<?=(($page_curr['meta_keywords'] == "")?$page_first['meta_keywords']:$page_curr['meta_keywords'])?>">
	<META http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<LINK href="/style.css" rel="stylesheet" type="text/css">
	<LINK href="/lightbox.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY leftmargin="0" marginheight="0" marginwidth="0" topmargin="0" style="background:url('<?=(is_file($DOCUMENT_ROOT."/media/bg/".$page_tree_sql1['id']."/".$page_tree_sql1['pagedata3'])?"/media/bg/".$page_tree_sql1['id']."/".$page_tree_sql1['pagedata3']:"/img/bg_main.gif")?>') #000000 top left;">

<TABLE cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
<TR valign="top">
<TD style="padding:0px 55px 0px 0px;">

<TABLE cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
<TR valign="top">
	<TD>
		<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
		<TR valign="bottom">
			<TD style="padding:37px 55px 38px 62"><IMG alt="" align="absmiddle" src="/img/pick.gif" width="15" height="15" border="0"></TD>
			<TD width="100%"><IMG alt="" align="absmiddle" src="/img/corner1.gif" width="364" height="47" border="0"></TD>
			<TD class="small white" nowrap style="padding:0px 70px 25px 0px;">

					<?=$settings2['contacts1']?>

			</TD>
			<TD class="white small" nowrap style="padding:0px 43px 25px 0px;">

					<?=$settings2['contacts2']?>
					
			</TD>
			<TD>
				<DIV style="position:relative; margin:-53px 0px 0px 12px;"><IMG alt="" align="absmiddle" src="/img/pick.gif" width="15" height="15" border="0"></DIV>
			</TD>
		</TR>
		</TABLE>
	</TD>
</TR>
<TR valign="top">
	<TD>
		<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
		<TR valign="top">
			<TD style="padding:0px 131px 0px 0px;"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
			<TD bgcolor="#FFFFFF" style="padding:12px 0px 35px 67px;"><?=(($page_curr['name'] != "/")?"<A href=\"/\">":"")?><IMG alt="<?=$settings['title']?>" title="<?=$settings['title']?>" align="absmiddle" src="/img/logo.gif" width="180" height="41" border="0"><?=(($page_curr['name'] != "/")?"</A>":"")?></TD>
			<TD bgcolor="#FFFFFF" style="padding:0px 72px 0px 0px;" align="right" width="100%"><IMG alt="" align="absmiddle" src="/img/colors_top.gif" width="119" height="21" border="0"></TD>
			<TD><IMG alt="" align="absmiddle" src="/img/corner2.gif" width="6" height="88" border="0"></TD>
		</TR>
		</TABLE>
	</TD>
</TR>
<TR valign="top">
	<TD>
		<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
		<TR valign="top">
			<TD style="padding:0px 131px 0px 0px;"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
			<TD bgcolor="#FFFFFF" width="100%" style="padding:0px 100px 0px 105px;">

				<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
				<TR valign="top">

<?

			$menu_result = @mysql_query("SELECT name, id, cleft, cright, title FROM ".$table['structure']." WHERE clevel = '1' AND publish = '1' ORDER BY cleft");

			$i = 1;
			$n = @mysql_num_rows($menu_result);

			while($menu_sql =  @mysql_fetch_array($menu_result))
			{
				//$page_info  = get_page_info($menu_sql['id']);

				if ($menu_sql['id'] != $page_tree_sql1['id'])
				{
?>
					<TD nowrap class="menu" onMouseOver="document.getElementById('menu0<?=$i?>').className='on'" onMouseOut="document.getElementById('menu0<?=$i?>').className='off'"><DIV id="menu0<?=$i?>" class="off">/&nbsp;<A href="/<?=$menu_sql['name']?>/"><?=strtolower($menu_sql['title'])?></A></DIV></TD>

<?
				}
				else
				{

?>
					<TD nowrap class="menu"><DIV id="menu0<?=$i?>" class="on">/&nbsp;<A href="/<?=$menu_sql['name']?>/"><?=strtolower($menu_sql['title'])?></A></DIV></TD>

<?
				}

				if ($i < $n)
				{

?>

					<TD width="<?=ceil(100 / $n)?>%"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>

<?
				}

				$i++;
			}

?>

				</TR>
				</TABLE>
			
			</TD>
		</TR>
		</TABLE>
	</TD>
</TR>
<TR valign="top">
	<TD height="100%">

		<TABLE cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
		<TR valign="top">
			<TD height="100%">

				<TABLE cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
				<TR valign="top">
					<TD height="50%"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
					<TD bgcolor="#FFFFFF"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
				</TR>
				<TR>
					<TD><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="132" height="1" border="0"></TD>
					<TD>

						<DIV><IMG alt="" align="absmiddle" src="/img/carving.gif" width="34" height="16" border="0"></DIV>

<?

					$sql_banner = @mysql_fetch_array(@mysql_query("SELECT * FROM ".$table['pictures']." WHERE id='1'"));

					if (is_file($DOCUMENT_ROOT."/media/pictures/1/".$sql_banner['smallpicture']))
					{

?>
						<DIV style="position:absolute; left:0px;"><?=(($sql_banner['engname']!="")?"<A href=\"".$sql_banner['engname']."\">":"")?><IMG alt="<?=$sql_banner['announce']?>" align="absmiddle" src="/media/pictures/1/<?=$sql_banner['smallpicture']?>" width="240" height="210" border="0"><?=(($sql_banner['engname']!="")?"</A>":"")?></DIV>

<?
					}
					else
					{

?>

						<DIV style="position:absolute; left:0px;"><IMG alt="" align="absmiddle" src="/img/picture.gif" width="240" height="210" border="0"></DIV>

<?
					}

?>
						<DIV style="margin:210px 0px 0px 0px;"><IMG alt="" align="absmiddle" src="/img/carving.gif" width="34" height="16" border="0"></DIV>
					</TD>
				</TR>
				<TR valign="top">
					<TD height="50%"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
					<TD bgcolor="#FFFFFF"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
				</TR>
				<TR valign="top">
					<TD><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="150" border="0"></TD>
					<TD bgcolor="#FFFFFF"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
				</TR>
				</TABLE>

			
			</TD>
			<TD bgcolor="#FFFFFF" width="100%">

<?
			if ($page_curr['name'] == "/")
			{
				include("page_main.inc.php");
			}
			else
			{
				include("page_inner.inc.php");
			}

?>

			</TD>
		</TR>
		</TABLE>

	</TD>
</TR>
<TR valign="top">
	<TD>
		<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
		<TR valign="top">
			<TD style="padding:0px 0px 0px 132px;"><IMG alt="" align="absmiddle" src="/img/corner3.gif" width="6" height="6" border="0"></TD>
			<TD width="100%" bgcolor="#FFFFFF"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="6" border="0"></TD>
			<TD align="right"><IMG alt="" align="absmiddle" src="/img/corner4.gif" width="6" height="6" border="0"></TD>
		</TR>
		</TABLE>
	</TD>
</TR>
<TR valign="top">
	<TD style="padding:30px 0px 30px 160px;">

		<DIV style="position:absolute; margin:-37px 0px 0px -98px;"><IMG alt="" align="absmiddle" src="/img/pick.gif" width="15" height="15" border="0"></DIV>

		<TABLE cellspacing="0" cellpadding="0" border="0">
		<TR>
			<TD valign="top"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="70" border="0"></TD>
			<TD valign="top" style="padding:3px 0px 0px 0px;"><IMG alt="" align="absmiddle" src="/img/colors_bottom.gif" width="47" height="8" border="0"></TD>
			<TD valign="top" style="padding:0px 35px 0px 25px;" class="small grey">
			&copy; &laquo;Премьер&raquo; 2009
			<DIV style="margin:16px 0px 0px 19px;">
<!-- HotLog -->
<script type="text/javascript" language="javascript">
hotlog_js="1.0"; hotlog_r=""+Math.random()+"&s=2008802&im=133&r="+escape(document.referrer)+"&pg="+escape(window.location.href);
document.cookie="hotlog=1; path=/"; hotlog_r+="&c="+(document.cookie?"Y":"N");
</script>
<script type="text/javascript" language="javascript1.1">
hotlog_js="1.1"; hotlog_r+="&j="+(navigator.javaEnabled()?"Y":"N");
</script>
<script type="text/javascript" language="javascript1.2">
hotlog_js="1.2"; hotlog_r+="&wh="+screen.width+"x"+screen.height+"&px="+(((navigator.appName.substring(0,3)=="Mic"))?screen.colorDepth:screen.pixelDepth);
</script>
<script type="text/javascript" language="javascript1.3">
hotlog_js="1.3";
</script>
<script type="text/javascript" language="javascript">
hotlog_r+="&js="+hotlog_js;
document.write('<a href="http://click.hotlog.ru/?2008802" target="_top"><img '+'src="http://hit32.hotlog.ru/cgi-bin/hotlog/count?'+hotlog_r+'" border="0" width="88" height="31" alt="HotLog"><\/a>');
</script>
<noscript>
<a href="http://click.hotlog.ru/?2008802" target="_top"><img src="http://hit32.hotlog.ru/cgi-bin/hotlog/count?s=2008802&amp;im=133" border="0" width="88" height="31" alt="HotLog"></a>
</noscript>
<!-- /HotLog -->
			</DIV>
			</TD>
			<TD valign="bottom" style="padding:0px 11px 10px 0px;"><IMG alt="" align="absmiddle" src="/img/n1.gif" width="31" height="33" border="0"></TD>
			<TD valign="top" class="small grey">
			
				<DIV>/ Разработка сайта:</DIV>
				<DIV style="margin:16px 0px 0px 0px;"><A class="small grey" href="http://www.none.ru" target="_blank">Креативное агентство N1<BR>www.none.ru</A></DIV>
			
			</TD>
            <TD valign="top" class="small grey" style="padding-left:30px">
			
				<DIV>/ Продвижение сайта:</DIV>
				<DIV style="margin:16px 0px 0px 0px;"><A title="раскрутка сайта краснодар" alt="продвижение сайта краснодар" class="small grey" href="http://www.spellseo.ru" target="_blank" style="font-size:10px;">Раскрутка сайта в краснодаре</A></DIV>
                <DIV><A title="продвижение сайта краснодар" alt="раскрутка сайта краснодар" class="small grey" href="http://www.spellseo.ru" target="_blank">www.spellseo.ru</A></DIV>
			
			</TD>
		</TR>
		</TABLE>
	</TD>
</TR>
</TABLE>

</TD>
</TR>
</TABLE>


</BODY>
</HTML>

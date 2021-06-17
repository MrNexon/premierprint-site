

				<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
				<TR valign="top">
					<TD style="padding:75px 70px 0px 75px;">

						<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
						<TR valign="top">
							<TD width="50%" style="padding:0px 35px 0px 0px;">

								<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
								<TR valign="top">
									<TD colspan="2" style="padding:0px 0px 35px 0px;"><h2><a href="/services/serigraphy/wrapping/" title="Трафаретная печать" alt="Трафаретная печать" style="text-decoration:none;">Трафаретная <br />
							      печать</a></h2></TD>
								</TR>
								<TR valign="top">
									<TD style="padding:0px 10px 0px 1px;" width="50%">

<?
									$result_links = @mysql_query("SELECT * FROM ".$table['links1']." WHERE publish='1' ORDER BY position, name, id DESC");

									$i = 0;
									$n = ceil(@mysql_num_rows($result_links) / 2) - 1;

									while ($sql_links = @mysql_fetch_array($result_links))
									{

?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="18" height="11" valign="top" style="padding:4px 0 6px 0"><img src="/img/li_main.gif" width="18" height="11" border="0" /></td>
                                            <td style="padding-bottom:6px"><A href="<?=$sql_links['link']?>"><?=$sql_links['name']?></A></td>
                                          </tr>
                                        </table>

<?
										if ($i == $n)
										{
?>

									</TD>
									<TD style="padding:0px 10px 0px 0px;" >

<?
										}

										$i++;
									}

?>
									</TD>
								</TR>
								</TABLE>

							</TD>
							<TD style="background:url('/img/line-w.gif') repeat-y top left;"><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
							<TD width="50%" style="padding:0px 0px 0px 35px;">

								<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
								<TR valign="top">
									<TD style="padding:0px 0px 30px 0px;"><h1><a href="/equipment/" title="Полиграфическое оборудование, оборудование для печати" alt="оборудование для печати: полиграфическое оборудование, печатное оборудование, шелкография оборудование" style="text-decoration:none;">Производство полиграфического оборудования</a></h1></TD>
								</TR>
								<TR valign="top">
									<TD>

<?
									$result_links = @mysql_query("SELECT * FROM ".$table['links2']." WHERE publish='1' ORDER BY position, name, id DESC");

									while ($sql_links = @mysql_fetch_array($result_links))
									{

?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="18" height="11" valign="top" style="padding:4px 0 6px 0"><img src="/img/li_main.gif" width="18" height="11" border="0" /></td>
                                            <td style="padding-bottom:6px"><A href="<?=$sql_links['link']?>"><?=$sql_links['name']?></A></td>
                                          </tr>
                                      </table>

<?
									}

?>
									</TD>
								</TR>
								</TABLE>

							</TD>
						</TR>
						</TABLE>
					</TD>
				</TR>
				</TABLE>
			
				<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
				<TR>
					<TD width="50%" style="padding:50px 0px 0px 77px;"><IMG alt="Новости" align="absmiddle" src="/img/title_main_news.gif" width="97" height="17" border="0"></TD>
					<TD width="50%" style="padding:50px 90px 0px 35px;">
					
						<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
						<TR>
							<TD><IMG alt="" align="absmiddle" src="/img/pics_main1.gif" width="70" height="70" border="0"></TD>
							<TD width="100%" align="center"><IMG alt="" align="absmiddle" src="/img/pics_main2.gif" width="71" height="70" border="0"></TD>
							<TD><IMG alt="" align="absmiddle" src="/img/pics_main3.gif" width="71" height="70" border="0"></TD>
						</TR>
						</TABLE>
					
					</TD>
				</TR>
				</TABLE>

				<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">
				<TR valign="top">
					<TD width="50%" style="padding:0px 0px 0px 75px;">

						<TABLE cellspacing="0" cellpadding="0" border="0" width="100%">

<?
					$news_result = @mysql_query("SELECT * FROM ".$table['text']." WHERE publish = '1' ORDER BY date DESC LIMIT 4");

					while($news_sql =  @mysql_fetch_array($news_result))
					{

?>
						<TR valign="top">
							<TD nowrap class="news-date"><?=date("d ", $news_sql['date']).$months[date("m", $news_sql['date']) - 1]?></TD>
							<TD width="100%" class="news-text"><?=$news_sql['announce']?></TD>
						</TR>

<?
					}

?>
						<TR>
							<TD><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="77" height="1" border="0"></TD>
							<TD><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="1" border="0"></TD>
						</TR>
						</TABLE>

					
					</TD>
					<TD><IMG alt="" align="absmiddle" src="/img/1x1.gif" width="1" height="275" border="0"></TD>
					<TD width="50%" style="padding:35px 90px 35px 39px;">

					<?eval("?>".$page_curr['pagedata1']."<?");?>

					</TD>
				</TR>
				</TABLE>




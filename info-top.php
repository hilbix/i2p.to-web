<?
# $Header: /home/tino/CVSROOT/i2pinproxy/info-top.php,v 1.2 2008/08/28 10:41:44 tino Exp $
#
# $Log: info-top.php,v $
# Revision 1.2  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page
#
# Revision 1.1  2008/08/28 09:52:27  tino
# Added

include("showtable2.php");

$h	= mustparam("host",	'[-_.a-z0-9]+\.i2p');
$code   = param("code",		'[0-9]*',		'');
$oktime = param("oktime",	'[1-9][0-9]*',		'5');
$text   = param("text",		'[01]',			1);
$textonly=0+$text;

head("$h ($code) -- info",1,1);
procstate();
?>
<H1>Info</H1>
<?
#$r=q("select a.*,b.* from t_count a,t_log b where a.c_name=b.c_name and a.c_code=b.c_code order by a.c_name");

showtable2($code, "bot", "info-top.php?page=info&amp;host=$h&amp;", "info-bot.php?page=info&amp;host=");

foot();
?>

<?
# $Header: /home/tino/CVSROOT/i2pinproxy/status.php,v 1.2 2008/08/28 10:41:44 tino Exp $
#
# $Log: status.php,v $
# Revision 1.2  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page
#
# Revision 1.1  2008/08/28 09:52:28  tino
# Added

include("showtable2.php");

$search	= param("search",	'[-_.0-9a-z]*');
$code	= param("code",		'[0-9]*',	'200');
$oktime	= param("oktime",	'[1-9][0-9]*',	'5');
$text	= param("text",		'[0-1]');
$hist	= param("hist",         '[-0-9]*',	28);
?>
<meta name="revisit-after" content="12 hours">
<?
$ni	= ($oktime!=5 || $hist!=28 || ( isset($_GET["order"]) && $_GET["order"]!='a.c_name'));
head("($code)",$ni,($ni || $code=='' || substr($code,0,1)=="5"));
?>
<a href="text.php"><img src="_.gif" alt="[text version of this page]" border=0 hspace=0 vspace=0 align=left></a>
<?
showpeerwarning();
?>
<p>
[ <a href="text.php">Text version of this status page</a> ]
<?
if ($text):
  $textonly	= 0+$text;
else:
  $textonly	= ($code=="" || 0+$code==504) ? 1 : 0;
  if ($textonly):
?>
(Automatic <b>text mode</b> to reduce page size.)
<?endif; endif; ?>
</p><p>
<b>The status service is experimental</b>, it still has some bugs, so it might not be accurate.<br>
Destinations listed under 0xx to 4xx are very likely to be reachable by this proxy.<br>
Destinations listed under 5xx and are "very red" are probably down permanently.
</p>

<H2>List of I2P eepsites grouped by code:</H2>
<? flush() ?>
<? showtable2($code, "", "status.php?", "", 28, $oktime); ?>
Best viewed with a browser with full CSS support, like Mozilla Firebird or Opera.
<?
foot();
?>

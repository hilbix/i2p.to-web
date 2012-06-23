<?
# $Header: /home/tino/CVSROOT/i2pinproxy/text.php,v 1.3 2008/09/13 21:56:48 tino Exp $
#
# $Log: text.php,v $
# Revision 1.3  2008/09/13 21:56:48  tino
# For "all" view header text now correct
#
# Revision 1.2  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page
#
# Revision 1.1  2008/08/28 09:52:28  tino
# Added
#

include("showtable2.php");
$textonly=1;

$search	= param("search",	'[-_.0-9a-z]*');
$code	= param("code",		'[0-9]*',	'200');
$oktime	= param("oktime",	'[1-9][0-9]*',	'5');
?>
<meta name="revisit-after" content="2 hours">
<?
$ni	= ($oktime!=5 || isset($_GET["order"]));
head("($code)",$ni,($ni || $code=='' || substr($code,0,1)=="5"));
?>
<p>[ <a href="/">Back</a> ]</p>
<H2>List of I2P eepsites<? if ($code!=""):?> with code <?=$code?> within the last <?=$oktime?> hours<?endif;?>:</H2>
<? showtable2($code, "", "text.php?", "", 28, $oktime); ?>
Footer follows.  Version optimized for text only browsers and access from Internet to I2P.
<?
foot();
?>

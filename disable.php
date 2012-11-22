<?
# $Header: /CVSROOT/www/i2p.to/web/disable.php,v 1.3 2012-05-06 09:32:58 tino Exp $
#
# $Log: disable.php,v $
# Revision 1.3  2012-05-06 09:32:58  tino
# 410 header
#
# Revision 1.2  2008-09-04 17:05:37  tino
# Improved output, hint where to find after installing I2P

include("header.php");
htmlcode(410, "disabled");
head("This site is disabled",1);
showpeerwarning();

$dest = split('/',$_SERVER["PATH_INFO"],3);
?>
<a name="content"></a>

<H1>Site <?=htmlentities($dest[1])?>.i2p not reachable through this I2PinProxy</H1>
<P>
The site you want to access was disabled on request.
<P>
This might be, because the author did not want to be reachable,
or some people have expressed concern about the content of the site.
<P>
Whatever.
<P>
To see this site, <a href="/links.php"><b>please consider installing I2P</b></a>,
and access it through your own eepproxy.
<br>
After installing I2P the resource you are looking for is at:
<br>
<a href="http://<?=htmlentities($dest[1])?>.i2p/<?=htmlentities($dest[2])?>">http://<?=htmlentities($dest[1])?>.i2p/<?=htmlentities($dest[2])?></a>
<P>
Thanks for your understanding.

<?
foot();
#phpinfo();
?>

<?
# $Header: /CVSROOT/www/i2p.to/web/index.php,v 1.4 2009-11-16 16:38:55 tino Exp $
#
# $Log: index.php,v $
# Revision 1.4  2009-11-16 16:38:55  tino
# Improved starting page
#
# Revision 1.3  2008/09/17 18:22:40  tino
# Timeserver link now depends on the requests network type
#
# Revision 1.2  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page

include("header.php");

$search	= param("search",	'[-_.0-9a-z]*');

head("");
?>
<a href="text.php"><img src="_.gif" alt="[Text version of status page]" border=0 hspace=0 vspace=0 align=left></a>
<?
showpeerwarning();
?>
<a name="content"></a>
<div class="border">
<b style="font-size:24pt">Warning!</b>
<b style="font-size:16pt"><A HREF="legals.php">Please read legal notes!</A></b>
<br>The content within I2P sometimes is extremely offending or not suitable for children!
</div>

<h2>Latest (local) news:</h2>
<? shownews(1,"news"); ?>
<div class="border">
<?a("Local time", "http://meine.uhr.geht.net/", "http://www.tino.i2p/meine.uhr.geht.net/")?>
<?=strftime("%Y-%m-%d %H:%M:%S")?> (<?=gmstrftime("%Y-%m-%d %H:%M:%S")?> GMT)
</div>

<h2>Quick links (local):</h2>
<ul><li>
The <a href="status.php">Status</a> link in the menu shows which eepsites (I2P websites) are currently known and reachable
</li><li>
The <a href="graph.php">Graph</a> shows some history how the I2P network (well, only the eepsites as seen from this inProxy) developed over the last years.
</li><li>
Additional <a href="links.php">Links</a> which lead to more information aboout I2P, like how to install I2P and directly access the full I2P network with <a href="bittorrent.php">BitTorrent</a> etc.
</li><li>
And there are <a href="faq.php">FAQs</a> which try to clarify some things about this I2PinProxy.
</li></ul>
<?
#$h=q("select a.*,b.* from t_count a,t_log b where a.c_name=b.c_name and a.c_code=b.c_code order by $order");

foot();
?>

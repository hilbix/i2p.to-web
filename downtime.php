<?
# $Header: /CVSROOT/www/i2p.to/web/downtime.php,v 1.5 2012-05-06 09:33:54 tino Exp $
#
# $Log: downtime.php,v $
# Revision 1.5  2012-05-06 09:33:54  tino
# 503 header
#
# Revision 1.4  2011-05-22 14:05:42  tino
# more help
#
# Revision 1.3  2008/08/28 19:18:28  tino
# New menu structure
#
# Revision 1.2  2008/08/28 10:41:05  tino
# Old URLs to i2p.net disabled

include("header.php");
htmlcode(503, "downtime");
header("Retry-After: 3600");
head("I2Pinproxy currently offline, sorry!");
showpeerwarning();

# PROX references: 1
?>
<a name="content"></a>

<H1>I2PinProxy 404</H1>
<P>
Hint: <b>See the <a href="/links.php">links section</a> for other proxies</b> into the I2P network.
<P>
You see this page because the I2PinProxy encountered a 404 error.
<P>
It may be, that this just is a remote problem, but if this happens
on all pages, this means the I2PinProxy is down.<BR>
In this case it's an unplanned downtime due to technical problems or similar.
<P>
If following link works, I2PinProxy is ok: <a href="http://tino.i2p.<?=$PROX?>/">tino.i2p</a> (my eepsite).
<P>
If it does not work and I am aware of the problem you can see
a <A HREF="downtime.txt">text</A> below:
<TABLE WIDTH="100%" SUMMARY="Note about downtime"><TR><TD class=line0><PRE>
<? readfile("downtime.txt"); ?>
</PRE></TD></TR></TABLE>

If I am aware of the problem, I2PinProxy will be up as soon as possible.  Promised.<br>
Note that this machine is monitored by automated scripts, so major problems will make it to me without help.


<!-- strike>

<H2>Downtimes History</H2>
<P>
There is a Blog (syndiemedia) of downtimes history.  Using Syndiemedia you can comment on my entries, too:
<TABLE SUMMARY="Link list">
<TR><TH>via</TH><TH></TH><TH>basic URL</TH><TH></TH><TH>Description</TH></TR>

<TR CLASS=line0><TD>
<A HREF="http://syndiemedia.i2p.net:8000/threads.jsp?tags=inProxy&amp;author=Spb7kvWimvbRt9pNNy9RLY3NBrBnQqYB~ZUWu9MZLFo=">Internet</A>
</TD><TD>&nbsp;</TD><TD>
<?=l("http://syndiemedia.i2p.net:8000/")?>
</TD><TD>&nbsp;</TD><TD>
Internet access to SyndieMedia
</TD></TR>

<TR CLASS=line1><TD>
<A HREF="http://syndiemedia.i2p/threads.jsp?tags=inProxy&amp;author=Spb7kvWimvbRt9pNNy9RLY3NBrBnQqYB~ZUWu9MZLFo=">I2P</A>
</TD><TD>&nbsp;</TD><TD>
<?=l("http://syndiemedia.i2p/")?>
</TD><TD>&nbsp;</TD><TD>
You need I2P installed for this link to work.
</TD></TR>

<TR CLASS=line0><TD>
your I2P router's <A HREF="http://127.0.0.1:7657/syndie/threads.jsp?tags=inProxy&amp;author=Spb7kvWimvbRt9pNNy9RLY3NBrBnQqYB~ZUWu9MZLFo=">syndie</A>
</TD><TD>&nbsp;</TD><TD>
<?=l("http://127.0.0.1:7657/syndie/")?>
</TD><TD>&nbsp;</TD><TD>
You need I2P installed and must have bookmarked my Blog.
</TD></TR>

<TR CLASS=line1><TD>
my <a href="<?=prox("syndiemedia.i2p")?>threads.jsp?tags=inProxy&amp;author=Spb7kvWimvbRt9pNNy9RLY3NBrBnQqYB~ZUWu9MZLFo=">I2PinProxy</A>
</TD><TD>&nbsp;</TD><TD>
<?=l(prox("syndiemedia.i2p"))?>
</TD><TD>&nbsp;</TD><TD>
Of course this does not work it my I2PinProxy is down
</TD></TR>

<TR CLASS=line0><TD>
jdot's <A HREF="http://i2p.mine.nu/proxy/nph-proxy.cgi/000000A/http/syndiemedia.i2p/threads.jsp?tags=inProxy&amp;author=Spb7kvWimvbRt9pNNy9RLY3NBrBnQqYB~ZUWu9MZLFo=">InProxy</A>
</TD><TD>&nbsp;</TD><TD>
<?=l("http://i2p.mine.nu/proxy/")?>
</TD><TD>&nbsp;</TD><TD>
Access the proxy's <A HREF="http://i2p.mine.nu/proxy/">main page</A>
</TD></TR>
</TABLE>

</strike -->

<?
foot();
?>

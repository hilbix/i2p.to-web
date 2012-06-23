<?
# $Header: /CVSROOT/www/i2p.to/web/closedown.php,v 1.3 2012-05-06 09:31:09 tino Exp $
#
# $Log: closedown.php,v $
# Revision 1.3  2012-05-06 09:31:09  tino
# 403 header
#
# Revision 1.2  2008-08-28 19:18:28  tino
# New menu structure

include("header.php");
header("HTTP/1.0 403 closedown");
head("fproxy blocked due to abuse, sorry!");
procstate();
?>
<br>
<font size="1">[ <A HREF="fproxy.html">Test redirection</A> ]</font>

<a name="content"></a>

<H1>CLOSEDOWN NOTICE</H1>
<P>
Looking through the PoC logs I got the impression, that some
people tried to download underage porn from Freenet,
possibly knowingly.
<P>
I have zero tolerance for this in the current Proof of Concept phase
of my I2P inproxy.
Also I never even thought about that this might happen this quick.
<P>
Therefor I had no choice other than to block access to fproxy.* URLs.
Sorry for the inconvenience, however I know no other way to filter out
this smut.
<P>
Thank you very much for your understanding that I have no other choice
in such a case, so if some want to destroy public services by abusing
them, they do succeed.
Please express your complaints to those folks, not me.  Thanks.
<P>
Please also note, that my I2P based fproxy stays open, only the public
web proxy is affected by the block.  So if you want to access freenet,
<a href="/links.php">please install I2P</a>.
<P>
If you follow the link at my name below, you will find more explaination in
German language, it will also explain the background of this service.
(Well, the text is a rough cut.)

<?
foot();
?>

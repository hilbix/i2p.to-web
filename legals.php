<?
# $Header: /CVSROOT/www/i2p.to/web/legals.php,v 1.3 2009-11-16 16:45:11 tino Exp $
#
# $Log: legals.php,v $
# Revision 1.3  2009-11-16 16:45:11  tino
# Clarified
#
# Revision 1.2  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page
#
# Revision 1.1  2008/08/28 09:52:28  tino
# Added

include("header.php");
head("Legals");
showpeerwarning();

# PROX references: 3
?>

<a name="content"></a>
<H2>Legal notes</H2>

<H3>Content</H3>
<P>
The content within I2P sometimes is extremely offending
and not suitable for children!

<H3>Responsibility</H3>
<P>
Even if the links from this proxy to eepsites (I2P webpages/destinations) are accessible through my computers,

<b>I do not provide any of the contents you can see below the domain
*.i2p.<?=$PROX?></b> (or the old *.i2p.tin0.de),

as I am only operating a public proxy server from one public network
to another.  All this content you see is offered by others, and I have
no possibility to control it.
By <a href="/links.php">installing I2P</a> you can access all this content
without going through my proxy, so my proxy is just someting like a
router from one part of the Internet to another.


<H3>Public Use</H3>
<p>
This proxy is not thought to be an alternative to I2P.  It's not
stable enough.  It is thought to demonstrate how seamlessly I2P can be
integrated into Internet.

Please, if you want to download larger files,
<a href="/links.php">install I2P</A> and do the
downloads directly through I2P.  Installing I2P takes around 5
minutes, and it will speed up everything for you tremendously.

<b>And, more important of course, my proxy does not provide anonymity
like I2P does.</b>

<H3>No illegal things, please</H3>
<P>

If you access illegal things through this proxy, please stop doing it.
<b>This proxy is insecure!</b> It is likely that you are watched!
Better use I2P directly to stay anonymous!

<P>

If I notice to much illegal activity I have to take countermeasures.
This means, probably I am forced to switch this off for a time, until
I manage to fix this problem.

So, please, no activity which can be considered illegal in some
countries.  As it's likely that I must forward this activity to the
authorities.

<P>

Please respect this to keep this service open.  Thanks.

(<a href="http://fproxy.tino.i2p.<?=$PROX?>/">Example of such a
closedown</a> because of illegal activity.)


<H3>Spiders are welcome</H3>
<P>

Spiders of search engines or similar spiders are welcome.

<P>

All other (manually operated or personal) spiders:

Please use I2P directly!  If I see too many spidering requests by
non-search-engines I must take countermeasures.

Please respect this to keep this service open.  Thanks.

<H3>Anonymity notes</H3>
<P>
If you use some anonymity network and this proxy tells you,
you are not anonymous, please don't worry.  This service only
detects a few cases if you use some anonymizers.  For example,
the I2P network once was detected like TOR was.
But not others like AN.ON.
Currently no anonymous network is detected until I manage to
find a way to make a reliable detection.
<P>
Also the opposit is true.  If it says, you are anonymous, this
does not mean you do hide in the crowd.  There might be some
issues with your software which make you identifyable.
<P>
So this information on the top of each page is just a hint to
you and does not tell neccessarily is right.


<H2>Operating notes</H2>
<P>

This service still is in it's early stage (even that it runs over 4 years now).
This means, it's experimental and not considered to be stable nor reliable.
Reliable in networking means, so it shall be a permanent service
of course.
<P>
This service now operates as i2p.<?=$PROX?> which is better suited to this
as my old i2p.tin0.de.  However, i2p.tin0.de still will be dedicated
to this Proxy service in future, so you need not have any fear old
links break.
<P>
Some promises which I want to keep:
<UL>
<LI> If nothing evil happens, this service will not be shut down.
     Evil things include running out of money, court orders, lethal accidents,
     major earth wide disasters or somebody accidentially deleting this universe.
<LI> If something evil happens I will try to hand over this service
     to others.  It's surprisingly easy to implement and to run.
<LI> I am willing to cooperate with others.  If somebody else wants to
     dedicate bandwidth to the InProxy (it is below 100 GB/month)
     I would be happy to add the IP of the other InProxy to my
     DNS round robin list.
</UL>


<?
foot();
?>

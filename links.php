<?
# $Header: /CVSROOT/www/i2p.to/web/links.php,v 1.2 2011-05-22 14:11:32 tino Exp $
#
# $Log: links.php,v $
# Revision 1.2  2011-05-22 14:11:32  tino
# Other inproxies added
#
# Revision 1.1  2008/08/28 09:52:28  tino
# Added
#

include("header.php");
head("Links");
procstate();

# PROX references: 1
?>
<P>
(English below)
<H2>Links zu weiteren Informationen</H2>
<UL>
<li> <?=l("http://www.planetpeer.de/wiki/index.php/Das_deutsche_I2P-Handbuch")?> I2P Handbuch von Planetpeer</li>
<li> <?=l("http://permalink.de/tino/i2p-faq-de")?> meine inoffizielle I2P-FAQ</li>
</UL>

(Now in English:)
<a name="content"></a>
<H2>Other I2PinProxies</H2>
<ul>
<li> Germany Privacy Foundation e.V. <a href="https://www.awxcnx.de/">https://www.awxcnx.de/</a> supports SSL.<br>
     This proxy can be reached as <a href="http://awxcnx.i2p.to/">http://awxcnx.i2p.to/</a> via plain HTTP as well (this is a DNS forward, so it works even if this proxy here is down)<br>
     and as <a href="http://awxcnx.i2p/">http://awxcnx.i2p/</a> from within I2P.  It also is a TOR hidden service.
<li> I will add more if you tell me the URL.
</ul>

<H2>Install I2P</H2>
<p>
Be sure that you have <a href="http://java.com/en/download/">a recent Java installed</a>!
I2P runs in the Java Virtual Machine.
<p>
<span class="trouble"><A HREF="http://www.i2p2.de/download.html"><b><span style="text-decoration:blink">Click</span> here</b> to download I2P!</A></span>
(alternate download links:
<a href="http://www.i2p-projekt.de/download">1</a>
<a href="http://code.google.com/p/i2p/downloads/list">2</a>
<!-- a href="mirror/dev.i2p.net/i2p/i2pinstall.exe">1</a>
<a href="mirror/dev.i2p.tin0.de/i2p/i2pinstall.exe">2</a>
<a href="http://dev.i2p.<?=$PROX?>/i2p/i2pinstall.exe">3</a -->,
see also <a href="mirror.php">mirror page</a> for Linux and help)
<p>
With <A HREF="http://www.i2p2.de/download">I2P installed</A> you can <b>access even more</b> what is offered with this proxy!
I2P is free and open source software.

<H2>Links to other sites (mostly English)</H2>
<P>
These links are considered to be helpful.

<H3>Web only links</H3>
<UL>
<LI> Of course:
     <A HREF="http://www.i2p2.de/">I2P</A> (<a href="http://www.i2p.net/">old, no more working</a>)
     <A HREF="http://forum.i2p2.de/">forum</A> (<a href="http://forum.i2p.net/">old, no more working</a>)
     <!-- A HREF="http://dev.i2p.net/">dev</A>
     <A HREF="http://syndiemedia.i2p.net/">SyndieMedia</A -->

<LI> My (tino's) announcements:
     <A HREF="http://forum.i2p2.de/viewtopic.php?t=979">eepsites</A>
     and <A HREF="http://forum.i2p2.de/viewtopic.php?t=1006">this proxy</A>

<li> <a href="http://awxcnx.de/tor-i2p-proxy2.htm">CGI based InProxy</a> to I2P
     operated by <a href="http://www.privacyfoundation.de/">GPF e.V.</a> (Germany)
<!-- LI> <A HREF="http://i2p.mine.nu/proxy/">CGI based InProxy</A> to I2P
     operated by <A HREF="http://forum.i2p.net/viewtopic.php?t=564">jdot</A -->

<!-- LI> I2P wiki:
     <A HREF="http://ugha.ath.cx/">Ugha</A -->

<LI> Eepsites search engine:
     <A HREF="http://eepsites.com/">eepsites.com</A> also reachable as
     <A HREF="http://eepsites.i2p/">eepsites.i2p</A><BR>
     Has a nice <A HREF="http://www.eepsite.com/Content/HowTo/Setup_I2P_Win.htm">I2P install guide</A> for Windows.
</UL>

<H3>Links into the I2P network</H3>
<UL>
<LI>Other I2P Site Monitors
    <strike><a href="<?=prox("orion.i2p")?>list/reliable/?lastuptime">orion.i2p</A> (down)</strike>
    <a href="<?=prox("polecat.i2p")?>i2psurvey/">polecat.i2p</A>
    <a href="<?=prox("stats.i2p")?>">stats.i2p</A>

<LI> Search engines:
    <a href="<?=prox("search.i2p")?>">search.i2p</A>
    <a href="<?=prox("eepsites.i2p")?>">eepsites.i2p</A>
</UL>
<?
foot();
?>

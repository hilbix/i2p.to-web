<?
# $Header: /home/tino/CVSROOT/i2pinproxy/mirror.php,v 1.1 2008/08/28 09:52:28 tino Exp $
#
# $Log: mirror.php,v $
# Revision 1.1  2008/08/28 09:52:28  tino
# Added
#

include("header.php");
head("Mirror");
showpeerwarning();
?>
<a name="content"></a>

<H2>Install I2P</H2>
<P>
To download I2P see the <a href="links.php">Links page</a>, there are several download links, one shall work.
<p>
If you have problems seeding (no peers show up and the reseed feature of the router does not work) using the reseed button of your router:
<UL>
<LI> Try to <a href="http://www.i2p2.de/download">update your router</a> to the latest version (scroll down the page to the manual update procedure).
<LI> If you have already the latest version, try to sync manually (usually not needed on the newest version):
<LI> Stop your router
<LI> Download my zipped <b>routerInfo</b> files from
     <a href="http://i2pdb.tin0.de/">http://i2pdb.tin0.de/</a>.
<LI> Unpack this ZIP file into the i2p/netDb/ directory.
<LI> Then start your router again.
<LI> If still no peers show up, be sure that your firewall allows the UDP protocol and you can create TCP connections to the Internet.
     (Being able to surf the WWW does not mean you are really freely connected to the Internet.)
     Sorry, I cannot help with firewall settings or Internet connection problems.
</UL>

<H2>My I2P mirror now is deprecated</H2>
<P>
Sorry, currently my mirror only has old install files online.
This is due to the recent changes in the I2P homepage.
Perhaps I will bring it online again, perhaps not.
So long you will find only old install files here.
<strike>
<H2>I2P mirror</H2>
<P>
If i2p.net does not work for you I have all neccessary install files <A HREF="mirror/">mirrored on my site</A>.
This is a daily automatic process.  But remember, <b>automated processes can fail</b>.
<P>
<B>Important:</B>
Do not trust me, check the signatures you find on
<A HREF="http://www.i2p.net/download">the I2P homepage</A> and/or the sig-files in the mirror.
To check the signatures you probably need <a href="http://www.gnupg.org/">GnuPG</a>.

<H3>Mirrored links</H3>
<UL>
<LI> <a href="mirror/dev.i2p.net/i2p/">Download directory</a> and <a href="mirror/dev.i2p.tin0.de/i2p/">alternate download directory</a>
<LI> <A HREF="mirror/dev.i2p.net/i2p/i2pinstall.exe">i2pinstall.exe</A>
     (<a href="mirror/dev.i2p.net/i2p/i2pinstall.exe.sig">sig</a>)
     Graphic installer for Windows
     or Linux (<SPAN class=nobr><TT>java -jar i2pinstall.exe</TT></SPAN>)

<LI> <A HREF="mirror/dev.i2p.net/i2p/i2p.tar.bz2">i2p.tar.bz2</A>
     (<a href="mirror/dev.i2p.net/i2p/i2p.tar.bz2.sig">sig</a>)
     can be installed according to my instructions at
     <A HREF="http://permalink.de/tino/i2p-inst">http://permalink.de/tino/i2p-inst</A>

<LI> <A HREF="mirror/dev.i2p.net/i2p/i2pupdate.zip">i2pupdate.zip</A>
     (<a href="mirror/dev.i2p.net/i2p/i2pupdate.zip.sig">sig</a>)
     This updates any older I2P installation to the current one.

<LI> <A HREF="mirror/dev.i2p.net/i2p/hosts.txt">hosts.txt</A>
     Latest hosts.txt mirrored from the official site.
</UL>
</strike>
<?
foot();
?>

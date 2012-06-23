<?
# $Header: /home/tino/CVSROOT/i2pinproxy/bittorrent.php,v 1.2 2008/09/17 18:22:12 tino Exp $
#
# $Log: bittorrent.php,v $
# Revision 1.2  2008/09/17 18:22:12  tino
# Install link corrected
#
# Revision 1.1  2008/08/28 09:52:27  tino
# Added
#

include("header.php");

head("BitTorrent");
procstate();
?>
<a name="content"></a>

<H2>For I2P based BitTorrent (AnonBT) you need I2P installed</H2>
<P>
Since 0.6.1.8 there is <A HREF="http://127.0.0.1:7657/i2psnark/">I2Psnark</A> in the router console.
So there is no hassle to do BitTorrent downloads from within I2P any more.
<UL>
<LI> <A HREF="/links.php">install I2P</A> and have it running correctly.
<LI> Point your browser to <A HREF="http://127.0.0.1:7657/i2psnark/">http://127.0.0.1:7657/i2psnark/</A>
<LI> Or download the .torrent file into the directory you see on the I2Psnark-page (right below the box of torrents)
<LI> (Note that Copy&amp;Paste the URL of the .torrent into the Box and press "Add torrent" does not work for me in a reliable way.)
</UL>
Yes, it's that easy now:
<UL>
<LI> I2Psnark supports zillions of .torrents to download in parallel.
<LI> I2Psnark automatically starts up with your I2P router. (It needs some while until it is running, though.)
<LI> I2Psnark runs stable and reliable like your I2P router (as it's part of it).
</UL>

<h3>A good place to start</h3>
<ul>
   <li> <a href="<?=prox("tracker.postman.i2p")?>">tracker.postman.i2p</a></li>
   <!-- li> <a href="<?=prox("orion.i2p")?>bt/">tracker of orion.i2p</a><br />
        Note that orion.i2p is nearly always reachable, but the tracker is only an addon, so it's a little bit orphaned.</li -->
   <li> (I will be happy to include other trackers if they prove to be reliable.  In future you can add your own tracker here automatically.  I will tell how on this pages.)</li>
</ul>

<?
foot();
?>

<?
# $Header: /CVSROOT/www/i2p.to/web/blocked.php,v 1.7 2012-05-06 09:30:19 tino Exp $
#
# $Log: blocked.php,v $
# Revision 1.7  2012-05-06 09:30:19  tino
# 503 header
#
# Revision 1.6  2010-08-11 06:01:35  tino
# Current version
#
# Revision 1.5  2009-11-16 16:05:40  tino
# More information
#
# Revision 1.4  2009-01-26 13:43:09  tino
# b32.i2p blocked
#
# Revision 1.3  2008/09/04 17:05:19  tino
# Minor changes
#
# Revision 1.2  2008/08/28 19:18:28  tino
# New menu structure

include("header.php");
header("HTTP/1.0 503 Temporary block");
header("Retry-After: 1000");
head("request blocked by proxy",1);

$dest = substr($_SERVER["PATH_INFO"],1);
$first= substr($dest,0,1);

# PROX references: 3
?>
<? if ($first=="i"):
     showpeerwarning();
?>
<H1>Request temporarily blocked by IP block</H1>
<? elseif ($first=="d"):
     showpeerwarning();
?>
<H1>Request temporarily blocked by a destination block</H1>
<? else:
     procstate();
?>
<br>
<font size="1">[ <A HREF="/blocked.php/i/">Test IP lock</A>
| <A HREF="/blocked.php/d/">Test Destination lock</A>
| <A HREF="<?=prox("tino.i2p")?>blocktest.html">Test destination (works if not blocked)</A>
]</font>
<? showpeerwarningimp(); ?>
<p>
<b>(if you called this page directly this is a test output)</b>
<H1>Request temporarily blocked (unknown reason)</H1>
<? endif; ?>
<a name="content"></a>
<p>
<?
if ($db=dba_open("/home/tino/etc/i2p-blockip.dbm.map", "r", "gdbm")):
  if (!dba_exists($_SERVER["REMOTE_ADDR"], $db)):
?>
<div class="green"><b>You are not blocked.</b></div>
<?
  else:
    $n=dba_fetch($_SERVER["REMOTE_ADDR"], $db);
    if (!$n && ".$n."!=".0.")
      $n	= "unknown";
    if ($n==1):
?>
<div class="red"><b>Your IP is blocked for one more minute or so.</b></div>
<?
    else:
?>
<div class="red"><b>Your IP is blocked for <?=$n?> minutes!</b></div>
<?
    endif;
  endif;
  dba_close($db);
else:
?>
<div class="yellow"><b>Cannot access block DB.  (Hint: reload this page should fix this)</b></div>
<?endif?>
</p>
<P>
I am sorry, but your request was blocked by this proxy as a temporary countermeasure against
too high resource consumption.  If you are puzzled why this block affects you,
try to do slower what you do, as you are doing things too fast.
<ul>
<li> My machine only has very limited resources and will block you if it becomes
     overwhelmed by requests.
<li> Never do more than 5 connects in parallel.  Best is never do more than 1 connect in parallel.
<li> Never do more than 1 connect per 10 seconds.
     Best is to wait 1 minute after a request failed.
     If you cannot limit the number of connects per second,
     do no more than 1 connects in parallel.
<li> Set your timeout to 1 hour.  If you are not able to set the timeout so high,
     lower your retry limit to 5 retries or less.
<li> Never try to download single files in several chunks in parallel.
     So always configure your downloader to download complete files.
     If you do not succeed through this proxy, <b>install I2P</b> and try it directly.
<li> Note that I am not aware of any downloader which is capable to restart a broken
     download properly, as the last few bytes (1 KB or so) of the previous download
     can be garbled, so the restarted download must interleave (it must download
     the last few bytes again).  This usually leaves you with broken files.
     If you have trouble this way, consider <b>installing I2P</b>,
     as only this way your downloader can directly interface with I2P.
</ul>
<b>Exceeding above limits likely blocks you.  This block is automatic.</b>

<H2>The block is only of temporary nature</H2>
<P>
This block will vanish automatically when you stop your immense resource usage.
Above there is printed how long you are blocked.  Wait this time, do not access this proxy
again (this includes: Do not reload this page!).  Wait half an hour longer to let the system here
time to lift the block again, then try again.
However I cannot predict exactly when the block is lifted.  If a lot of resources are still consumed in
this proxy service, the block can stay a really long time.

<H2>How to speedup things</H2>
<P>
This proxy service itself does not provide any data.  It only fetches the data from the I2P
network and hands it to people, who this way do not need to have I2P running locally.
If you want to access the I2P network directly, all you need to do is to
<a href="/links.php">download and install the I2P router software</a>
and you can start accessing everything without this proxy.  This is all you can see
over this proxy and a lot more like anonymous IRC!  Also, a direct access to I2P usually
is a lot faster than going through my proxy (and it is more reliable, too).
<P>
Please note that I2P comes for free.  All you need is a recent Java installed to run it.
I2P is portable, open source and absolutely free software (free like in free speech and free
like in free beer).

<H2>How to find the resources in the I2P network</H2>
<P>
This proxy here does something very simple.  If it gets a request to
<b>http://DESTINATION.<?=$PROX?>/SOMEPATH</b>
it takes the data from the I2P network by accessing
<b>http://DESTINATION/SOMEPATH</b> (which only is accessible using the I2P router software).
<P>
Note that a DESTINATION always ends in .i2p, hence every URL looks like
http://<b>EEPSITE.i2p</b>.<?=$PROX?>/SOMEPATH
but the .i2p already is part of the I2P destination.
<P>
So if you are puzzled where you can find in I2P what you saw here,
just remove the <b>.<?=$PROX?></b> from the Host part in the URL and you will find it again when
you use your own I2P router. (Note that there also is <b>.tin0.de</b>)
<P>
However setting up I2P isn't so easy if you do not know how to edit the proxy setting of your browser.
So if it's too complicated for you to find out how to do this, you can continue to use my proxy.
However things go slow motion then.  As if you are too fast, you get blocked.  HTH.

<H2>Why your request was blocked</H2>
<P>
This proxy here is thought for search engines (which are incapable of I2P) and as an option
to access I2P eepsites via links from ordinary websites.  (FYI, eepsite is a website within I2P.)
It is not thought to provide huge downloads from I2P.
<P>
This machine currently only opens 150 parallel sessions into I2P.
If somebody uses a downloader with 10 sessions or more in parallel, the complete machine
capacity is quickly used up (this is because many connects time out which then still occupy
a session for quite a time).  So to be able to keep up the service to the public,
this machine must block IPs and destinations with a too high resource consumption rate.

<H2>Thank you for your understanding</H2>
<P>
Note that you always can start using I2P directly to get rid of this proxy.
So <b>blocking you shall help you</b> to note that there probably is a better way for you to
access I2P data.  Also it allows others to continue to access I2P via this proxy undisturbed.
<P>
Also please note that <b>you cannot evade the block by changing your IP</b>!  The block then only
kicks in faster, as this service here already was overloaded by you and the blocking condition
becomes tighter.  All you can do is to DoS this service such that it blocks all connections until
you stop your abuse, however this will not help you to overcome the block, as you will be
blocked, too.
<P>
-Tino

<?
foot();
flush();
if ($n<30)
  sleep(3);
else if ($n<120)
  usleep(500000);
?>

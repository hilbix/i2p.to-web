<?
# $Header: /CVSROOT/www/i2p.to/web/overload.php,v 1.1 2012-05-06 09:45:27 tino Exp $
#
# $Log: overload.php,v $
# Revision 1.1  2012-05-06 09:45:27  tino
# added
#

include("header.php");
header("HTTP/1.0 503 Temporary block");
header("Retry-After: 90");
head("proxy temporarily overloaded",1);

$dest = substr($_SERVER["PATH_INFO"],1);
$first= substr($dest,0,1);
?>
<? if ($first=="i"):
     showpeerwarning();
?>
<H1>Proxy temporarily overloaded</H1>
<? else:
     procstate();
?>
<br>
<font size="1">[ <A HREF="/overload.php/">Test Overload</A>
]</font>
<? showpeerwarningimp(); ?>
<p>
<b>(if you called this page directly this is a test output)</b>
<H1>Temporary overload</H1>
<? endif; ?>
<a name="content"></a>
<ul>
<li> This proxy is currently swamped by too many requests. </li>
<li> In this situation the proxy rejects all requests automatically until the other defense systems kick in and block the culprit. </li>
<li> This is the third line of defense against people out there who act irresponsibly, do not play nice and apparently want to harm others. </li>
<li> Those people try to eat up all resources on this machine here using trainloads of different IPs doing only so much requests that they are not blocked. </li>
<li> Differently said, they apparently put a lot of effort into it to harm other people. </li>
<li> I doubt they will learn, ever.  Hence this (new) countermeasure kicks in within fractions of a second, to stop them and protect this service. </li>
<li> Sadly this affects all people using this service here.  Not only the evil ones. </li>
<li> I am very sorry if this harms you, but I cannot help. </li>
</ul>
<?
foot();
flush();
if ($n<30)
  sleep(3);
else if ($n<120)
  usleep(500000);
?>

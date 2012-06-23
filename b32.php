<?
# $Header: /CVSROOT/www/i2p.to/web/b32.php,v 1.2 2012-05-06 09:29:33 tino Exp $
#
# $Log: b32.php,v $
# Revision 1.2  2012-05-06 09:29:33  tino
# 403 header
#
# Revision 1.1  2009-01-26 13:43:41  tino
# b32.i2p blocked

include("header.php");
header("HTTP/1.0 403 not allowed");
head("b32.i2p addresses are not reachable",1);
showpeerwarning();

$dest = substr($_SERVER["PATH_INFO"],1);
?>
<a name="content"></a>
<h1>.b32.i2p destinations are not reachable for now</h1>
<p>
You tried to reach <a href="http://<?=htmlentities($dest)?>">http://<?=htmlentities($dest)?></a>, but this is not supported for now.
If you like you can consider this to be a bug.
<ul>
<li> I2P version 0.7 started to provide a direct way to access I2P destinations using a .b32.i2p hash address.
<li> This inProxy has a way to block certain destinations due to several causes (for example: The eepsite owner does not want to be reachable).
<li> This blocking currently is based on the I2P name, as there was no other way to do it previously.
<li> As .b32.i2p addresses are not directly associated to eepsite names, such that you can contact any destination within I2P,
this feature is beyond what was planned for this inProxy, and therefor I decided to disable this feature until I have resolved this issue.
<li> To support it I have to rewrite major portions of all the code used for this gateway here.
<li> Hopefully in some future I will start to support this types of destinations.
</ul>
<p>
If you need access to such an URL today, please consider following:
<ul>
<li> <a href="/links.php">Install I2P</a> and configure your browser's proxy to use I2P and access <a href="http://<?=htmlentities($dest)?>">http://<?=htmlentities($dest)?></a> directly.
<li> Find out the name used for this destination, and replace the hostname by the eepsite's name and try again.
</ul>
<p>
I am afraid I have no other solution to this yet.  The planned proper future solution can be found in the <a href="/faq.php">FAQ</a>.
<?
foot();
?>

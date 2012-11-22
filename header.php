<?
# $Header: /CVSROOT/www/i2p.to/web/header.php,v 1.13 2011-05-22 14:11:11 tino Exp $
#
# $Log: header.php,v $
# Revision 1.13  2011-05-22 14:11:11  tino
# FAQ moved up into main menu
#
# Revision 1.12  2010-08-11 06:01:36  tino
# Current version
#
# Revision 1.11  2009-11-16 16:07:44  tino
# Advertisement added ;)
#
# Revision 1.10  2009-01-26 13:43:09  tino
# b32.i2p blocked
#
# Revision 1.9  2009-01-26 07:58:09  tino
# FAQ added
#
# Revision 1.8  2008/09/17 18:24:12  tino
# Link according to the network type.
# REFERER not printed if not set.
#
# Revision 1.7  2008/09/13 22:16:31  tino
# Removed graphics if comming from I2P
#
# Revision 1.6  2008/09/13 21:25:13  tino
# Added qh() to query history table.  Also showtable now no more relies
# on the t_stat table, except for showing the real history entries.
#
# Revision 1.5  2008/08/28 19:18:28  tino
# New menu structure
#
# Revision 1.4  2008/08/28 11:29:00  tino
# Bugfix now noted in News.
#
# Revision 1.3  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page

# PROX references: 4

$advert='<div class="ad">Schlie&szlig;lich ist die Freiheit nicht umsonst: (Anzeige Stand 2009-07-01)<br>Der <a href="http://valentin.hilbig.de/">Entwickler und Betreiber dieses Proxys</a> sucht neue Auftr&auml;ge! Siebel, Unix, Datenbanken, Internet, Programmierung.<br>Auch deutsch- und englischsprachiges Ausland, Verf&uuml;gbarkeit asap! (<a href="http://www.gulp.de/Profil/vh106.html">Gulp Profil</a>)</div>';
$advert='';

ob_start();
$htmlCode = 200;
function htmlcode($code, $what)
{
GLOBAL $htmlCode;
$htmlCode=$code;
header("HTTP/1.0 $code $what");
}

# Domain to add to the I2P destination, with the DOT but without the trailing DOT
# Call with a name ending on .i2p
# Creates http://I2PNAME.whatever/
$PROX="to";
function prox($i2pname)
{
  GLOBAL $isanon, $PROX;

  if (!$isanon)
    return "http://$i2pname.$PROX/";
  if ($i2pname=="i2p")
    return "http://inproxy.tino.i2p/";
  return "http://$i2pname/";
}

# 1:ugly message
# -1:db down and ugly message
# -2:only db down
$working=0;
$version=preg_replace('|^[^ ]* ([0-9]*)/([0-9]*)/([0-9]*) .*$|', '$1-$2-$3', '$Date: 2011-05-22 14:11:11 $');
$have_frames=0;
$textonly=0;
$isanon=0;	// 0:no, 1:probably, 2:very likely, 3:yes

$startmicro = microtime(TRUE);
$startusage = getrusage();

$peertype = array(
 '66.111.51.110'=>1
,'81.169.183.36'=>1
#,'62.75.246.186'=>2	// s4f3
,'85.25.147.197'=>2	// s4f3b
,'217.160.107.151'=>2	// ns3
);

if (isset($peertype[$_SERVER['REMOTE_ADDR']]))
  $isanon= ( $peertype[$_SERVER['REMOTE_ADDR']]==1 ? 1 : 2 );
if (preg_match('|\.i2p$|', $_SERVER['SERVER_NAME']))
  $isanon=3;
 
$urls = array(
	'index.php'		=> 'Home'
,	'status.php'		=> 'Status'
,	'graph.php'		=> 'Graph'
,	'faq.php'		=> 'FAQ'
,	'links.php'		=> 'Links'
,	'menu.php'		=> 'More..'
,	1			=> 'Information'
,	'legals.php'		=> 'Legals'
,	'news.php'		=> 'News&amp;Bugs'
,	'bittorrent.php'	=> 'BitTorrent'
,	'mirror.php'		=> 'Mirror'
,	2			=> 'Administrative'
,	'b32.php'		=> 'Unsupported'
,	'blocked.php'		=> 'Blocked'
,	'downtime.php'		=> 'Downtime'
,	'timeout.php'		=> 'Timeout'
,	'closedown.php'		=> 'Closedown'
,	'disable.php'		=> 'Disabled'
);

$valid = array('0'=>'x','1'=>'x','2'=>'o','3'=>'o','4'=>'x');
$colorclass = array('x'=>'yellow','o'=>'green','.'=>'red');
#$color = array(''=>'#888888', 'x'=>'#ffff00','o'=>'#00ff00','.'=>'#ff0000','0'=>'#ffffff','1'=>'#dddddd');
$color = array(''=>'8', 'x'=>'y','o'=>'g','.'=>'r','0'=>'f','1'=>'d');

function l($a)
{
?>
<a href="<?=htmlentities($a)?>"><?=htmlentities($a)?></a>
<?
}

function l2($a, $href, $i2p="")
{
  a(htmlentities($a),$href,$i2p);
}

function a($a,$href,$i2p="")
{
  GLOBAL $isanon;

  if ($isanon && $i2p!="")
    $href	= $i2p;
?>
<a href="<?=htmlentities($href)?>"><?=$a?></a>
<?
}

function text($only, $else)
{
  GLOBAL $textonly;

  echo $textonly ? $only : $else;
}

function colorcode($b)
{
  GLOBAL $valid;

  $b=substr($b,0,1);
  if (isset($valid[$b]))
    return $valid[$b];
  return ".";
}

function tor($ip)
{
  $ip=sqlite_escape_string($ip);
  $db=@sqlite_open("ip/ip.sqlite", 0544);
  if (!$db) return 0;
  sqlite_busy_timeout($db, 1000);
  $q=sqlite_query($db, "select c_tor from t_ip where c_ip='$ip'");
  if (!$q || !sqlite_has_more($q))
    {
      sqlite_query($db, "insert or ignore into t_ip (c_ip,c_tor,c_count,c_timestamp) values ('$ip',0,0,datetime('now'))");
      return 0;
    }
  $r	= sqlite_fetch_single($q);
  sqlite_query($db, "update t_ip set c_timestamp=datetime('now'),c_count=c_count+1 where c_ip='$ip'");
  return $r;
}

function doq($nam, $s, $single, $tmout=10000)
{
  GLOBAL $working;
  if ($working<0)
    return array();
  $db=@sqlite_open("stat/$nam.sqlite", 0444);
  if (!$db) die("cannot open DB $nam");
  sqlite_busy_timeout($db, $tmout);
  if ($single)
#    $r=sqlite_single_query($db,$s);
    {
      $r=array();
      $q=sqlite_query($db, $s);
      while (sqlite_has_more($q))
        $r[]	= sqlite_fetch_single($q);
    }
  else
    $r=sqlite_array_query($db,$s);
  @sqlite_close($db);
  reset($r);
  return $r;
}

function q($s, $single=0)
{
  return doq("stat", $s, $single);
}

function qh($s, $single=0)
{
  return doq("hist", $s, $single, 1);
}

function head($head,$noindex=0,$nofollow=0,$frameset=0,$cgi=0)
{
  GLOBAL $working, $have_frames, $textonly, $headerflags;

  $headerflags = sprintf("%d%d", $noindex, $nofollow);

  $hinf	= ob_get_contents();
  ob_end_clean();
  $have_frames=$frameset;
  if ($cgi)
    {
      header("Pragma: no-cache");
      header("Expires: 0");
      header("Cache-control: no-store,no-cache,max-age=0,must-revalidate");
    }
  if ($have_frames):
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<? else: ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<? endif; ?>
<html>
<head>
<title><?=htmlentities($head)?> -- I2PinProxy</title>
<link rel="stylesheet" type="text/css" href="/css.css">
<meta name="ROBOTS" content="<?if($noindex) echo "NO"?>INDEX,<?if($nofollow) echo "NO"?>FOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<? if (!$have_frames) echo $hinf; ?>
<base target="_top">
</head>
<? if ($have_frames): ?>
<?=$hinf?>
<noframes>
<? else: ?>
<body>
<a href="#content"><img src="/_.gif" alt="[jump to content]" border=0 hspace=0 vspace=0 align=left></a>
<? endif; ?>
<? if ($working&1): ?>
<? if ($textonly): ?>
<div><b>Warning: I am currently working on this pages, expect bugs!</b></div>
<? else: ?>
<div title='This warning is meant to be ugly as hell.'
     style='border:5px double green; color:blue; text-align:center; background-color:red'>
&#x2502;&#x263a;&#x251c;&#x2500;&#x2500;&#x2591;&#x2592;&#x2593;<blink>&#x2588;</blink>&#x2593;&#x2592;&#x2591;&#x2500;&#x2500;&#x2500;&#x2500;
<b>I am currently working on this pages, expect downtimes and bugs</b>
&#x2500;&#x2500;&#x2500;&#x2500;&#x2591;&#x2592;&#x2593;<blink>&#x2588;</blink>&#x2593;&#x2592;&#x2591;&#x2500;&#x2500;&#x2524;&#x263a;&#x2502;
</div>
<?
  endif;
  endif;
  flush();
}

function menu($sect=0)
{
  GLOBAL $urls, $PROX;

  $c	= '[';
  if ($sect>0)
    {
      echo "<br>";
      echo $urls[$sect];
      echo ": ";
      $c	= "";
    }
  $me	= substr($_SERVER["SCRIPT_NAME"],1);
  $found= 0;
  $area	= 0;
  for (reset($urls); list($k,$v)=each($urls); )
    if (is_numeric($k))
      $area	= $k;
    else if ($k==$me)
      $found	= $area;
  reset($urls);
  while (list($k,$v)=each($urls))
    {
      if (is_numeric($k))
        {
          if ($sect==$k)
	    $c="[";
	  else
	    {
	      if (!$sect)
		break;
	      $c	= "";
	    }
	  continue;
        }
      else if ($c=="")
	continue;
      else if ($me==$k)
        echo "$c $v ";
# This is for transitioning old domains to the PROX URL.
      else if (substr($_SERVER["SERVER_NAME"],-4)!=".i2p" && $_SERVER["SERVER_NAME"]!="i2p.$PROX")
        echo "$c <a target='_top' href=\"".prox("i2p")."$k\">$v</a> ";
      else
        echo "$c <a target='_top' href=\"/$k\">$v</a> ";
      $c	= '|';
    }
  echo "]\n";
  if ($sect<=0)
    {
      if ($found)
        {
#	  echo "| $v ]\n";
          menu($found);
	  return;
        }
      else if ($sect<0)
        {
          for ($found=1; $found<=$area; $found++)
            menu($found);
          return;
        }
    }
}

function procstate($showmenu=1)
{
  GLOBAL $working;

  $router	= file_exists("BACKUPROUTER") ? "I2P router2" : "I2P router1";
?>
<table cellspacing="0" cellpadding="0" align="right" summary="Table shows state of internal processes">
<tr><th>Process</th><th>run</th><th>@</th><th>status</th></tr>
<!--STATE-->
<?
  $p	= q("select strftime('%s', 'now')-strftime('%s', c_starttime) delta, (c_timestamp<datetime('now')) warn,(c_timestamp<datetime('now','-5 minutes')) err,* from t_proc order by c_name,c_state");
  $r	= array();
  for ($line=0; list($k,$v)=each($p); $line=1-$line):
    $t=$v["c_state"];
    $at=$v["c_at"];
    $c="g";
    if ($v["err"])
      {
        $c="r";
	$t="down: $t";
      }
    else if ($v["warn"])
      {
        $c="y";
	$t="down? $t";
      }
    else if (substr($at,0,2)=="E ")
      {
        $c="r";
	$at=substr($at,2);
      }
    else if (substr($at,0,2)=="W ")
      {
        $c="y";
	$at=substr($at,2);
      }
    $r[$v["c_name"]]=$c;
?>
<tr class="line<?=$line?>"><??>
<? if ($v["c_name"]==$router): ?>
<td class="data"><b><?=$v["c_name"]?></b></td><??>
<? else: ?>
<td class="data"><?=$v["c_name"]?></td><??>
<? endif ?>
<td class="data<?=$c?>" align="right"> <?=$v["delta"]-$v["c_seconds"]?> </td><??>
<td class="data"><?=$at?></td><??>
<td class="data"><?=htmlentities($t)?></td><??>
</tr>
<? endfor; ?>
<?
  if ($working<0)
    echo '<tr><td colspan="4" align="center" bgcolor="#ff8080"><b>Database offline</b></td></tr>';
?>
<!--ENDSTATE-->
</table>
<?
if ($showmenu)
  menu($showmenu-1);
if ($r[$router]=="r")
  echo "<div class='trouble'>I2P router currently down!</div>\n";
if (file_exists("MESSAGE.txt"))
  {
    echo "<div class='trouble'>";
    readfile("MESSAGE.txt");
    echo "</div>\n";
  }
}

function mklink($opts, $val, $set)
{
  $t	= "";
  $a	= $opts["args"];
  reset($a);
  for ($s=""; list($k,$v)=each($a); $s="&amp;")
    {
      if ($k==$val)
        $v	= $set;
      $t	.= "$s$k=$v";
    }
  return $t;
}

function ll($opts, $sign, $val, $set)
{
  if ($opts["args"][$val]==$set):
?><b><?=$sign?></b><?
  else:
?><a href="<?=$opts["choose"]?><?=mklink($opts, $val, $set)?>"><?=$sign?></a><?
  endif;
}

function ol($opts, $sign, $val, $set)
{
  if ($opts["args"][$val]==$set):
?><span class="ordinv"><?=$sign?></span><?
  else:
?><a class="ord" href="<?=$opts["choose"]?><?=mklink($opts, $val, $set)?>" rel="nofollow"><?=$sign?></a><?
  endif;
}

function oh($opts, $key)
{
#  echo $key;
  if (!isset($opts["ords"][$key]))
    return;
#  echo " ";
  ol($opts, "&#x25b2;", "order", strtolower($opts["ords"][$key]));
  ol($opts, "&#x25bc;", "order", strtoupper($opts["ords"][$key]));
}

function showpeerwarningimp()
{
  GLOBAL $peertype, $advert;

  echo $advert;
?>
<h5>
<? if (isset($peertype[$_SERVER['REMOTE_ADDR']]) && $peertype[$_SERVER['REMOTE_ADDR']]==1): ?>
You came over an I2P outproxy, you are anonymous, very likely.
<? else: ?>
<? if (isset($peertype[$_SERVER['REMOTE_ADDR']])): ?>
You came over my I2P router tunnel,
<? else: ?>
Your IP is <?=$_SERVER['REMOTE_ADDR']?>,
<? endif; ?>
<? if (preg_match('|\.i2p$|', $_SERVER['SERVER_NAME'])): ?>
you are anonymous or using some I2P Proxy
<?
#elseif (($tor=tor($_SERVER['REMOTE_ADDR']))==0): 
#your TOR state is unknown yet, <i><u>your anonymity state is not yet known</u></i>
# elseif ($tor==1): 
#which is a TOR outProxy, <i><u>it looks like</u></i> you are anonymous
# elseif ($tor==2):
#you are <i><u>not</u></i> anonymous, however there is a TOR proxy somewhere in your subnet, why don't use that?
?>
<? else: ?>
you are <i><u>probably not</u></i> anonymous
<? endif; ?>
(<?=$_SERVER['SERVER_NAME']?>).
<? endif; ?>
<? if (isset($_SERVER['HTTP_REFERER'])): ?>
Your referer is '<?=htmlentities($_SERVER['HTTP_REFERER'])?>'
<? endif; ?>
</h5>
<?
}

function showpeerwarning()
{
GLOBAL $peertype;

procstate();
showpeerwarningimp();
}

$myparamfatal="";
function paramfatal($p)
{
  GLOBAL $myparamfatal;

  htmlcode(400, "Bad Request");
  if ($myparamfatal)
    $myparamfatal($p);
  stdparamfatal($p);
}
function stdparamfatal($p)
{
  head("invalid parameter: $p",1);
  showpeerwarning();
?>
<h1>Invalid parameter</h1>

The parameter <TT><b><?=$p?></b></TT> you gave is not valid:
<tt><b><?=htmlentities($_GET[$p])?></b></tt>
<P>
Either you followed a bad link, found a bug or wanted to provoke one.
<P>
Anyway, it did not work.
<?
  foot();
  exit(0);
}

function param($p, $match, $def='')
{
  if (!isset($_GET[$p]))
    return $def;
  $r    = $_GET[$p];
  if (!preg_match("|^$match\$|", $r))
    paramfatal($p);
  return $r;
}

function mustparam($p, $match)
{
  $r	= param($p, $match);
  if ($r=="")
    paramfatal($p);
  return $r;
}

function shownews($max, $name="news", $indent="")
{
$fd=fopen("$name.txt", "r");
echo "<div class='border'>";
while ($line=fgets($fd))
  {
    $line	= trim($line);
    if ($line!="")
      {
	if ($line[0]=="<" && --$max==0)
	  {
	    echo "(<a href='/news.php'>more</a>)";
	    break;
	  }
        echo "$indent$line\n";
        $indent	= "";
      }
    else if (--$max==0)
      break;
    else
      echo "</div><div class='border'>\n";
  }
echo "</div>";
fclose($fd);
}

function foot()
{
  GLOBAL $startmicro, $startusage, $have_frames, $textonly, $version, $isanon, $headerflags, $htmlCode;
?>
<? if (!$have_frames): ?>
<hr>
<? endif; ?>
<a href="#content"><img src="/_.gif" alt="[jump to content]" border=0 hspace=0 vspace=0 align=left></a>
<? if (!$isanon): ?>
<a href='http://www.catb.org/hacker-emblem/'><img src='/glider-small.png' alt="[hacker culture]" width=35 height=35 border=0 align=right></a>
<a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="/valid-css.gif" alt="Valid HTML 4.01 Transitional" height="31" width="88" ALIGN=right BORDER=0></a>
<a href="http://validator.w3.org/check?uri=referer"><img src="/valid-html401.gif" alt="Valid HTML 4.01 Transitional" height="31" width="88" ALIGN=right BORDER=0></a>
(Bitte dem Link zum <a href="http://permalink.de/tino/myinproxy">Impressum</a> folgen.
Diesem ist eine Erkl&auml;rung vorgeschaltet, damit man besser versteht,
worum es sich bei diesem Proxy handelt.)
<br>
<? endif; ?>
<?
  $endusage	= getrusage();
  $endmicro	= microtime(TRUE);
  $u		=($endusage["ru_utime.tv_sec"]-$startusage["ru_utime.tv_sec"])*1000000+($endusage["ru_utime.tv_usec"]-$startusage["ru_utime.tv_usec"]);
  $s		= ($endusage["ru_stime.tv_sec"]-$startusage["ru_stime.tv_sec"])*1000000+($endusage["ru_stime.tv_usec"]-$startusage["ru_stime.tv_usec"]);
  printf("[ms] (user+sys)/run (%d+%d)/%d", intval(($u+999)/1000), intval(($s+999)/1000), intval(($endmicro-$startmicro)*1000+0.999));
?>
 -- According to German law, I must give a link to an Imprint in German language.
<br>
<?=$version?> <?a("Valentin Hilbig", "http://permalink.de/tino/myinproxy", "http://www.tino.i2p/pager.php")?>
<? if ($have_frames): ?>
</noframes>
</frameset>
<? else: ?>
</body>
<? endif; ?>
</html>
<?
flush();
if ($lfd = @fopen('/tmp/php-timing.log', 'a')) { fprintf($lfd, "%7.3f %s %s %s '%s' '%s' '%s'\n", ($endmicro-$startmicro), $headerflags, $htmlCode, $_SERVER["PHP_SELF"], $_SERVER["QUERY_STRING"], $_SERVER["HTTP_REFERER"], $_SERVER["HTTP_USER_AGENT"]); fclose($lfd); }
}
?>

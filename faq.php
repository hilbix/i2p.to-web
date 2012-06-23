<?
# $Header: /CVSROOT/www/i2p.to/web/faq.php,v 1.3 2011-05-22 14:09:07 tino Exp $
#
# $Log: faq.php,v $
# Revision 1.3  2011-05-22 14:09:07  tino
# Grouping
#
# Revision 1.2  2009-04-26 04:13:23  tino
# FAQ index and new FAQ (addresschange) added
#
# Revision 1.1  2008/08/28 09:52:27  tino
# Added

include("header.php");
head("FAQ");
showpeerwarning();

function showindex($name="faq")
{
$fd=fopen("$name.txt", "r");
$open=0;
$state=0;
while ($line=fgets($fd))
  {
    $line	= trim($line);
    if ($line=="")
      {
	$state=0;
	continue;
      }
    if ($state==2)
      continue;
    if (substr($line,0,9)=="<a name=\"" && substr($line,-6)=="\"></a>")
      {
	$state	= 1;
	$jump	= substr($line,9,-6);
	continue;
      }
    if (substr($line,0,4)=="<!--" && substr($line,-3)=="-->")
      {
        if ($open)
          echo "</ul>";
        $open = 0;
        echo "<b>";
        echo substr($line,4,-3);
        echo "</b>\n";
        continue;
      }
    if (!$open)
      {
        echo "<ul>";
        $open = 1;
      }
    if ($state==1 && substr($line,0,6)=="<b>Q: " && substr($line, -4)=="</b>")
      {
	$state	= 2;
	echo "<li> <a href=\"#$jump\">";
        echo substr($line,6,-4);
	echo "</a>\n";
/*
*/
	continue;
      }
    echo "<li> (bug)\n";
    $state	= 2;
  }
if ($open)
  echo "</ul>";
fclose($fd);
}
?>
<a name="content"></a>

<div class="borderf">
<? showindex() ?>
</div>

<H2>FAQ</H2>
<? shownews(0, "faq") ?>

<? foot() ?>

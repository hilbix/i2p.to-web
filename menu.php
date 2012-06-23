<?
# $Header: /home/tino/CVSROOT/i2pinproxy/menu.php,v 1.1 2008/08/28 19:18:04 tino Exp $
#
# $Log: menu.php,v $
# Revision 1.1  2008/08/28 19:18:04  tino
# Added
#

include("header.php");

$refresh= param("refresh",	'^[1-9][0-9]*$', 0);
if ($refresh)
  {
    if ($refresh<3)
      $refresh=3;
    echo "<meta http-equiv='refresh' content='$refresh'>";
    head("Procstate",1,1,0,1);
    procstate(1);
?>
<a name="content"></a>
<?
  }
else
  {
    head("Menu");
?>
<a name="content"></a>
<?
    procstate(-1);
  }
$vals = array(""=>"off", 3=>3, 5=>5, 10=>10, 15=>15, 20=>20, 30=>30, 45=>45, 60=>"1 min", 120=>"2 min", 300=>"5 min", 600=>"10 min", 900=>"15 min",1800=>"30 min",2700=>"45 min", 3600=>"1 hr");
?>
<br>
<font size="1">Refresh: <?
$c="[";
for (reset($vals); list($k,$v)=each($vals); $c="|")
  {
    if ($refresh==$k)
      {
        echo "$c $v ";
	$refresh	= 0;
	continue;
      }
    if ($refresh && $refresh<$k)
      echo "$c $refresh ";
    if ($k)
      $k	= "?refresh=$k";
    echo "$c <a href=\"menu.php$k\">$v</a> ";
  }
if ($refresh)
  echo "$c $refresh ";
?>
]</font>
<p>
<div class="border2">
<?=strftime("%Y-%m-%d %H:%M:%S")?> (<?=gmstrftime("%Y-%m-%d %H:%M:%S")?> GMT)
</div>
<?
foot();
?>

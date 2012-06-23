<?
# $Header: /CVSROOT/www/i2p.to/web/json.php,v 1.2 2012-05-06 09:39:18 tino Exp $
#
# $Log: json.php,v $
# Revision 1.2  2012-05-06 09:39:18  tino
# I really have no idea
#
# Revision 1.1  2010-08-11 06:01:36  tino
# Current version
#

include("header.php");

header("Pragma: no-cache");
header("Expires: 0");
#header("Content-type: application/json");
header("Content-type: text/plain");
header("Cache-control: no-store,no-cache,max-age=0,must-revalidate");

$myparamfatal="myparamfatal";
function myparamfatal($h)
{
  printf("{\"error\":\"malformed parameter\",\"info\":\"%s\"}\n",$h);
  exit(0);
}

#$h=param("host", '[-.a-z0-9]+\.i2p','');
$ts=param("next", '[0-9][0-9][0-9][0-9]-[0-1][0-9]-[0-3][0-9] [0-2][0-9]:[0-5][0-9]:[0-5][0-9]','9999-12-31 23:59:59');
$code=param("code", '[0-9][0-9][0-9]', '');

$type="ts site code";
$sort="ts";

$part = "";
$q = "";
if ($code)
  {
    $part=",code:$code";
    $q = "$q and c_code=$code";
    $type = "ts site";
  }

$column = array("ts"=>"c_timestamp","site"=>"c_name","code"=>"c_code");

#$a=qh("select * from t_last where c_name='$h' order by c_timestamp desc limit 800");
#$a=q("select * from t_count where c_name='$h'");
#$a=qh("select * from t_last order by c_timestamp desc limit 800");

$cnt=100;
do
  {
$a=q("select * from t_log where c_timestamp>'' and c_timestamp<='$ts'$q order by c_timestamp desc limit $cnt");

$r=array();
$max=-1;
$last="";
$i=0;
reset($a);
foreach ($a as $v)
  {
    $r[$i]=$a;
    if ($v["c_timestamp"]!=$last)
      {
        $max	= $i;
	$last	= $v["c_timestamp"];
      }
    $i++;
  }
if ($i<$cnt)
  {
    $max	= $i;
    $last	= "";
  }
$cnt += 100;
  } while ($max<0);

$types = explode(' ', $type);

printf('{next:"%s",records:%d,type="%s"%s,order:"%s",data:[',$last,$max,$type,$part,$sort);
$i=0;
reset($a);
foreach ($a as $v)
  {
    if ($i>=$max)
      break;
    if ($i)
      echo ",";
    echo "\n{";
    $c="";
    foreach ($types as $k)
      {
        printf('%s%s:"%s"',$c,$k,$v[$column[$k]]);
	$c=",";
      }
    echo "}";
    $i++;
  }
echo "\n]}\n";

#print_r($a[0]);
?>

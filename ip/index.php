<?
header("content-type: text/plain");

$ip = $_SERVER["REMOTE_ADDR"];

$cc = "(unknown)";
$db=@sqlite_open("ip.sqlite", 0544);
if ($db)
  {
  sqlite_busy_timeout($db, 1000);
  $i = explode(".",$ip);
  $i = sprintf("%03d.%03d.%03d.%03d", $i[0],$i[1],$i[2],$i[3]);
  $q=sqlite_query($db, "select country from ip_country where lo<='$i' and hi>='$i'");
  if ($q && sqlite_has_more($q))
    $cc = sqlite_fetch_single($q);
  sqlite_close($db);
  }
echo "$ip is your IP and your country is $cc\n";
?>

<?
# $Header: /CVSROOT/www/i2p.to/web/showtable2.php,v 1.4 2011-05-22 14:06:20 tino Exp $
#
# $Log: showtable2.php,v $
# Revision 1.4  2011-05-22 14:06:20  tino
# censoring
#
# Revision 1.3  2008/09/13 21:25:13  tino
# Added qh() to query history table.  Also showtable now no more relies
# on the t_stat table, except for showing the real history entries.
#
# Revision 1.2  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page
#
# Revision 1.1  2008/08/28 09:52:28  tino
# Added

include("showtable.php");

function showtable2($code,$targ,$choose,$pref="",$hist=30,$oktime=5,$like="")
{
  GLOBAL $working, $textonly;

# Get possible history
  if (isset($_GET["hist"]) && is_numeric($_GET["hist"]))
    $hist	= $_GET["hist"];
  if ($hist<1)
    $hist	= 1;
  if ($hist>99)
    {
      $hist	= 100;	/*temporarily reduced to a max of 100, should be 1000*/
      echo " (history truncated to $hist)<br/>";
#      $hist	= 1000;
#      echo " (history truncated to $hist, as <A HREF=\"http://www.mozilla.org/\">FireFox</A> limits <!-- COLSPAN above 1000 is ignored, *sigh*, I would not say anything if this would happen at a reasonable value like 100000 or so, but 1000?  That's depressingly low! --> are reached)";
    }

# Get possible order-by clauses
  $ords = array(
	"Host"		=> "a.c_name"
,	"Last probe"	=> "a.c_timestamp"
,	"ok"		=> "a.c_count_ok"
,	"err"		=> "a.c_count_error"
,	"all"		=> "a.c_count"
,	"Time"		=> "b.c_total"
,	"req"		=> "b.c_req_size"
,	"ans"		=> "b.c_head_size"
,	"Content-Type"	=> "b.c_content_type"
	);
  $ords_v	= array_flip(array_values($ords));

  $order	= "a.c_name";
  if (isset($_GET["order"]) && isset($ords_v[strtolower($_GET["order"])]))
    $order	= $_GET["order"];
#  echo "[[[ tehpukink authbutt: "; echo "hist=$hist order=$order"; echo " ]]]";

# Now setup the URL parms
  $args	= array();
  $args["code"]		= $code;
  $args["hist"]		= $hist;
  $args["order"]	= $order;
  $args["oktime"]	= $oktime;

  $opts	= array();
  $opts["args"]		= $args;
  $opts["ords"]		= $ords;
  $opts["choose"]	= $choose;

  $a=q("select c_code,count(*) from t_count group by c_code order by c_code");

  text("Filter: ", "[ ");

  ll($opts, "all", "code", "");
  while (list($k,$v)=each($a))
    {
      echo " | ";
      ll($opts, $v[0], "code", $v[0]);
      text("", " (".$v[1].")");
    }
  text("\n"," ]\n");

if ($textonly):

?>
<br>
History:
<?
$s="";
foreach (array(1 => "1h", 5 => "5h", 12 => "12h", 24 => "day", 48 => "2 days", 168 => "week", 744 => "month") as $k=>$v)
  {
    echo $s;
    ll($opts, $v, "oktime", $k);
    $s	= " | ";
  }
?>
<br>
Sort:
<?
foreach ($ords as $k=>$v)
  {
    echo " ";
    ll($opts, "&lt;", "order", strtolower($v));
    if (strtolower($args["order"])==$v)
      echo "<b>$k</b>";
    else
      echo $k;
    ll($opts, "&gt;", "order", strtoupper($v));
  }
?>
<a name="content"></a>
<ul>
<?


else:



?>
<br clear="all">
<a name="content"></a>
<table cellspacing="0" cellpadding="0" summary="Sites known by this I2PinProxy. Possibly reduced to a HTTP return code: $code">
<tr valign="bottom">
<th align="right" colspan="<?=$hist?>">
<table summary="" class="noborder"><tr><th class="histt" colspan="2" align="right">
<?
  $m=1008;
  ol($opts, "&#x258c;", "oktime", 1);
  ol($opts, "&#x25c4;", "oktime", max(1,$oktime-168));
  ol($opts, "&#x25c4;", "oktime", max(1,$oktime-24));
  ol($opts, "&#x25c4;", "oktime", max(1,$oktime-5));
  ol($opts, "&#x25c4;", "oktime", max(1,$oktime-1));
  if ($oktime>=168)
    printf("%dw", $oktime/168);
  if (($oktime%168)>=24)
    printf("%dd", ($oktime%168)/24);
  if ($oktime%24)
    printf("%dh", $oktime%24);
  ol($opts, "&#x25ba;", "oktime", min($m, $oktime+1));
  ol($opts, "&#x25ba;", "oktime", min($m, $oktime+5));
  ol($opts, "&#x25ba;", "oktime", min($m, $oktime+24));
  ol($opts, "&#x25ba;", "oktime", min($m, $oktime+168));
  ol($opts, "&#x2590;", "oktime", $m);
?>
</th></tr><tr><th class="histl">Chk</th><th class="histr" align="right">Hist
<?
  $m=25;
  ol($opts, "&#x258c;", "hist", $m);
  ol($opts, "&#x25c4;", "hist", max($m,$hist-max(25,floor($hist/2))));
  ol($opts, "&#x25c4;", "hist", max($m,$hist-5));
  ol($opts, "&#x25c4;", "hist", max($m,$hist-1));
  echo $hist;
  $m=1000;
  ol($opts, "&#x25ba;", "hist", min($m,$hist+1));
  ol($opts, "&#x25ba;", "hist", min($m,$hist+5));
  ol($opts, "&#x25ba;", "hist", min($m,$hist+max(25,$hist)));
  ol($opts, "&#x2590;", "hist", $m);
  oh($opts, "History");
?>
</th></tr></table>
</th>
<th>Host <?=oh($opts, "Host")?></th>
<th>Info <?=oh($opts, "Info")?></th>
<th>Last probe <?=oh($opts, "Last probe")?></th>
<th>OK+err/all<br><?=oh($opts, "ok")?>+<?=oh($opts, "err")?>/<?=oh($opts, "all")?></th>
<th>Time <?=oh($opts, "Time")?></th>
<th>req+ans<br><?=oh($opts, "req")?>+<?=oh($opts, "ans")?></th>
<th>Content-Type <?=oh($opts, "Content-Type")?></th>
</tr>
<?
  endif;




#  $s="and ( a.c_code='$code' or a.c_name in ( select c_name from t_last where c_timestamp>datetime('now','-$oktime hours') and c_code='$code') )";
  $s="and ( a.c_code='$code' or a.c_name in ( select c_name from t_log where c_timestamp>datetime('now','-$oktime hours') and c_code='$code') )";
  if ($code=="")
    $s	= "";

  $sortorder=$order;
  if ($order!=strtolower($order))
    $sortorder	= strtolower($order) . " DESC";

  $h=q("select a.*,b.*,strftime('%s',datetime('now'))-strftime('%s',b.c_timestamp) from t_count a,t_log b where a.c_name=b.c_name and a.c_code=b.c_code $s order by $sortorder");

  $censors = showtable($h,$targ,$pref,$hist,$oktime, $textonly ? strtolower($order) : "");

  if (!$textonly):




  if ($working<0):
?><tr><td colspan="<?=$hist+7?>" align="center" bgcolor="#ff8080"><b>Sorry, database offline for administrative purpose.</b></td></tr><?
  endif;
?>
</table>
<?
tablelegend($oktime,$censors);

else:
?></ul><?
endif;
}
?>

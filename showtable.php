<?
# $Header: /CVSROOT/www/i2p.to/web/showtable.php,v 1.5 2011-05-22 14:06:20 tino Exp $
#
# $Log: showtable.php,v $
# Revision 1.5  2011-05-22 14:06:20  tino
# censoring
#
# Revision 1.4  2009-04-26 04:12:57  tino
# Site category added to text page
#
# Revision 1.3  2008/09/13 21:25:13  tino
# Added qh() to query history table.  Also showtable now no more relies
# on the t_stat table, except for showing the real history entries.
#
# Revision 1.2  2008/09/04 16:59:27  tino
# Explaination corrected as suggested by somebody in Forum.i2p
#
# Revision 1.1  2008/08/28 10:41:44  tino
# Old URLs to i2p.net changed to links page

include("header.php");

function showtable($h,$targ,$pref,$hist,$oktime,$textmode="")
{
  GLOBAL $color, $colorclass;

?><!--BEGIN-->
<?
#  if ($pref)	# blocking only if linking to site
#    $x=array();	# not linking to site
#  else
#  $x=array_flip(q("select c_name from t_block", 1));
  $x=array();
  $r = q("select c_name,c_total from t_block");
  reset($r);
  while (list(,$v)=each($r))
    $x[$v[0]] = $v[1];

  # LOOP over all hosts known
  $censor = 0;
  reset($h);
  for ($line=0; list(,$v)=each($h); $line=1-$line):
    $n=$v["a.c_name"];
    if (isset($x[$n]) && $x[$n])
      {
	$censor++;
        continue;
      }
    if ($textmode):
?>
<li> <??>
<? if ($pref==""): ?>
[<a href="http://<?=$n?>/">*</a><a target="_top" href="frame.php?page=info&amp;host=<?=$n?>" rel="nofollow">h</a>] <??>
<? endif ?>
<?
   else:
# OUTPUT THE COLORED HISTORY STAT
?>
<TR class="line<?=$line?>">
<?
  $o=qh("select c_code,strftime('%H',c_timestamp) hour from t_last where c_name='$n' order by c_timestamp desc LIMIT $hist");
  for ($i=0; $i<$hist; $i++):
    $b	= "";
    $c	= "";
    if (isset($o[$i]) && $o[$i][0]!="")
      {
        $b	= colorcode($o[$i][0]);
        $c	= " class='".$colorclass[colorcode($o[$i][0])].($o[$i][1]<12?'1':'')."'";
      }
?>
<td<?=$c?>><?=$b?></td><?
  endfor;
?>

<td class="data"><?
  endif;	# !textmode

  $t=$targ;
  if (!$t)
    $t	= "_blank";
  if (!$pref && isset($x[$n])):	# blocked
?>
<?=$n?><?
  else:			# !blocked
?>
<a name="j_<?=$n?>" target="<?=$t?>" href="<?=($pref ? "$pref$n" : prox($n))?>"><?=$n?></a><?
  endif;
  if ($textmode):
    if ($textmode!="a.c_name")
      echo " ".htmlentities($v[$textmode]);	# add the sorted information to the output
    else
      echo " ".htmlentities($v["a.c_code"]);
?>
</li>
<? else:	# !textmode
?>
</td>
<td class="data"><??>
<? if ($pref==""): ?>
<a href="http://<?=$n?>/">*</a><??>
<a target="_top" href="frame.php?page=info&amp;host=<?=$n?>">h</a><??>
<? endif ?>
</td>
<td class="data"><?=$v["a.c_timestamp"]?></td>
<td class="data" align="right"><?=$v["a.c_count_ok"]?>+<?=$v["a.c_count_error"]?>/<?=$v["a.c_count"]?></td>
<td class="data<?=$color[colorcode($v["a.c_code"])]?>" ALIGN=right><?=$v["b.c_total"]?></td>
<td class="data"><?=$v["b.c_req_size"]?>+<?=$v["b.c_head_size"]?></td>
<td class="data"><?=htmlentities($v["b.c_content_type"])?></td>
</tr>
<?
    endif;
    flush();
  endfor;
?><!--END-->
<!--censored <?=$censor?>-->
<?
return $censor;
}

function tablelegend($oktime,$censors=0)
{
?>
<? if ($censors): ?>
(<?=$censors?> destination(s) are not shown/censored. <a href="/faq.php#censor">FAQ</a>)
<? endif ?>
<h4>Legend:</h4>
<ul>
<li> <b>Chk</b> is how much history (time) is scanned for reachability, <b>Hist</b> is how much history (probes) is shown.
<li> The list includes all hosts which had this code within the last <?=$oktime?> hours.
     (However only hosts with the code at the last probe are counted.)
<li> <b>Hist:</b> last probes (left=newest): o=reachable, x=reachable but unknown, .=error seen
<li> <b>Host:</b> Links to the host via Internet (this is an inProxy, use the * to link via I2P).
<li> <b>Info:</b> Links to additional information: *(I2P name), d)ns h)istory i)mprint
<li> <b>Last probe:</b> Time of last probe in UTC (which is GMT)
<li> <b>OK+err/all:</b> The value means "successful" probes + "not reachable" / "total count of probes".
Total can be higher than OK+err, in this case some unusal return values were found,
which probably means, the I2P tunnel was open but the destination issued an error.
<li> <b>Time:</b> Time duration for last probe in seconds (it shows the color of the last probe)
<li> <b>req+ans:</b> "Size of Request" (out) + "Size of Header" (response)
<li> <b>Content-Type:</b> Value of the HTTP header "Content-type:" of the last probe, empty if destination is not HTTP capable (000 code returns), has a dummy value on errors (504)
</ul>
<?
}
?>

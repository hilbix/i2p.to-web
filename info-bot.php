<?
# $Header: /CVSROOT/www/i2p.to/web/info-bot.php,v 1.3 2009-01-26 07:59:48 tino Exp $
#
# $Log: info-bot.php,v $
# Revision 1.3  2009-01-26 07:59:48  tino
# Counters added to history page.
# HTML4.01 compliance.
#
# Revision 1.2  2008/09/13 21:25:13  tino
# Added qh() to query history table.  Also showtable now no more relies
# on the t_stat table, except for showing the real history entries.

include("header.php");
$h=mustparam("host",'[-.a-z0-9]+\.i2p');
head("$h -- info",1,1);
?>
<table cellspacing="0" summary="Host status summary">
<tr>
<th>Host</th>
<th>Last probe</th>
<th>OK</th>
<th>err</th>
<th>all</th>
</tr>
<?
$a=q("select * from t_count where c_name='$h'");
list(,$v)=each($a);
?>
<tr class="line1">
<td class="data"><?=$v["c_name"]?></td>
<td class="data"><?=$v["c_timestamp"]?></td>
<td class="data" align="right"><?=$v["c_count_ok"]?></td>
<td class="data" align="right"><?=$v["c_count_error"]?></td>
<td class="data" align="right"><?=$v["c_count"]?></td>
</tr>
</table>
<p>
Last code states (only one saved per code) with headers:
<a name="content"></a>
<table cellspacing="0" summary="Last probes according to HTTP code">
<tr>
<th>Host</th>
<th>Timestamp</th>
<th>Code</th>
<th>Total</th>
<th>REQ</th>
<th>head</th>
<th>Content-Type</th>
<th>Last Modified</th>
</tr>
<?
$a=q("select * from t_log where c_name='$h' order by c_timestamp desc");
while (list(,$v)=each($a)):
?>
<tr class="line0">
<td class="data"><?=$v["c_name"]?></td>
<td class="data"><?=$v["c_timestamp"]?></td>
<td class="data<?=$color[colorcode($v["c_code"])]?>"><?=$v["c_code"]?></td>
<td class="data"><?=$v["c_total"]?></td>
<td class="data"><?=$v["c_req_size"]?></td>
<td class="data"><?=$v["c_head_size"]?></td>
<td class="data"><?=$v["c_content_type"]?></td>
<td class="data"><?=$v["c_modified"]?></td>
</tr><tr class="line1">
<td colspan="8" class="show"><?=htmlentities($v["c_head"])?></td>
</tr>
<? endwhile; ?>
</table>
<p>
Probe history (limited to last 800 entries):
<img src="hist.php?host=<?=$h?>" border="1" align="right" alt="Graphical interpretation of probe history">
<table cellspacing="0" summary="Probe history according to time">
<tr>
<th>Host</th>
<th>Timestamp</th>
<th>Code</th>
<th>Time</th>
</tr>
<?
$a=qh("select * from t_last where c_name='$h' order by c_timestamp desc limit 800");
for ($line=0; list(,$v)=each($a); $line=1-$line):
?>
<tr class="line<?=$line?>">
<td class="data"><?=$v["c_name"]?></td>
<td class="data"><?=$v["c_timestamp"]?></td>
<td class="data<?=$color[colorcode($v["c_code"])]?>"><?=$v["c_code"]?></td>
<td class="data"><?=$v["c_total"]?></td>
</tr>
<? endfor; ?>
</table>
<br clear="all">
<?
foot();
?>

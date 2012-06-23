<?
# $Header: /home/tino/CVSROOT/i2pinproxy/graph.php,v 1.1 2008/08/28 09:52:27 tino Exp $
#
# $Log: graph.php,v $
# Revision 1.1  2008/08/28 09:52:27  tino
# Added
#

include("header.php");

$code	= param("code",		'^[0-9]*$',	'200');
$search	= param("search",	'^[-_.0-9a-z]*$');
$refresh= param("refresh",	'^[01]$', 0);

if ($refresh):
?>
<meta http-equiv="refresh" content="60">
<?
endif;

head("History Graph");

showpeerwarning();
?>
<? if ($refresh): ?>
[ <A HREF="graph.php?refresh=0">Turn off autorefresh.</A> ]
Autorefresh is turned on.
<? else: ?>
Autorefresh is turned off.
[ <A HREF="graph.php?refresh=1">Turn on autorefresh.</A> ]
<? endif; ?>

<a name="content"></a>

<H1>History Graph</H1>
<P>
<?
include "graph.inc";;
?>
<UL>
<LI> Graph is updated each minute.
<LI> <b>flaps</b> are the machines which changed status within last 48 hours.
     This number is a good estimate for stability and reachability of the I2P network:
     <BR>Network condition <b>poor</b>: The flap count is above the graph.  Network is badly instable.  A lot of existing eepsites aren't reachable.
     <BR>Network condition <b>normal</b>: The flap count is very near the graph.
     <BR>Network condition <b>good</b>: The flap count is below the graph.
<LI> The purple flaps (4 weeks) can be taken as an bug indicator of this I2PinProxy.  It always hits the roof when some bug hit which I introduced or oversaw. :-)<br>
     Please note that the Reachability (on the top right) is marked yellow when this graph is three times higher than all reachable destinations.
<LI> 0xx means "reachable but no HTTP protocol".  If this number is high this means "bug" or "disruption" of service.
<LI> 1xx cannot happen.  If so, this would be a weird destination.
<LI> 2xx is the normal case for normal reachable eepsites
<LI> 3xx and 4xx are sites which send a redirect, this means, they are reachable
<LI> 5xx are unreachables, not shown in the graph
</UL>
<?
foot();
?>

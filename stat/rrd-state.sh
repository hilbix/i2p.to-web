#!/bin/bash
# $Header: /CVSROOT/www/i2p.to/web/stat/rrd-state.sh,v 1.2 2012-05-06 09:25:12 tino Exp $
#
# $Log: rrd-state.sh,v $
# Revision 1.2  2012-05-06 09:25:12  tino
# Syncing now is err state
#
# Revision 1.1  2008-08-28 11:02:36  tino
# Added

q()
{
[ -s ".db.offline" ] ||
echo ".timeout 15000
$*" |
sqlite stat.sqlite >&2
}

term()
{
q "insert or replace into t_proc values ('Reachability',datetime('now', '+5 minutes'),0,'$3',datetime('now'),60,'${1:0:1} $2');" 2>/dev/null
echo "$1 I2P inproxy state $2 $3"
exit 0
}

TSFILE="rrd.sh.stamp"

########################################################################
# Reset the graph output
########################################################################

> graph.inc

########################################################################
# Create the response
########################################################################

IFS='|'
if	! { read date newts c0 c1 c2 c3 c4 c5 flaps flaps2 cond condstr condmin condmax rest < "$TSFILE" ||
	  { sleep 1 && read date newts c0 c1 c2 c3 c4 c5 flaps flaps2 cond condstr condmin condmax rest < "$TSFILE"; } }
then
	term ERR failed "Cannot read status file"
fi

state=ok
Sok=OK
Swarn=WARN
Serr=ERR
let ok=$c0+$c1+$c2+$c3+$c4
let min=$flaps2/3
[ 30 -gt $min ] && min=30
pref="$ok/$flaps/$flaps2"

if [ -n "`find "$TSFILE" -mmin +5`" ]
then
	echo "<div class=trouble>The graph is not updated. Sync subsystem fails.</div>" >>graph.inc
	state=err
	warn=ERR
	ok="SUBSYS: $ok"
fi
if [ -s ".rrd.hold" ]
then
	{ echo "<div class=trouble>Note from admin: "; cat .rrd.hold; echo "</div>"; } >> graph.inc
	state=ok
	Sok=WARN
	Swarn=WARN
	Serr=WARN
fi

if [ .-1 = ".$cond" ]
then
        state=err
elif [ .-2 = ".$cond" ]
then
	echo "<div class=trouble>The graph is not up to date! (syncing)</div>" >> graph.inc
	state=warn
	state=err
	pref="syncing"
	condstr="$date"
	ok="SYNCING: $ok"
elif [ $min -gt $ok ]
then
        state=warn
fi

eval state=\"\$S$state\"
[ OK = "$state" ] || pref="${state:0:1} $pref"

########################################################################
# Update the status
########################################################################

q "insert or replace into t_proc values ('Reachability',datetime('now', '+5 minutes'),0,'$condstr: $cond ($condmin-$condmax)',datetime('now'),60,'$pref');"

echo "$state I2P inproxy $ok/$flaps/$flaps2 $condstr: $cond ($condmin-$condmax)"

########################################################################
# Plot the graphs
########################################################################

n_hour=1
n_six_hours=6
n_day=24
n_week=168
n_month=720
n_season=2160
n_year=8760
n_leapyear=35064
n_decade=87672
l_week="HOUR:6:DAY:1:DAY:1:86400:%a,%d.%b"
l_leapyear="MONTH:1:YEAR:1:MONTH:3:1814400:%b'%y"
l_decade='MONTH:3:YEAR:1:YEAR:1:31536000:%Y'

ext=gif

for a in hour six_hours day week month season year leapyear decade
do
	eval h=\$n_$a					
	eval l=\$l_$a
	[ -n "$l" ] && l="-x$l"
	nice -99 /usr/bin/rrdtool graph			\
	-Y -M						\
	-l 0						\
	$l						\
	-e "$newts"					\
	-s "end-$h hours"				\
	-w 800						\
	-h 200						\
	-z						\
	-f "<IMG SRC='%s' ALT='$a graph' BORDER=0 WIDTH='%lu' HEIGHT='%lu'><BR>"	\
	"graph-$a.$ext"					\
	"DEF:h0=rrd.sh.rrd:0xx:MAX"			\
	"DEF:h1=rrd.sh.rrd:1xx:MAX"			\
	"DEF:h2=rrd.sh.rrd:2xx:MAX"			\
	"DEF:h3=rrd.sh.rrd:3xx:MAX"			\
	"DEF:h4=rrd.sh.rrd:4xx:MAX"			\
	"DEF:h5=rrd.sh.rrd:5xx:MAX"			\
	"DEF:fl=rrd.sh.rrd:flaps:MAX"			\
	"DEF:f2=rrd.sh.rrd:flaps2:MAX"			\
	"COMMENT:$date i2p.to "				\
	"AREA:h0#ffff00:0xx\\:\\g"			\
	"GPRINT:h0:AVERAGE:%1.2lf"			\
	"STACK:h1#00ffff:1xx\\:\\g"			\
	"GPRINT:h1:AVERAGE:%1.2lf"			\
	"STACK:h2#00ff00:2xx\\:\\g"			\
	"GPRINT:h2:AVERAGE:%1.2lf"			\
	"STACK:h3#aaaaaa:3xx\\:\\g"			\
	"GPRINT:h3:AVERAGE:%1.2lf"			\
	"STACK:h4#0000ff:4xx\\:\\g"			\
	"GPRINT:h4:AVERAGE:%1.2lf"			\
	"COMMENT:- flaps \\g"				\
	"LINE1:fl#ff0000:2d\\:\\g"			\
	"GPRINT:fl:AVERAGE:%1.2lf"			\
	"LINE2:f2#ff00ff:4w\\:\\g"			\
	"GPRINT:f2:AVERAGE:%1.2lf"			\
	"COMMENT:- $a\\j"				\

#	"LINE3:h5#ff0000:5xx"				\
#	"LINE1:h5#ff0000:5xx"				\

done |
grep '^<' >> graph.inc

########################################################################
# Copy the graph
########################################################################

for a in graph.inc graph-*.$ext
do
	cmp -s "$a" "../$a" ||
	cp -f "$a" "../$a"
done

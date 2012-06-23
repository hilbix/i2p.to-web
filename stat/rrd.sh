#!/bin/sh
# $Header: /home/tino/CVSROOT/i2pinproxy/stat/rrd.sh,v 1.2 2008/09/13 21:26:58 tino Exp $
#
# $Log: rrd.sh,v $
# Revision 1.2  2008/09/13 21:26:58  tino
# hist.sqlite changes, now new history table is used
#
# Revision 1.1  2008/08/28 11:02:36  tino
# Added
#

qh()
{
echo ".timeout 30000
$*" |
sqlite hist.sqlite
}

RRD="$0.rrd"
TSFILE="$0.stamp"

########################################################################
# Create the RRD
########################################################################

if [ ! -f "$RRD" ]
then
	rm -f "$TSFILE"

	qh "select strftime('%s',c_timestamp)-1 from t_last where c_timestamp<>'' order by c_timestamp asc limit 1;" |
	(
	read min
	echo "min: $min"
	rrdtool create "$RRD"			\
		--start $min			\
		-s 60				\
		DS:0xx:GAUGE:4000:0:U		\
		DS:1xx:GAUGE:4000:0:U		\
		DS:2xx:GAUGE:4000:0:U		\
		DS:3xx:GAUGE:4000:0:U		\
		DS:4xx:GAUGE:4000:0:U		\
		DS:5xx:GAUGE:4000:0:U		\
		DS:flaps:GAUGE:4000:0:U		\
		DS:flaps2:GAUGE:4000:0:U	\
		RRA:MIN:0.5:1:100000		\
		RRA:AVERAGE:0.5:1:100000	\
		RRA:MAX:0.5:1:100000		\
		RRA:MIN:0.5:60:10000		\
		RRA:AVERAGE:0.5:60:10000	\
		RRA:MAX:0.5:60:10000		\
		RRA:MIN:0.5:1440:10000		\
		RRA:AVERAGE:0.5:1440:10000	\
		RRA:MAX:0.5:1440:10000		\

#
	)

fi

########################################################################
# Update the statistice
########################################################################

ts="`sed -n '1s/|.*//gp' "$TSFILE"`"
#echo "$ts";

#-----------------------------------------------------------------------
# Query DB

qh "select
	strftime('%s',c.c_timestamp)
	,c.c_name
	,c.c_code
	,c.c_timestamp
	,count(a.c_timestamp)
	,count(b.c_timestamp)
	,strftime('%s',datetime('now'))
from
	(
	select
		c_name
		,c_code
		,c_timestamp
		,datetime(c_timestamp,'-48 hours') c_min
		,datetime(c_timestamp,'-28 days') c_week
	from
		t_last
	where
		c_timestamp<>''
		and c_timestamp>='$ts'
	order by
		c_timestamp
	limit 100
	) c
left join
	t_last a
on
	a.c_name=c.c_name
	and a.c_timestamp>=c.c_min
	and a.c_timestamp<c.c_timestamp
	and a.c_code<>c.c_code
left join
	t_last b
on
	b.c_name=c.c_name
	and b.c_timestamp>=c.c_week
	and b.c_timestamp<c.c_timestamp
	and b.c_code<>c.c_code
group by
	c.c_timestamp
	, c.c_name
order by
	c.c_timestamp
	, c.c_name
;
" |

#-----------------------------------------------------------------------
# Parse the result

awk -vTSFILE="$TSFILE" '
function setcond(n)
{
  if (n<mincond)
    mincond	= n
  if (n>maxcond)
    maxcond	= n
}

BEGIN	{
	FS="|"
	OFS="|"
	getline < TSFILE
	ts=$1
	last=$2
	cnt[0]=$3
	cnt[1]=$4
	cnt[2]=$5
	cnt[3]=$6
	cnt[4]=$7
	cnt[5]=$8
	flaps=$9
	flaps2=$10
	cond=$11
#	ocond=$12
	while ((getline < TSFILE)>0)
		{
		code[$1]=$2
		flap[$1]=$3
		flap2[$1]=$4
		}
	close(TSFILE)
#	print ts, cnt[0], cnt[1], cnt[2], cnt[3], cnt[4], cnt[5], flaps > "/dev/stderr"
	}
NF!=7	{
	print "BUG " NF ": " $0 >"/dev/stderr"
	next
	}
	{
	anz++

	cnt[code[$2]]--
	flaps	-=flap[$2]
	flaps2	-=flap2[$2]

	_code	= 0+substr($3,1,1)
	_flap	= ($5!=0)
	_flap2	= ($6!=0)

	code[$2]= _code
	flap[$2]= _flap
	flap2[$2]= _flap2

	cnt[_code]++
	flaps+=_flap
	flaps2+=_flap2

	if ($1!=last)
		printf("%d:%d:%d:%d:%d:%d:%d:%d:%d\n", $1, cnt[0], cnt[1], cnt[2], cnt[3], cnt[4], cnt[5], flaps, flaps2)
	last=$1
	ts=$4
	now=$7
	}
END	{
	ok=cnt[0]+cnt[1]+cnt[2]+cnt[3]+cnt[4]

	mincond=99
	maxcond=-99

	if (flaps>=ok*2)			setcond(7)
	if (flaps>=ok*1.5 && flaps<ok*2.5)	setcond(6)
	if (flaps>ok+1 && flaps<ok*1.5)		setcond(5)
	if (flaps>=ok-5 && flaps<=ok+5)		setcond(3)
	if (flaps<ok-1 && flaps>ok/2)		setcond(1)
	if (flaps<ok/2)				setcond(0)

	if (cond<mincond)
		cond	= mincond
	else if (int(cond)>maxcond)
		cond	= maxcond + .99;
	else
		cond	= int(cond*98 + maxcond + mincond + .5)/100

	if (cnt[0]>ok*0.8 || ok<10)	cond=-1

	conds[-1]="unknown"
	conds[0]="very good"
	conds[1]="good"
	conds[2]="good-normal"
	conds[3]="normal"
	conds[4]="normal-poor"
	conds[5]="poor"
	conds[6]="very poor"
	conds[7]="disastrous"
	cnd=conds[int(cond)]
	if (last+500<now)
		cond=-2

	printf("%s|%s|%d|%d|%d|%d|%d|%d|%d|%d|%d|%s|%d|%d|%d\n", ts, last, cnt[0], cnt[1], cnt[2], cnt[3], cnt[4], cnt[5], flaps, flaps2, cond, cnd, mincond, maxcond, anz) > TSFILE
	for (a in code)
		printf("%s|%d|%d|%d\n", a,code[a],flap[a],flap2[a]) > TSFILE
	close(TSFILE)

#	if (conds[int(cond)]!=ocond)
#		print conds[int(cond)] > TSFILE ".weather"
#
#	print ts, cnt[0], cnt[1], cnt[2], cnt[3], cnt[4], cnt[5], flaps > "/dev/stderr"
#	print anz >"/dev/stderr"
	}
' |

#-----------------------------------------------------------------------
# update RRD

xargs -r rrdtool update "$RRD"

IFS='|'
read ts last cnt0 cnt1 cnt2 cnt3 cnt4 cnt5 flaps flaps2 cond cnd mincond maxcond anz < "$TSFILE" || exit 1
[ 50 -gt ${anz:-0} ] || exit 42

#!/bin/sh

cd "`dirname "$0"`" || exit

wout="'%{http_code}','%{time_total}','%{size_request}','%{size_header}','%{content_type}'"

: q
q()
{
echo ".timeout 20000
$*" | sqlite stat.sqlite
}

: qh
qh()
{
echo ".timeout 200000
$*" | sqlite hist.sqlite
}

: qm
qm()
{
echo ".timeout 20000
$*" | sqlite mail.sqlite
}

: inserter
inserter()
{
missing=false
stamp="`date -ur "out/$1/$1.time" +'%Y-%m-%d %H:%M:%S'`" || return
head="`sed "s/'/''/g" "out/$1/$1.head" 2>/dev/null`" || return
case "$head" in
"HTTP/1.0 404 I2P server down")
	# The special transport wrapper sends this magic if it cannot connect
	echo "I2P server down"
	sleep 60
	return
	;;
"HTTP/1.1 "[45][0-9][0-9]" Domain Not Found"*)
	# The target is not in the router's address book.
	# In router before 0.9 this was 504.
	# Now since 0.9 this is 404 which is slightly more correct but bad for our statistics.
	# Set a missing flag such that we can transform the code into 666 below.
	# (Codes must be exactly 3 numbers for other scripts to correctly function.)
	missing=:
	# Question: Can this be faked by an EEPSITE?
	# If so, we need to add some more checks here.
	;;
esac
mod="`sed -n 's/^Last-Modified: //pI' "out/$1/$1.head" 2>/dev/null`"
if [ -n "$mod" ]
then
	lmod="`date -ud "$mod" +'%Y-%m-%d %H:%M:%S' 2>/dev/null`"
	if [ -z "$lmod" ]
	then
		: echo "$1: header unparseable: last-modified"
	else
		mod="$lmod"
	fi
fi
line=""
# returns false as the stamp does not contain a LF
read -r line < "out/$1/$1.time"
if	expr + "$line" : "'[0-9]\\+','[.0-9]\\+','[0-9]\\+','[0-9]\\+','[^']*'\$" >/dev/null
then
	code="`expr + "$line" : '\([^,]*\),'`"
	time="`expr + "$line" : '[^,]*,\([^,]*\),'`"
	# Put destinations without addressbook into code class 666
	$missing && code="'666'"
	case "$code" in
	\'[23]??\')	upd=",c_count_ok=c_count_ok+1"; additional "$1";;
	\'504\'|\'666\')	upd=",c_count_error=c_count_error+1";;
	\'000\')	case "$time" in \'0.[0-6]*) echo "too quickly $1: $line"; sleep 60; return;; esac;;
	*)		upd="";;
	esac
	# Insert into the now separate history table
	qh "insert into t_last values ('$1','$stamp',$code,$time);"
	# Update the main status table (history will be removed, soon)
	q "
		begin;
		insert or replace into t_log   values ('$1','$stamp',$line,'$head','$mod');
--		insert            into t_last  values ('$1','$stamp',$code,$time);
		insert or ignore  into t_count values ('$1',NULL,NULL,0,0,0);
		update                 t_count set c_timestamp='$stamp', c_code=$code, c_count=c_count+1 $upd where c_name='$1';
		commit;
	"
	# Update the mail response table
	# The insert is not needed, but
	qm "
		begin;
		insert or ignore into t_state values ('$1',$code,'$stamp',0,0,0);
		update                t_state set c_lastcnt=c_cnt,c_cnt=0 where c_name='$1' and c_cnt>0 and c_code<>$code;
		update                t_state set c_flag=1,c_cnt=c_cnt+1,c_timestamp='$stamp' where c_name='$1' and c_code=$code;
		commit;
	"
else
	echo "wrong timestamp $1: $line"
fi
}

: rename0
rename0()
{
rtarg="$1"
shift 1
onr=.9
for nr in .8 .7 .6 .5 .4 .3 .2 .1 .0 "$@"
do
	[ -f "$rtarg$nr" ] &&
	mv -f "$rtarg$nr" "$rtarg$onr"
	onr=$nr
done
}

: get
get()
{
curl	-q						\
	--silent					\
	--user-agent	'inproxy.tino.i2p/0.2'		\
	--referer	'http://i2p.tin0.de/stat/'	\
	--proxy		127.0.0.1:4444			\
	--max-time	500				\
	"$@"
}

: check
check()
{
get	--location					\
	--fail						\
	--remote-time					\
	--output	"out/$1/$1.$2"			\
	--dump-header	"out/$1/$1.$2.head.new"		\
	--time-cond	"out/$1/$1.$2"			\
	"http://$1/$2"

[ -s "out/$1/$1.$2" ] &&
! cmp -s "out/$1.$2" "out/$1/$1.$2.0" &&
rename0 "out/$1/$1.$2" &&
cp -f "out/$1/$1.$2" "out/$1/$1.$2.0"

[ -s "out/$1/$1.$2.head.new" ] &&
rename0 "out/$1/$1.$2.head" "" .new
}

: additional
additional()
{
q "
insert or ignore into t_postprocess values ('$1',1);
"
#check "$1" "hosts.txt"
#check "$1" "imprint.xml"
}

: gethost
gethost()
{
get "$1" |
sed -n 's/=.*$//p'
}

: proc
proc()
{
procname="$1"
procdelta="$2"
proctext="$3"
procinfo="'$4'"
procest="${5:-0}"
addon=""
[ .finished != ".$proctext" ] && addon="
delete from t_proc where c_name='$procname' and c_state='finished';"
q "insert or replace into t_proc values ('$procname',datetime('now', '+$procdelta minutes'),$$,'$proctext',datetime('now'),$procest,$procinfo);$addon"
}

: getprobe
getprobe()
{
[ ! -d "out/$1" ] && mkdir "out/$1"
mv -f "out/$1/$1.head" "out/$1/$1.head.last" 2>/dev/null
rm -f "out/$1/$1.head" "out/$1/$1.time"
get	--head						\
	--remote-time					\
	--output	"out/$1/$1.head"		\
	--write-out	"$wout"				\
	http://$b/	> "out/$1/$1.time"
}

: probe
probe()
{
awk '!had[$0] && $0!="" { had[$0]=1; gsub(/^ /,""); print; cnt++ } END { print " " cnt; }' |
sort |
{
read total
let pnr=0
while read a
do
	b="`expr match "$a" '\([a-zA-Z0-9][-.a-zA-Z0-9]*\.i2p\)$' | tr '[A-Z]' '[a-z]'`"
	[ -z "$b" ] && continue
	let pnr++
	proc "$1" 10 "$b" "$pnr/$total"

	getprobe "$b"
	case "$?" in
	0|28|52)	inserter "$b";;
	esac
done
}
}

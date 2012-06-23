#!/bin/bash
# $Header: /home/tino/CVSROOT/i2pinproxy/ip/.x,v 1.1 2008/09/04 17:06:20 tino Exp $
#
# $Log: .x,v $
# Revision 1.1  2008/09/04 17:06:20  tino
# added
#

cd "`dirname "$0"`" || exit

q()
{
echo ".timeout 100
$1;" |
sqlite -separator ' ' ip.sqlite
}

s()
{
echo ".timeout 100000
$1;" |
sqlite ../stat/stat.sqlite
}

log()
{
echo "`date +%Y%m%d-%H%M%S` $*"
}

echo ""
log started
../stat/.fixup

s "delete from t_proc where c_name='torcheck'" >&2
q "create table t_ip ( c_ip, c_tor default 0, c_count default 0, c_timestamp, c_lastcheck, c_reverse, primary key (c_ip) )"

while echo -n . && ! read -t5
do
	s "insert or ignore into t_proc values ('torcheck',datetime('now', '+5 minutes'),$$,0,datetime('now'),0,0)" 2>/dev/null >&2
	ts="`date -d 'now -5 hours' +'%Y-%m-%d %H:%M:%S'`"
	q "begin; select 'cleanup',* from t_ip where c_timestamp<'$ts'; delete from t_ip where c_timestamp<'$ts'; end"
	q "select c_ip from t_ip where c_tor=0 or (c_tor=-1 and c_lastcheck<'$ts')" |
	{
	cnt=0
	IFS=.
	while read ipa ipb ipc ipd
	do
		# Yes, I am paranoid
		let ip1="0+${ipa:-0}"
		let ip2="0+${ipb:-0}"
		let ip3="0+${ipc:-0}"
		let ip4="0+${ipd:-0}"
		[ ".$ip1.$ip2.$ip3.$ip4" = ".$ipa.$ipb.$ipc.$ipd" ] || continue

		let cnt++
		if	adr="`dig +short +time=1 a "$ipd.$ipc.$ipb.$ipa.tor.dnsbl.sectoor.de." | tail -1`"
		then
			case "$adr" in
			'')		tor=-1;;
			127.0.0.1)	tor=1;;
			127.0.0.2)	tor=2;;
			*)		tor=-2;;
			esac
			rev="`dig +short +time=10 ptr "$ipd.$ipc.$ipb.$ipa.in-addr.arpa."`"
			case "$rev" in
			*\'*)	rev="(ill)";;
			esac
			q "update t_ip set c_tor=$tor,c_timestamp=datetime('now'),c_lastcheck=datetime('now'),c_reverse='$rev' where c_ip='$ipa.$ipb.$ipc.$ipd'"
			log "$ipa.$ipb.$ipc.$ipd $tor $rev"
		else
			log "$ipa.$ipb.$ipc.$ipd error"
		fi	
	done
	s "update t_proc set c_timestamp=datetime('now', '+5 minutes'),c_at=c_at+$cnt,c_starttime=datetime('now'),c_seconds=5,c_state=c_state+1 where c_name='torcheck' and c_pid=$$" 2>/dev/null >&2
	}
done

log terminated


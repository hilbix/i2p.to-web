#!/bin/bash
# $Header: /home/tino/CVSROOT/i2pinproxy/stat/version.sh,v 1.1 2008/08/28 11:02:36 tino Exp $
#
# $Log: version.sh,v $
# Revision 1.1  2008/08/28 11:02:36  tino
# Added
#

q()
{
[ -s ".db.offline" ] ||
echo ".timeout 20000
$*" |
sqlite stat.sqlite >/dev/null
}


{
cd "`dirname "$0"`" || exit

# Randomnize a little bit ..
[ -z "$1" ] || sleep `expr $RANDOM % 20`

. setup/keys.inc

./version-freenet.sh "$1" "$KEY1" >&3

checkvers()
{
eval k=\"\$KEY$2\"
curl -q --silent --proxy 127.0.0.1:4444 --fail --max-time 45 --connect-timeout 15 "http://$k/version.txt" |
{
warn=
read -t30 C cin cout &&
read -t30 D dist ddate &&
read -t30 L leaserr &&
read -t30 M free total &&
read -t30 P participating &&
read -t30 S status &&
read -t30 U uptime &&
read -t30 V vers &&
[ -n "$vers" ] &&
[ .C = ".$C" ] &&
[ .D = ".$D" ] &&
[ .L = ".$L" ] &&
[ .M = ".$M" ] &&
[ .P = ".$P" ] &&
[ .S = ".$S" ] &&
[ .U = ".$U" ] &&
[ .V = ".$V" ] &&
case "$status:$vers" in
OK:$dist-*)	[ 9 -lt "$participating" ] || { warn=WARN; vers="W $vers"; };;
OK:*)		warn=WARN; vers="W $vers";;
*)		warn=ERR; false;;
esac &&
{
a1="insert or replace into t_proc values ('I2P latest',datetime('now', '+5 minutes'),0,'$ddate',datetime('now'),60,'$warn $dist')"
a2="update t_proc set c_state='$ddate $dist' where c_name='I2P latest' and c_at not like '%$dist' and c_state<'$ddate'"
eval a=\$a$2
q "$a;
insert or replace into t_proc values ('I2P router$2',datetime('now', '+5 minutes'),0,'$status $uptime t:$participating+$cin+$cout m:$free/$total',datetime('now'),60,'$vers');"
} &&
echo "$1 999 ${warn:-OK} I2P router$2 $vers up $uptime $free/$total $status" >&3
}
}

checkvers "$1" 1
checkvers "$1" 2

} 3>&1 1>&2


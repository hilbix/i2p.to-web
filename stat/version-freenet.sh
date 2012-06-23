#!/bin/sh
# $Header: /home/tino/CVSROOT/i2pinproxy/stat/version-freenet.sh,v 1.1 2008/08/28 11:02:36 tino Exp $
#
# $Log: version-freenet.sh,v $
# Revision 1.1  2008/08/28 11:02:36  tino
# Added
#

KEY1="${2:-tino.i2p}"

curl -q --silent --proxy 127.0.0.1:4444 --fail --max-time 45 --connect-timeout 15 "http://$KEY1/freenet.state" |
(
read cnt state || exit
read B vers || exit
read L latest
[ -n "$state" ] || exit
[ .B = ".$B" ] || exit
[ -n "$vers" ] || exit
[ -z "$L" -o .L = ".$L" ] || exit

warn=
[ -n "$latest" ] && warn=WARN && latest=" latest $latest"
cmp="$cnt $state$latest"

echo "$cmp" | cmp -s - /tmp/freenet.last && exit

echo "$cmp" >/tmp/freenet.last

case "$cnt" in
-*)	warn=WARN;;
esac

echo ".timeout 20000
insert or replace into t_proc values ('Freenet',datetime('now', '+5 minutes'),0,'$cmp',datetime('now'),60,'$warn $vers');" |
sqlite stat.sqlite >/dev/null &&
echo "$1 2500 ${warn:-OK} freenet version $vers [$cnt $state]$latest"
)

#curl -o freenet.hist -c- -q --silent --proxy 127.0.0.1:4444 --fail --max-time 15 --connect-timeout 10 "http://$KEY1/freenet.hist"

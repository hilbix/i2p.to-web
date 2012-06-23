#!/bin/sh
# $Header: /home/tino/CVSROOT/i2pinproxy/stat/minute-run.sh,v 1.1 2008/09/05 14:39:02 tino Exp $
#
# $Log: minute-run.sh,v $
# Revision 1.1  2008/09/05 14:39:02  tino
# Added from minute.sh
#

cd "`dirname "$0"`" || exit

host="`hostname -f`"
cond="`./rrd-state.sh`"
version="`./version.sh "$host"`"

act="$host 300 $cond"
[ -n "$version" ] &&
act="$act
$version"

cnt=0
[ -s .db.offline ] ||
cnt="`echo ".timeout 15000
select count(*) from t_proc;" |
sqlite stat.sqlite 2>/dev/null`"

if [ 13 -lt "$cnt" ]
then
	act="$act
$host 300 WARN I2P procs $cnt"
elif [ 7 -le "$cnt" ]
then
	act="$act
$host 300 OK I2P procs $cnt"
elif [ -s .db.offline ]
then
	act="$act
$host 300 ERR I2P procs `head -1 .db.offline`"
fi

echo "POST /mond/post.php HTTP/1.0
Content-Length: ${#act}
Content-Type: text/plain

$act" |
netcat -w100 hydra.geht.net 80

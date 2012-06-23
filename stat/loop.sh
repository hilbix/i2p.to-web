#!/bin/bash
# $Header: /CVSROOT/www/i2p.to/web/stat/loop.sh,v 1.2 2012-05-06 09:26:00 tino Exp $
#
# $Log: loop.sh,v $
# Revision 1.2  2012-05-06 09:26:00  tino
# Added new (variable) key sources.
#
# Revision 1.1  2008-08-28 11:02:36  tino
# Added

cd "`dirname "$0"`" || exit 1

sqlite stat.sqlite "delete from t_proc where c_name='probeloop'"
while	date +'%Y-%m-%d %H:%M:%S' && ! read -t2 ign
do
	(
	. stat.inc
	. setup/keys.inc
	proc probeloop 1 waiting '' 60
	sleep 60
	proc probeloop 5 starting '' 10
	{
	qh "select distinct c_name from t_last;"
	for ky in $ALLKEYS
	do
		echo
		gethost "http://$ky/hosts.txt"
	done
	} |
	probe probeloop
	proc probeloop 1 finished '' 5
	)
done 2>&1 |
tee -a stat.log

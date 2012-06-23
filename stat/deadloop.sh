#!/bin/sh
# $Header: /CVSROOT/www/i2p.to/web/stat/deadloop.sh,v 1.5 2009-01-26 08:01:21 tino Exp $
#
# $Log: deadloop.sh,v $
# Revision 1.5  2009-01-26 08:01:21  tino
# Deadloop starts with setting itself to finished, not deleting the entry.
#
# Revision 1.4  2008/09/13 21:26:11  tino
# Typo in initial SQL cleanup fixed
#
# Revision 1.3  2008/09/05 15:24:20  tino
# Cleanup at startup improved
#
# Revision 1.2  2008/09/05 15:16:07  tino
# Bugfix, too many dead targets were probed
#
# Revision 1.1  2008/08/28 11:02:36  tino
# Added

cd "`dirname "$0"`" || exit 1

echo ".timeout 20000

update t_proc set c_state='finished' where c_name='deadloop';" |
sqlite stat.sqlite

while	date +'%Y-%m-%d %H:%M:%S'
do
	sleep 600 &

	(
	. ./stat.inc

	proc deadloop 1 waiting '' 60
	sleep 60
	proc deadloop 5 starting '' 10

	q "select distinct c_name from t_count where ( c_code='504' or c_code='000' ) and c_count_error<c_count_ok+100;" |
	tee proc-deadloop.last |
	sort |
	probe deadloop

	proc deadloop 1 finished '' 0

	)

	wait

done 2>&1 |
tee -a deadloop.log

#!/bin/sh
# $Header: /home/tino/CVSROOT/i2pinproxy/stat/cron.sh,v 1.2 2008/09/13 21:26:58 tino Exp $
#
# $Log: cron.sh,v $
# Revision 1.2  2008/09/13 21:26:58  tino
# hist.sqlite changes, now new history table is used
#
# Revision 1.1  2008/08/28 11:02:36  tino
# Added
#

#set -x
. "`dirname "$0"`/stat.inc"

proc hourly 1 starting
qh "select distinct c_name from t_last where c_code<'500' and c_timestamp>datetime('now','-1 day');" |
tee proc-hourly.last |
sort |
probe hourly

while ! proc hourly 60 finished '' $(expr 3900 - \( \( $(date +%s) - $(date -d0 +%s) \) % 3600 \))
do
	echo "OOPS, DATABASE LOCK, cannot finish, sleeping"
	sleep 10
done

#!/bin/sh

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

	q "select distinct c_name from t_count where ( c_code='666' or c_code='504' or c_code='000' ) and c_count_error<c_count_ok+100;" |
	tee proc-deadloop.last |
	sort |
	probe deadloop

	proc deadloop 1 finished '' 0

	)

	wait

done 2>&1 |
tee -a deadloop.log

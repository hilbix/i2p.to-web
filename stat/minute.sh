#!/bin/sh
# $Header: /home/tino/CVSROOT/i2pinproxy/stat/minute.sh,v 1.3 2008/09/05 15:15:11 tino Exp $
#
# $Log: minute.sh,v $
# Revision 1.3  2008/09/05 15:15:11  tino
# lockrun implemented
#
# Revision 1.2  2008/09/04 17:06:53  tino
# Increased timeout, as 90 seconds for the I2P state often triggered a warning
#
# Revision 1.1  2008/08/28 11:02:36  tino
# Added

cd "`dirname "$0"`" || exit

exec /usr/local/bin/lockrun -nq minute.lock ./minute-run.sh >/dev/null

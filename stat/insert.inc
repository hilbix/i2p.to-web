#
# $Header: /home/tino/CVSROOT/i2pinproxy/stat/insert.inc,v 1.1 2008/08/28 11:02:36 tino Exp $
#
# $Log: insert.inc,v $
# Revision 1.1  2008/08/28 11:02:36  tino
# Added
#

inserter()
{
  stamp="`date -ur "out/$1.time" +'%Y-%m-%d %H:%M:%S'`"
  mod="`sed -n 's/^Last-Modified: //pI' "out/$1.head"`"
  [ -n "$mod" ] && mod="`date -ud "$mod" +'%Y-%m-%d %H:%M:%S'`"
  head="`sed "s/'/''/g" "out/$1.head"`"
  read -r line < "out/$1.time"
  if expr + "$line" : "'[0-9]\\+','[.0-9]\\+','[0-9]\\+','[0-9]\\+','[^']*'\$" >/dev/null
  then
	code="`expr + "$line" : '\([^,]*\),'`"
	case "$code" in
	\'[23]??\')	upd=",c_count_ok=c_count_ok+1";;
	\'504\')	upd=",c_count_error=c_count_error+1";;
	*)		upd="";;
	esac
  	echo ".timeout 10000
insert or replace into t_log   values ('$1','$stamp',$line,'$head','$mod');
insert            into t_last  values ('$1','$stamp',$code);
insert or ignore  into t_count values ('$1',NULL,NULL,0,0,0);
update                 t_count set c_timestamp='$stamp', c_code=$code, c_count=c_count+1 $upd where c_name='$1';
" | sqlite stat.sqlite
  else
	echo "wrong timestamp $1: $line"
  fi
}

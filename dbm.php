<?
print_r(dba_handlers());
if ($db=dba_open("ip/test.dbm", "c", "gdbm"))
  {
    echo "Can open";
  }
else
  {
    echo "(cannot access block DB)";
  }

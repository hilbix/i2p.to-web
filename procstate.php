<?
# $Header: /home/tino/CVSROOT/i2pinproxy/procstate.php,v 1.2 2008/08/28 19:18:28 tino Exp $
#
# $Log: procstate.php,v $
# Revision 1.2  2008/08/28 19:18:28  tino
# New menu structure
#
# Revision 1.1  2008/08/28 09:52:28  tino
# Added

include("header.php");

echo "<meta http-equiv='refresh' content='1; /menu.php?refresh=20'>";

head("Procstate",1,1,0,1);
procstate(0);
?>
<a href="menu.php?refresh=20">document moved</a>
<?
foot();
?>

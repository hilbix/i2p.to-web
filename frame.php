<?
# $Header: /home/tino/CVSROOT/i2pinproxy/frame.php,v 1.1 2008/08/28 09:52:27 tino Exp $
#
# $Log: frame.php,v $
# Revision 1.1  2008/08/28 09:52:27  tino
# Added
#

include("header.php");

$p=mustparam("page",'[a-z]*');
if (!is_file("$p-top.php"))
  paramfatal("page");
$h=mustparam("host",'[-.a-z0-9]+');
?>
<FRAMESET ROWS="25%,*">
<FRAME          SRC="<?=$p?>-top.php?page=<?=$p?>&amp;host=<?=$h?>#j_<?=$h?>">
<FRAME NAME=bot SRC="<?=$p?>-bot.php?page=<?=$p?>&amp;host=<?=$h?>#j_<?=$h?>">
<?
head("$p $h",1,1,1);
foot();
?>

<?
# $Header: /home/tino/CVSROOT/i2pinproxy/olds.php,v 1.1 2008/08/28 09:52:28 tino Exp $
#
# $Log: olds.php,v $
# Revision 1.1  2008/08/28 09:52:28  tino
# Added
#

include("header.php");
head("Olds");
showpeerwarning();
?>
<a name="content"></a>

<H2>Old news</H2>
<? shownews(0, "news.old") ?>
<? foot() ?>

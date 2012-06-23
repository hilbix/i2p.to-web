<?
# $Header: /home/tino/CVSROOT/i2pinproxy/news.php,v 1.1 2008/08/28 09:52:28 tino Exp $
#
# $Log: news.php,v $
# Revision 1.1  2008/08/28 09:52:28  tino
# Added
#

include("header.php");
head("News");
showpeerwarning();

?>
<!-- strike>More News <a href='<?=prox("syndiemedia.i2p")?>threads.jsp?tags=inProxy&amp;author=Spb7kvWimvbRt9pNNy9RLY3NBrBnQqYB~ZUWu9MZLFo='>via SyndieMedia</a>
(which sometimes is very slow).</strike -->

<a name="content"></a>

<H2>News</H2>
<? shownews(0) ?>
<p>
(<a href="olds.php">Elder news</a>)
</p>

<H2>Bugs</H2>
<? shownews(0, "bugs") ?>
<? foot() ?>

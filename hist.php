<?
# $Header: /CVSROOT/www/i2p.to/web/hist.php,v 1.3 2010-08-11 06:01:36 tino Exp $
#
# $Log: hist.php,v $
# Revision 1.3  2010-08-11 06:01:36  tino
# Current version
#
# Revision 1.2  2008/09/13 21:25:13  tino
# Added qh() to query history table.  Also showtable now no more relies
# on the t_stat table, except for showing the real history entries.
#
# Revision 1.1  2008/08/28 09:52:27  tino
# Added
#

include("header.php");

$h=mustparam("host", '[-.a-z0-9]+\.i2p');

function gettime($s)
{
  #01234567890123456789
  #YYYY-MM-DD HH:MM:SS
  return mktime(substr($s,11,2), substr($s,14,2), substr($s,17,2), substr($s,5,2), substr($s,8,2), substr($s,0,4));
}

$a=qh("select * from t_last where c_name='$h' order by c_timestamp desc limit 800");
#$m=q("select max(c_total) from t_last where c_name='$h'");
$m	= 100;

$ent=count($a);
$mindate=gettime($a[0]["c_timestamp"]);
$maxdate=gettime($a[$ent-1]["c_timestamp"]);

$width	= 200;
$height	= 20*($ent+1);
$im	= ImageCreate($width,$height);
$black	= ImageColorAllocate($im, 0,0,0);
$white	= ImageColorAllocate($im, 255,255,255);
$c	= array();
$c["."]	= ImageColorAllocate($im, 255,0,0);
$c["x"]	= ImageColorAllocate($im, 255,255,0);
$c["o"]	= ImageColorAllocate($im, 0,255,0);
ImageFilledRectangle($im, 0,0,$width,$height+1,$white);

$now	= time();
$delta	= $height/($now-$maxdate);
$pos	= 0;
reset($a);
for (; $ent>0 && list(,$v)=each($a); $ent--)
  {
    $n	= gettime($v["c_timestamp"]);
    $h	= $delta*($now-$n);
    ImageFilledRectangle($im, 0, $pos, 10+$v["c_total"], $h, $c[colorcode($v["c_code"])]);
    $pos	= $h;
  }

if (ImageTypes() & IMG_GIF)
  {
    header("Content-type: image/gif");
#    ImageInterlace($im,1);
    ImageGif($im);
  }
elseif (ImageTypes() & IMG_PNG)
  {
    header("Content-type: image/png");
    ImagePng($im);
  }
elseif (ImageTypes() & IMG_JPEG)
  {
    header("Content-type: image/jpeg");
    ImageJpeg($im, "", 0.5);
  }
else
   die("missing image library");
?>

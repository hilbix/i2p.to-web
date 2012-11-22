<?
# $Header: /CVSROOT/www/i2p.to/web/timeout.php,v 1.3 2012-05-06 09:26:46 tino Exp $
#
# $Log: timeout.php,v $
# Revision 1.3  2012-05-06 09:26:46  tino
# 504 header
#
# Revision 1.2  2011-05-22 14:04:37  tino
# More help

include("header.php");
htmlcode(504, "timeout");
head("Destination unreachable");
showpeerwarning();

# PROX references: 1
?>
<a name="content"></a>

<H1>I2PinProxy 504</H1>
<P>
You see this page because the I2PinProxy encountered a 504 error.
<P>
This usually happens if an eepsite is not reachable or the router is not well integrated into the network (look at the top right:  The router must be up more than 10 minutes to be well integrated).
<P>
To have a look at the eepsite status perhaps look at the <a href="status.php">status page</a>.

<?
foot();
?>

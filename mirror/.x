#!/bin/sh
# $Header: /home/tino/CVSROOT/i2pinproxy/mirror/.x,v 1.1 2008/08/28 09:47:15 tino Exp $
#
# $Log: .x,v $
# Revision 1.1  2008/08/28 09:47:15  tino
# Added
#

cd "`dirname "$0"`" || exit

get()
{
wget -nv --timestamping --force-directories "$1"
}

getall()
{
get http://dev.i2p.$1/cgi-bin/cvsweb.cgi/~checkout~/i2p/news.xml
get http://dev.i2p.$1/cgi-bin/cvsweb.cgi/i2p/news.xml?rev=HEAD
get http://dev.i2p.$1/i2p/i2pupdate.zip.sig
get http://dev.i2p.$1/i2p/i2pupdate.zip
get http://dev.i2p.$1/i2p/i2pinstall.exe.sig
get http://dev.i2p.$1/i2p/i2pinstall.exe
get http://dev.i2p.$1/i2p/i2p.tar.bz2.sig
get http://dev.i2p.$1/i2p/i2p.tar.bz2
get http://dev.i2p.$1/i2p/hosts.txt
}

getall net
getall tin0.de

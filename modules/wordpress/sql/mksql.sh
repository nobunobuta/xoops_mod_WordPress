#!/bin/sh
sed -e "s/%prefix%/wp$1/g" mysql.tpl > mysql$1.sql

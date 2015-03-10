#!/bin/sh

grep -lR $2 $1

#grep -n -lR "upsert" ./ | grep -v ".svn"

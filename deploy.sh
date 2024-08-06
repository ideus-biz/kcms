#!/bin/sh

../rsync.sh $@ --src ./ --dst user@remote:/var/www/docroot

#
for p in "$@"
do
  if [ "$p" = "--test" ] || [ "$p" = "--dry-run" ]; then
    exit
	fi
done

echo ""
echo "Clean up SQL import files..."
i=0
for file in ./database/ECRSync/*.sql
do
  tm=`date +'%Y%m%d%H%M%S'`
  echo "$file -> $file-$tm$i.done"
  i=$((i+1))
  mv $file "$file-$tm$i.done"
done

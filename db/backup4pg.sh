#!/bin/sh

# バックアップファイルを何日分残しておくか
period=7

# バックアップファイルを保存するディレクトリ
dirpath='/home/fnote/www/fnote.com.dev/dbbackup'

# ファイル名を定義(※ファイル名で日付がわかるようにしておきます)
# PGバックアップ
filename1=htdocs_backup_`date +%y%m%d`
tar cfz $dirpath/$filename1.tar.gz /home/fnote/www/fnote.com.dev/public/

filename2=application_backup_`date +%y%m%d`
tar cfz $dirpath/$filename2.tar.gz /home/fnote/www/fnote.com.dev/application/

filename3=modules_backup_`date +%y%m%d`
tar cfz $dirpath/$filename3.tar.gz /home/fnote/www/fnote.com.dev/modules/



# システム全体
#filename3=system_backup_`date +%y%m%d`
#tar cfz $dirpath/$filename4.tar.gz /home/fnote/www/fnote.com.dev/



# パーミッション変更
chmod 750 $dirpath/$filename1.tar.gz
chmod 750 $dirpath/$filename2.tar.gz
chmod 750 $dirpath/$filename3.tar.gz
#chmod 750 $dirpath/$filename4.tar.gz

# 古いバックアップファイルを削除
oldfile=`date --date "$period days ago" +%y%m%d`
rm -f $dirpath/$oldfile.tar.gz

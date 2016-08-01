#!/bin/sh

# バックアップファイルを何日分残しておくか
period=7

# バックアップファイルを保存するディレクトリ
dirpath='/home/fnote/www/fnote.com.dev/dbbackup'

# ファイル名を定義(※ファイル名で日付がわかるようにしておきます)
filename1=db_mysqldump_`date +%Y%m%d-%H%M%S`
filename2=fnote_mysqldump_`date +%Y%m%d-%H%M%S`

# mysqldump実行（ファイルサイズ圧縮の為gzで圧縮しておきます。）
/opt/lampp/bin/mysqldump --opt --all-databases --events --default-character-set=binary -u root | gzip > $dirpath/$filename1.sql.gz
#mysqldump --opt --all-databases --events --default-character-set=binary --u root --password=db!mp | gzip > $dirpath/$filename1.sql.gz
/opt/lampp/bin/mysqldump fnote -u root | gzip > $dirpath/$filename2.sql.gz



# パーミッション変更
chmod 750 $dirpath/$filename1.sql.gz
chmod 750 $dirpath/$filename2.sql.gz

# 古いバックアップファイルを削除
oldfile=`date --date "$period days ago" +%y%m%d`
rm -f $dirpath/$oldfile.sql.gz


## --リストアコマンド
## mysql -u root -p < mybackup_xxxxxx.sql

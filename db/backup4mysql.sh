#!/bin/sh

# バックアップファイルを何日分残しておくか
period=7

# バックアップファイルを保存するディレクトリ
dirpath='/home/fnote/www/fnote.com.dev/dbbackup'

# ファイル名を定義(※ファイル名で日付がわかるようにしておきます)
filename=fnote_mysqldump_`date +%Y%m%d-%H%M%S`

# mysqldump実行（ファイルサイズ圧縮の為gzで圧縮しておきます。）
# mysqldump --opt --all-databases --events --default-character-set=binary --u root --password=db!mp | gzip > $dirpath/$filename.sql.gz
mysqldump domain_mag_dev --u dadmin --password=eclassis | gzip > $dirpath/$filename.sql.gz



# パーミッション変更
chmod 750 $dirpath/$filename.sql.gz

# 古いバックアップファイルを削除
oldfile=`date --date "$period days ago" +%y%m%d`
rm -f $dirpath/$oldfile.sql.gz


## --リストアコマンド
## mysql -u root -p < mybackup_xxxxxx.sql

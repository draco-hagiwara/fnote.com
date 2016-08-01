#!/bin/sh

# �o�b�N�A�b�v�t�@�C�����������c���Ă�����
period=7

# �o�b�N�A�b�v�t�@�C����ۑ�����f�B���N�g��
dirpath='/home/fnote/www/fnote.com.dev/dbbackup'

# �t�@�C�������`(���t�@�C�����œ��t���킩��悤�ɂ��Ă����܂�)
# PG�o�b�N�A�b�v
filename1=htdocs_backup_`date +%y%m%d`
tar cfz $dirpath/$filename1.tar.gz /home/fnote/www/fnote.com.dev/public/

filename2=application_backup_`date +%y%m%d`
tar cfz $dirpath/$filename2.tar.gz /home/fnote/www/fnote.com.dev/application/

filename3=modules_backup_`date +%y%m%d`
tar cfz $dirpath/$filename3.tar.gz /home/fnote/www/fnote.com.dev/modules/



# �V�X�e���S��
#filename3=system_backup_`date +%y%m%d`
#tar cfz $dirpath/$filename4.tar.gz /home/fnote/www/fnote.com.dev/



# �p�[�~�b�V�����ύX
chmod 750 $dirpath/$filename1.tar.gz
chmod 750 $dirpath/$filename2.tar.gz
chmod 750 $dirpath/$filename3.tar.gz
#chmod 750 $dirpath/$filename4.tar.gz

# �Â��o�b�N�A�b�v�t�@�C�����폜
oldfile=`date --date "$period days ago" +%y%m%d`
rm -f $dirpath/$oldfile.tar.gz

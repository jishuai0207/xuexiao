#!/bin/bash
curdir=$(cd `dirname $0`;pwd)
cd $curdir
#chmod +x ./shell/ngConfig.php
chmod +x ./shell/production.php
chmod -R 777 ../dumpexcel/
#./shell/ngConfig.php
./shell/production.php
cd grunt
grunt
cd ../../
rsync -av ./* root@123.57.4.246:/wwwroot/OrgCenter

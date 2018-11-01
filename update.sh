#!/bin/bash

cd ~/src

if [ $# -eq 0 ]
then

    git checkout master
    git pull

    # Call the updated version of this script
    ~/src/update.sh pulled

else

    # Nothing to composer update yet
    #composer --working-dir ~/src/public_html/api update

    cp -R ~/src/home/public_html/index.php ~/public_html/index.php
    cp -R ~/src/home/.lighttpd.conf ~/.lighttpd.conf

    webservice --backend kubernetes php7.2 restart

fi

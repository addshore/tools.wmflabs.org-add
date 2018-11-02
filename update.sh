#!/bin/bash

cd ~/src

if [ $# -eq 0 ]
then

    git checkout master
    git pull

    # Call the updated version of this script
    ~/src/update.sh pulled

else

    composer --working-dir=$HOME/src/ --no-dev --ignore-platform-reqs update

    cp -R ~/src/home/public_html/home ~/public_html/home
    cp -R ~/src/home/public_html/api ~/public_html/api
    cp -R ~/src/home/public_html/swagger ~/public_html/swagger
    cp -R ~/src/vendor/swagger-api/swagger-ui/dist ~/public_html/swagger-dist
    cp -R ~/src/home/.lighttpd.conf ~/.lighttpd.conf

    webservice --backend kubernetes php7.2 restart

fi

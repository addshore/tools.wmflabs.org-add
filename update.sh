#!/bin/bash

cd ~/src

git checkout master
git pull

composer --working-dir ~/src/public_html/api update

cp -R ~/src/home/public_html/index.php ~/public_html/index.php
cp -R ~/src/home/.lighttpd.conf ~/.lighttpd.conf

webservice restart

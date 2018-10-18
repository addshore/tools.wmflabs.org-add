#!/bin/bash

cd ~/src

echo "Pulling code"
git pull

echo "Updating public_html"
cp -R ~/src/public_html ~/public_html

webservice --backend kubernetes restart

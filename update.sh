#!/bin/bash

git pull
cp -R ~/src/public_html ~/public_html/
webservice --backend kubernetes restart

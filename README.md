# tools.wmflabs.org-add

###Prod

Setup:
```
git clone https://github.com/addshore/tools.wmflabs.org-add.git ~/src
~/src/update.sh
```

Update:
```
~/src/update.sh
```

###Dev

Run:
```
docker-compose up --build
```

Get a shell:
```
docker-compose exec tool bash
```
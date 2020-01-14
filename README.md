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

Access the site:
https://tools.wmflabs.org/add

###Dev

Run:
```
docker-compose up --build
```

Access the site:
http://localhost:3333/add

Get a shell:
```
docker-compose exec tool bash
```
FROM docker-registry.tools.wmflabs.org/toollabs-php72-web:latest

RUN echo 'tools' > /etc/wmcs-project

RUN useradd -u 50000 -ms /bin/bash tools.add

USER tools.add
WORKDIR /home/tools.add
ENTRYPOINT /usr/bin/webservice-runner --type lighttpd --port 2468

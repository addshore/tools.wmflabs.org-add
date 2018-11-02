FROM docker-registry.tools.wmflabs.org/toollabs-php72-web:latest

# webservice-runner needs this file to exist and say we are running in tools
RUN echo 'tools' > /etc/wmcs-project

# webservice-runner requires that the user be prefixed with tools.
# webservice-runner requires that the uid be >= 50000
RUN useradd -u 50000 -ms /bin/bash tools.add

USER tools.add
# webservice-runner will serve data from the home dir of the running user (not project data dir)
WORKDIR /home/tools.add
# webservice-runner needs a type, and port specified
# Server port 2468 is used to determine if we are running in a dev env or not
ENTRYPOINT /usr/bin/webservice-runner --type lighttpd --port 2468

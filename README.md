# dripline-web
web2.0 implementation of project8/dripline

# dockerish things

## Image details
The dockerfile builds in SSL support and automatically generates default certificates. These certificates are valid for encription but are local. Your browser will warn that the source is not known. If we want to use this for real we should figure out how to get legit certificates and they should *not* be stored in a repo, they should be local to the host system and volume mounted to the container.

## AMQP
For amqp we want to use the `rabbitmq:3-management` image.

## PHP
The php image (base for this Dockerfile) doesn't play well in the foreground (ie `-it` run options), you should always run it detatched (`-d`) and then use the `docker exec` command to attach if needed.

## demos
For now there are demo scripts from the [AMQP tutorial](http://www.rabbitmq.com/tutorials/tutorial-six-javascript.html). To run them build the Dockerfile in the scripts subdirectory. The default command is to run the tutorial's server, but both are included.

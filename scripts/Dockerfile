FROM node:latest

RUN mkdir /root/scripts
ADD rpc_server.js /root/scripts/rpc_server.js
ADD rpc_client.js /root/scripts/rpc_client.js

RUN npm install amqplib

CMD node /root/scripts/rpc_server.js

#!/bin/sh

ufw disable
ufw --force reset

ufw default deny incoming
ufw default allow outgoing

ufw allow 9993/udp #allow zerotier
ufw allow OpenSSH #allow SSH
ufw allow 5671,5672,15671,15672,4369,25672/tcp #allow Rabbit

ufw allow proto tcp from any to any port 80,443 #allow HTTP, HTTPS
ufw allow mysql #allow mysql

ufw logging low #default logging behavior

ufw --force enable



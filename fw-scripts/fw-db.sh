#!/bin/sh

ufw disable
ufw --force reset

ufw default deny incoming
ufw default allow outgoing

ufw allow 9993/udp
ufw allow OpenSSH
ufw allow 5671,5672,15671,15672,4369,25672/tcp

ufw logging low

ufw --force enable



#!/bin/sh

ufw disable
ufw --force reset

ufw default deny incoming
ufw default allow outgoing

ufw deny http
ufw deny https

ufw allow from 10.147.19.109 to any port 9993
ufw allow from 10.147.19.109 to any port 5671,5672,15671,15672,4369,25672

ufw logging low

ufw --force enable



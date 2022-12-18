#!/bin/sh

ufw disable
ufw --force reset

ufw default deny incoming
ufw default allow outgoing

ufw deny http
ufw deny https

sudo ufw allow 4369
sudo ufw allow 5671
sudo ufw allow 5672
sudo ufw allow 25672
sudo ufw allow 35672:35682/tcp
sudo ufw allow 15672
sudo ufw allow 61613
sudo ufw allow 61614
sudo ufw allow 1883
sudo ufw allow 8883
sudo ufw allow 15674
sudo ufw allow 15675

sudo ufw deny out 80
sudo ufw deny out 443

ufw logging low

ufw --force enable



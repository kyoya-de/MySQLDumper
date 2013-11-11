#!/bin/bash

RC_LOCAL_REPLACE=$(cat /vagrant/files/etc/rc.local)
sed -i -e "s/^exit 0/${RC_LOCAL_REPLACE//\//\\/}\nexit 0/g" /etc/rc.local

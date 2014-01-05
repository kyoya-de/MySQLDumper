#!/bin/bash

head -n-1 /etc/rc.local|cat - /vagrant/files/etc/rc.local > /etc/rc.local

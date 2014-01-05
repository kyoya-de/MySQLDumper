#!/bin/sh
grep 'precise64.msd-dev.local' /etc/hosts 2>/dev/null >/dev/null
if [ $? -ne 0 ]; then
    sed -i 's/precise64/precise64.msd-dev.local precise64/g' /etc/hosts
fi

apt-get -y -qq update >/dev/null || exit $?
apt-get -y -qq install python-software-properties >/dev/null || exit $?
add-apt-repository -y ppa:ondrej/php5-oldstable 2>/dev/null >/dev/null || exit $?
apt-get -y -qq update >/dev/null || exit $?
apt-get -y -qq install build-essential vim vim-common bash-completion aufs-tools >/dev/null || exit $?
update-alternatives --quiet --set editor /usr/bin/vim.basic >/dev/null || exit $?

cp /vagrant/files/etc/profile.d/bash_aliases.sh /etc/profile.d/bash_aliases.sh

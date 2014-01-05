file { "/srv/msd-dev.local":
    ensure => directory,
}

file { "/media/msd-dev.local.aufs-data":
    owner => "www-data",
    group => "vagrant",
    mode => "ug+rwX,o-w,o+rX",
    recurse => true,
    ensure => directory,
}

exec { "Add aufs mount to fstab":
    command => "cp /etc/fstab /etc/fstab.puppet; /bin/cat /vagrant/files/etc/fstab >> /etc/fstab",
    unless => "grep '/srv/msd-dev.local' /etc/fstab",
}

exec { "mount /srv/msd-dev.local":
    onlyif => "grep '/srv/msd-dev.local' /etc/fstab",
    require => [
        Exec["Add aufs mount to fstab"],
        File["/srv/msd-dev.local"],
        File["/media/msd-dev.local.aufs-data/"]
    ],
    notify => Service["apache2"],
}

exec { "Adding auto-mount to rc.local.":
    command => 'cp /etc/rc.local /etc/rc.local.puppet; /bin/bash /vagrant/files/rc.local-patch.sh',
    unless => "grep 'mount /srv/msd-dev.local' /etc/rc.local",
}

file { "/srv/msd-dev.local/app/cache":
    owner => "www-data",
    group => "vagrant",
    mode => "ug+rwX,o-w,o+rX",
    recurse => true,
    require => Exec["mount /srv/msd-dev.local"],
}

file { "/srv/msd-dev.local/app/logs":
    owner => "www-data",
    group => "vagrant",
    mode => "ug+rwX,o-w,o+rX",
    recurse => true,
    require => Exec["mount /srv/msd-dev.local"],
}

file { "/srv/msd-dev.local/app/data":
    owner => "www-data",
    group => "vagrant",
    mode => "ug+rwX,o-w,o+rX",
    recurse => true,
    require => Exec["mount /srv/msd-dev.local"],
}

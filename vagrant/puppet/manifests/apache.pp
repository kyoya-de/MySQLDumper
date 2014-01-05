package { "apache2": }

# exec { "service apache2 restart":
#     require => Package["apache2"]
# }

exec { "a2enmod rewrite":
    require => Package["apache2"],
    notify => Service["apache2"]
}

file { "/etc/apache2/sites-available/msd-dev.local.conf": 
    source => "/vagrant/files/etc/apache2/sites-available/msd-dev.local.conf",
    require => Package["apache2"]
}

exec { "a2ensite msd-dev.local.conf":
    require => File["/etc/apache2/sites-available/msd-dev.local.conf"],
    notify => Service["apache2"]
}
    
service { "apache2":
    ensure     => running,
    enable     => true,
    hasrestart => true,
    hasstatus  => true,
    require    => Package["apache2"]
}

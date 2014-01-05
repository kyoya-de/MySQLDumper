exec { "app/console cache:clear":
    cwd => "/srv/msd-dev.local/",
    user => "www-data",
    group => "vagrant"
}
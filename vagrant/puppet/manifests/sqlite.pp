package { "sqlite3": }
exec { "user-db-structure":
    command => "sqlite3 /srv/msd-dev.local/app/data/users.sq3 < /srv/msd-dev.local/docs/structure.sql",
    unless => "test -s /srv/msd-dev.local/app/data/users.sq3",
    require => [ Package["sqlite3"], Exec["mount /srv/msd-dev.local"] ]
}

exec { "user-db-data":
    command => "sqlite3 /srv/msd-dev.local/app/data/users.sq3 < /srv/msd-dev.local/docs/data.sql",
    require => Exec["user-db-structure"]
}

exec { "user-db-data_dev":
    command => "sqlite3 /srv/msd-dev.local/app/data/users.sq3 < /srv/msd-dev.local/docs/data_dev.sql",
    require => Exec["user-db-data"]
}

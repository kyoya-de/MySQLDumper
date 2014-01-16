package { "mysql-client": }
package { "mysql-server": }
package { "mysql-common": }

exec { "Create MySQL-Test-DB":
  command => "mysql -uroot -e 'CREATE DATABASE `msd-dev` DEFAULT CHARSET utf8 COLLATE utf8_general_ci'",
  unless => "test -n \"`mysql -uroot -sNe \"SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'msd-dev'\"`\"",
  require => [
    Package["mysql-common"],
    Package["mysql-client"],
    Package["mysql-server"]
  ]
}

exec { "Create MySQL-Test-User":
  command => "mysql -uroot -e 'GRANT ALL PRIVILEGES ON `msd-dev`.* TO \"msd-dev\"@\"localhost\" IDENTIFIED BY \"msd\"'",
  unless => "test -n \"`mysql -uroot -sNe \"SELECT GRANTEE FROM INFORMATION_SCHEMA.USER_PRIVILEGES WHERE GRANTEE = '\'msd-dev\'@\'localhost\''\"`\"",
  require => Exec["Create MySQL-Test-DB"]
}
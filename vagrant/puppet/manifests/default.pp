Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/' ] }

import "aufs.pp"
import "apache.pp"
import "sqlite.pp"
import "php.pp"
import "mysql.pp"

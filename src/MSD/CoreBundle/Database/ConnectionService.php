<?php

namespace MSD\CoreBundle\Database;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

use MSD\UserBundle\Entity\UserDatabase;
use MSD\CoreBundle\Doctrine\DBAL\Platforms\MySqlPlatform;

class ConnectionService
{

    /**
     * @param UserDatabase $database
     * @param string $currentDbName
     *
     * @return Connection
     */
    public function createConnection($database, $currentDbName = null)
    {
        $connection = array(
            'driver' => $database->getDriver(),
        );

        if ($database->getUser() != '') {
            $connection['user'] = $database->getUser();
        }

        if ($database->getPassword() != '') {
            $connection['password'] = $database->getPassword();
        }

        if ($database->getHost() != '') {
            $connection['host'] = $database->getHost();
        }

        if ($database->getPort() > 0) {
            $connection['port'] = $database->getPort();
        }

        if ($database->getDbName() != '') {
            $connection['dbname'] = (null === $currentDbName) ? $database->getDbName() : $currentDbName;
        }
        if ($database->getUnixSocket() != '') {
            $connection['unix_socket'] = $database->getUnixSocket();
        }

        if ($database->getPath() != '') {
            $connection['path'] = $database->getPath();
        }

        if ($database->getCharset() != '') {
            $connection['charset'] = $database->getCharset();
        }

        if ($database->getDriverOptions()->count() > 0) {
            $connection['driverOptions'] = $database->getDriverOptions()->toArray();
        }

        $connection['platform'] = new MySqlPlatform();

        return DriverManager::getConnection($connection, new Configuration());
    }
}
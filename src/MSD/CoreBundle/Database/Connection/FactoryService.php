<?php

namespace MSD\CoreBundle\Database\Connection;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\SecurityContext;

use MSD\UserBundle\Entity\User;
use MSD\UserBundle\Entity\UserDatabase;

/**
 * Class FactoryService
 *
 * @package MSD\CoreBundle\Database\Connection
 */
class FactoryService
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        /**
         * @var UserDatabase $database
         * @var User $user
         * @var SecurityContext $securityContext
         */
        $securityContext = $this->container->get('security.context');
        if (!($token = $securityContext->getToken())) {
            return null;
        }
        $user = $token->getUser();

        $database = $user->getDatabases()->get(0);
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
            $connection['dbname'] = $database->getDbName();
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

        return DriverManager::getConnection($connection, new Configuration());
    }
} 
<?php

namespace MSD\CoreBundle\Database\Connection;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Collections\Collection;

use MSD\UserBundle\Entity\User;
use MSD\UserBundle\Entity\UserDatabase;
use MSD\CoreBundle\Database\Connection\NotFoundException;
use MSD\CoreBundle\Doctrine\DBAL\Platforms\MySqlPlatform;

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
     * @param Container $container
     *
     * @return Connection
     */
    public static function getConnection(Container $container)
    {
        /**
         * @var UserDatabase $database
         * @var User $user
         * @var SecurityContext $securityContext
         * @var Session $session
         * @var Collection|UserDatabase[] $connections
         */
        $securityContext = $container->get('security.context');
        if (!($token = $securityContext->getToken())) {
            return null;
        }
        $user = $token->getUser();
        $session = $container->get('session');
        $connections = $user->getDatabases();
        if (null !== ($connectionId = $session->get('connection.current'))) {
            $database = false;
            foreach ($connections as $userConnection) {
                if ($userConnection->getId() == $connectionId) {
                    $database = $userConnection;
                    break;
                }
            }
        } else {
            $database = $connections->get(0);
        }

        if (!$database) {
            throw new NotFoundException('Unknown connection ID!');
        }

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
            $connection['dbname'] = $session->get('database.current', $database->getDbName());
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
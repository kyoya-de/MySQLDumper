<?php

namespace MSD\CoreBundle\Database\Connection;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use MSD\UserBundle\Entity\User;
use MSD\UserBundle\Entity\UserDatabase;
use MSD\CoreBundle\Doctrine\DBAL\Platforms\MySqlPlatform;

/**
 * Class FactoryService
 *
 * @package MSD\CoreBundle\Database\Connection
 */
class FactoryService
{
    /**
     * @param Container $container
     *
     * @return Connection
     */
    public static function getConnection(Container $container)
    {
        /**
         * @var UserDatabase $database
         * @var UserDatabase $db
         * @var User $user
         * @var SecurityContext $securityContext
         * @var Request $request
         * @var Session $session
         */
        $securityContext = $container->get('security.context');
        if (!($token = $securityContext->getToken())) {
            return null;
        }
        $user = $token->getUser();

        $database = $user->getCurrentConnection();
        if (null !== ($requestDatabaseId = $container->get('request')->get('_connection'))) {
            foreach ($user->getDatabases() as $db) {
                if ($requestDatabaseId == $db->getId()) {
                    $database = $db;
                    $user->setCurrentConnection($database);
                    $em = $container->get('doctrine')->getManager();
                    $em->persist($user);
                    $em->flush();
                }
            }
        }

        $session = $container->get('session');
        if (null !== ($requestDbName = $container->get('request')->get('_dbName'))) {
            $session->set('_dbName', $requestDbName);
        }

        $database->setDbName($session->get('_dbName'));

        $connection = array(
            'driver' => $database->getDriver(),
            'platform' => new MySqlPlatform(),
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
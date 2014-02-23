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
     * @throws NotFoundException
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

        $currentDbName = $session->get('database.current', $database->getDbName());
        $connectionService = $container->get('msd.db_connection.service');

        return $connectionService->createConnection($database, $currentDbName);
    }
}
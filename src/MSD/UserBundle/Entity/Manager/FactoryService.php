<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 14.11.13
 * Time: 16:18
 */

namespace MSD\UserBundle\Entity\Manager;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use MSD\UserBundle\Entity\User;

class FactoryService
{
    /**
     * @var User
     */
    protected $user;

    public function __construct($securityContext)
    {
        $this->user = $securityContext->getToken()->getUser();
    }

    /**
     * @return EntityManager
     */
    public function getManager()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/../../../../'));
        $connection = array(
            'driver' => $this->user->getDbDriver(),
            'host' => $this->user->getDbHost(),
            'port' => $this->user->getDbPort(),
            'user' => $this->user->getDbUser(),
            'password' => $this->user->getDbPass(),
            'dbname' => $this->user->getDbName(),
        );
        var_dump($connection);

        return EntityManager::create($connection, $config);
    }
} 
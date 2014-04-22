<?php

namespace MSD\CoreBundle\Database\Metadata;

use PDO;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Schemata
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getSchemata()
    {
        $connection = $this->container->get('msd.db_connection');
        $statement = $connection->query('SELECT * FROM INFORMATION_SCHEMA.SCHEMATA');
        $schemata = array();
        while (false !== ($row = $statement->fetch(PDO::FETCH_ASSOC))) {
            $schemata[] = new SchemataDefinition($row);
        }

        return $schemata;
    }
}
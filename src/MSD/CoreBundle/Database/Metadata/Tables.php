<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 22.04.14
 * Time: 13:13
 */

namespace MSD\CoreBundle\Database\Metadata;

use PDO;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Tables
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getTables($dbName)
    {
        $connection = $this->container->get('msd.db_connection');
        $sql        = 'SHOW TABLE STATUS FROM ' . $connection->quoteIdentifier($dbName);
        $statement  = $connection->query($sql);

        $tables = array();
        while (false !== ($row = $statement->fetch(PDO::FETCH_ASSOC))) {
            $tables[] = new TableDefinition($row);
        }

        return $tables;
    }
}
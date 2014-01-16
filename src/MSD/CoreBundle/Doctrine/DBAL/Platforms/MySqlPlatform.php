<?php

namespace MSD\CoreBundle\Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Platforms\MySqlPlatform as DoctrineMySqlPlatform;

/**
 * Class MySqlPlatform
 *
 * @package MSD\CoreBundle\Doctrine\DBAL\Platforms
 */
class MySqlPlatform extends DoctrineMySqlPlatform
{
    /**
     * @return string
     */
    public function getListTablesSQL()
    {
        return "SHOW FULL TABLES WHERE Table_type = 'BASE TABLE' OR Table_type = 'SYSTEM VIEW'";
    }
} 
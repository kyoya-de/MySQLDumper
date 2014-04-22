<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 22.04.14
 * Time: 12:41
 */

namespace MSD\CoreBundle\Database\Metadata;

class SchemataDefinition
{
    protected $name;
    protected $defaultCharset;
    protected $defaultCollation;
    protected $createTableSQL;

    public function __construct($schemaDef)
    {
        $schemaDef = array_change_key_case($schemaDef, CASE_LOWER);
        $this->setName($schemaDef['schema_name']);
        $this->setDefaultCharset($schemaDef['default_character_set_name']);
        $this->setDefaultCollation($schemaDef['default_collation_name']);
    }

    /**
     * @param mixed $createTableSQL
     */
    public function setCreateTableSQL($createTableSQL)
    {
        $this->createTableSQL = $createTableSQL;
    }

    /**
     * @return mixed
     */
    public function getCreateTableSQL()
    {
        return $this->createTableSQL;
    }

    /**
     * @param mixed $defaultCharset
     */
    public function setDefaultCharset($defaultCharset)
    {
        $this->defaultCharset = $defaultCharset;
    }

    /**
     * @return mixed
     */
    public function getDefaultCharset()
    {
        return $this->defaultCharset;
    }

    /**
     * @param mixed $defaultCollation
     */
    public function setDefaultCollation($defaultCollation)
    {
        $this->defaultCollation = $defaultCollation;
    }

    /**
     * @return mixed
     */
    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
} 
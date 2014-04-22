<?php
namespace MSD\CoreBundle\Database\Metadata;

class TableDefinition
{
    protected $name;
    protected $engine;
    protected $version;
    protected $rowFormat;
    protected $rows;
    protected $averageRowLength;
    protected $dataLength;
    protected $maxDataLength;
    protected $indexLength;
    protected $dataFree;
    protected $autoIncrement;
    protected $createTime;
    protected $updateTime;
    protected $checkTime;
    protected $collation;
    protected $checksum;
    protected $createOptions;
    protected $comment;

    public function __construct($tableDef)
    {
        $tableDef = array_change_key_case($tableDef, CASE_LOWER);
        $this->setName($tableDef['name']);
        $this->setEngine($tableDef['engine']);
        $this->setVersion($tableDef['version']);
        $this->setRowFormat($tableDef['row_format']);
        $this->setRows($tableDef['rows']);
        $this->setAverageRowLength($tableDef['avg_row_length']);
        $this->setDataLength($tableDef['data_length']);
        $this->setMaxDataLength($tableDef['max_data_length']);
        $this->setIndexLength($tableDef['index_length']);
        $this->setDataFree($tableDef['data_free']);
        $this->setAutoIncrement($tableDef['auto_increment']);
        $this->setCreateTime($tableDef['create_time']);
        $this->setUpdateTime($tableDef['update_time']);
        $this->setCheckTime($tableDef['check_time']);
        $this->setCollation($tableDef['collation']);
        $this->setChecksum($tableDef['checksum']);
        $this->setCreateOptions($tableDef['create_options']);
        $this->setComment($tableDef['comment']);
    }

    /**
     * @param mixed $autoIncrement
     */
    public function setAutoIncrement($autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * @return mixed
     */
    public function getAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * @param mixed $averageRowLength
     */
    public function setAverageRowLength($averageRowLength)
    {
        $this->averageRowLength = $averageRowLength;
    }

    /**
     * @return mixed
     */
    public function getAverageRowLength()
    {
        return $this->averageRowLength;
    }

    /**
     * @param mixed $checkTime
     */
    public function setCheckTime($checkTime)
    {
        $this->checkTime = $checkTime;
    }

    /**
     * @return mixed
     */
    public function getCheckTime()
    {
        return $this->checkTime;
    }

    /**
     * @param mixed $checksum
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;
    }

    /**
     * @return mixed
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * @param mixed $collation
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
    }

    /**
     * @return mixed
     */
    public function getCollation()
    {
        return $this->collation;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $createOptions
     */
    public function setCreateOptions($createOptions)
    {
        $this->createOptions = $createOptions;
    }

    /**
     * @return mixed
     */
    public function getCreateOptions()
    {
        return $this->createOptions;
    }

    /**
     * @param mixed $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param mixed $dataFree
     */
    public function setDataFree($dataFree)
    {
        $this->dataFree = $dataFree;
    }

    /**
     * @return mixed
     */
    public function getDataFree()
    {
        return $this->dataFree;
    }

    /**
     * @param mixed $dataLength
     */
    public function setDataLength($dataLength)
    {
        $this->dataLength = $dataLength;
    }

    /**
     * @return mixed
     */
    public function getDataLength()
    {
        return $this->dataLength;
    }

    /**
     * @param mixed $engine
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    /**
     * @return mixed
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param mixed $indexLength
     */
    public function setIndexLength($indexLength)
    {
        $this->indexLength = $indexLength;
    }

    /**
     * @return mixed
     */
    public function getIndexLength()
    {
        return $this->indexLength;
    }

    /**
     * @param mixed $maxDataLength
     */
    public function setMaxDataLength($maxDataLength)
    {
        $this->maxDataLength = $maxDataLength;
    }

    /**
     * @return mixed
     */
    public function getMaxDataLength()
    {
        return $this->maxDataLength;
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

    /**
     * @param mixed $rowFormat
     */
    public function setRowFormat($rowFormat)
    {
        $this->rowFormat = $rowFormat;
    }

    /**
     * @return mixed
     */
    public function getRowFormat()
    {
        return $this->rowFormat;
    }

    /**
     * @param mixed $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return mixed
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param mixed $updateTime
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }
} 
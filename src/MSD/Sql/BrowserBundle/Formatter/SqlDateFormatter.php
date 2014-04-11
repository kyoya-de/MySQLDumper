<?php

namespace MSD\Sql\BrowserBundle\Formatter;


use Symfony\Component\DependencyInjection\Container;

class SqlDateFormatter implements DataTypeInterface
{
    /**
     * TODO: make this configurable or translatable
     *
     * @var array
     */
    protected $dateFormats = array(
        'DATE' => 'd.m.Y',
        'TIME' => 'H:i:s',
        'DATETIME' => 'd.m.Y H:i:s',
        'TIMESTAMP' => 'd.m.Y H:i:s',
    );

    /**
     * @param mixed $fieldData
     * @param string $dataType
     *
     * @return string
     */
    public function format($fieldData, $dataType)
    {
        $time = strtotime($fieldData);
        if (false === $time) {
            return "";
        }

        return date($this->dateFormats[$dataType], $time);
    }
}
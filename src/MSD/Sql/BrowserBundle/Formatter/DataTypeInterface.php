<?php

namespace MSD\Sql\BrowserBundle\Formatter;


interface DataTypeInterface
{
    /**
     * @param mixed $fieldData
     * @param string $dataType
     *
     * @return string
     */
    public function format($fieldData, $dataType);
} 
<?php

namespace MSD\Sql\BrowserBundle\Formatter;

class IntegerFormatter implements DataTypeInterface
{
    /**
     * @param mixed  $fieldData
     * @param string $dataType
     *
     * @return string
     */
    public function format($fieldData, $dataType)
    {
        return number_format($fieldData, 0, ',', '.');
    }
}
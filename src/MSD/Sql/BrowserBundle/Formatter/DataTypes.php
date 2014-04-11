<?php

namespace MSD\Sql\BrowserBundle\Formatter;


class DataTypes
{
    /**
     * @var DataTypeInterface[]
     */
    protected $formatter = array();

    public function addFormatter(DataTypeInterface $formatter, $suitableDataTypes)
    {
        $suitableDataTypes = explode(',', $suitableDataTypes);
        foreach ($suitableDataTypes as $suitableDataType) {
            $suitableDataType = trim($suitableDataType);
            $this->formatter[strtolower($suitableDataType)] = $formatter;
        }
    }

    public function formatField($fieldData, $dataType)
    {
        $dataTypeId = strtolower($dataType);
        if (!isset($this->formatter[$dataTypeId])) {
            return $fieldData;
        }

        return $this->formatter[$dataTypeId]->format($fieldData, strtoupper($dataType));
    }
} 
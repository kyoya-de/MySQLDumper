<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 11.04.14
 * Time: 13:38
 */

namespace MSD\Sql\BrowserBundle\Twig\Extension;

use MSD\Sql\BrowserBundle\Formatter\DataTypes;
use Twig_Extension;

class DataTypeFormatter extends Twig_Extension
{
    /**
     * @var DataTypes
     */
    protected $dataTypeFormatter;

    public function __construct(DataTypes $dataTypeFormatter)
    {
        $this->dataTypeFormatter = $dataTypeFormatter;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'formatField',
                array($this->dataTypeFormatter, 'formatField'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'formatDataType';
    }
}
<?php

namespace MSD\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DriverOption
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DriverOption
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="option", type="integer")
     */
    private $option;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var UserDatabase
     *
     * @ORM\ManyToOne(targetEntity="UserDatabase", inversedBy="driverOptions")
     */
    private $database;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set option
     *
     * @param integer $option
     * @return DriverOption
     */
    public function setOption($option)
    {
        $this->option = $option;
    
        return $this;
    }

    /**
     * Get option
     *
     * @return integer 
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return DriverOption
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set databases
     *
     * @param UserDatabase $database
     * @return DriverOption
     */
    public function setDatabases(UserDatabase $database = null)
    {
        $this->database = $database;
    
        return $this;
    }

    /**
     * Get databases
     *
     * @return UserDatabase
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Set database
     *
     * @param UserDatabase $database
     * @return DriverOption
     */
    public function setDatabase(UserDatabase $database = null)
    {
        $this->database = $database;
    
        return $this;
    }
}
<?php

namespace MSD\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserDatabase
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserDatabase
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
     * @var string
     *
     * @ORM\Column(name="driver", type="string", length=32)
     */
    private $driver;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="host", type="string", length=255)
     */
    private $host;

    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="smallint")
     */
    private $port;

    /**
     * @var string
     *
     * @ORM\Column(name="unixSocket", type="string", length=255)
     */
    private $unixSocket;

    /**
     * @var string
     *
     * @ORM\Column(name="dbName", type="string", length=255)
     */
    private $dbName;

    /**
     * @var string
     *
     * @ORM\Column(name="charset", type="string", length=255)
     */
    private $charset;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="text")
     */
    private $path;

    /**
     * @var DriverOption[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DriverOption", mappedBy="database")
     */
    private $driverOptions;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="databases")
     */
    private $msdUser;

    public function __construct()
    {
        $this->driverOptions = new ArrayCollection();
    }

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
     * Set driver
     *
     * @param string $driver
     * @return UserDatabase
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    
        return $this;
    }

    /**
     * Get driver
     *
     * @return string 
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return UserDatabase
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return UserDatabase
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set host
     *
     * @param string $host
     * @return UserDatabase
     */
    public function setHost($host)
    {
        $this->host = $host;
    
        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return UserDatabase
     */
    public function setPort($port)
    {
        $this->port = $port;
    
        return $this;
    }

    /**
     * Get port
     *
     * @return integer 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set unixSocket
     *
     * @param string $unixSocket
     * @return UserDatabase
     */
    public function setUnixSocket($unixSocket)
    {
        $this->unixSocket = $unixSocket;
    
        return $this;
    }

    /**
     * Get unixSocket
     *
     * @return string 
     */
    public function getUnixSocket()
    {
        return $this->unixSocket;
    }

    /**
     * Set dbName
     *
     * @param string $dbName
     * @return UserDatabase
     */
    public function setDbName($dbName)
    {
        $this->dbName = $dbName;
    
        return $this;
    }

    /**
     * Get dbName
     *
     * @return string 
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * Set charset
     *
     * @param string $charset
     * @return UserDatabase
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    
        return $this;
    }

    /**
     * Get charset
     *
     * @return string 
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return UserDatabase
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set msdUser
     *
     * @param \MSD\UserBundle\Entity\User $msdUser
     * @return UserDatabase
     */
    public function setMsdUser(\MSD\UserBundle\Entity\User $msdUser = null)
    {
        $this->msdUser = $msdUser;
    
        return $this;
    }

    /**
     * Get msdUser
     *
     * @return \MSD\UserBundle\Entity\User 
     */
    public function getMsdUser()
    {
        return $this->msdUser;
    }

    /**
     * Add driverOptions
     *
     * @param \MSD\UserBundle\Entity\DriverOption $driverOptions
     * @return UserDatabase
     */
    public function addDriverOption(\MSD\UserBundle\Entity\DriverOption $driverOptions)
    {
        $this->driverOptions[] = $driverOptions;
    
        return $this;
    }

    /**
     * Remove driverOptions
     *
     * @param \MSD\UserBundle\Entity\DriverOption $driverOptions
     */
    public function removeDriverOption(\MSD\UserBundle\Entity\DriverOption $driverOptions)
    {
        $this->driverOptions->removeElement($driverOptions);
    }

    /**
     * Get driverOptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDriverOptions()
    {
        return $this->driverOptions;
    }
}
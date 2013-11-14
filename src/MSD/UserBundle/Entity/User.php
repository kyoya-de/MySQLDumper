<?php

namespace MSD\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=64)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="dbDriver", type="string", length=100)
     */
    private $dbDriver;

    /**
     * @var string
     *
     * @ORM\Column(name="dbHost", type="string", length=255)
     */
    private $dbHost;

    /**
     * @var string
     *
     * @ORM\Column(name="dbUser", type="string", length=100)
     */
    private $dbUser;

    /**
     * @var string
     *
     * @ORM\Column(name="dbPass", type="string", length=100)
     */
    private $dbPass;

    /**
     * @var string
     *
     * @ORM\Column(name="dbPort", type="integer")
     */
    private $dbPort;

    /**
     * @var string
     *
     * @ORM\Column(name="dbName", type="string", length=255)
     */
    private $dbName;

    /**
     * @var Role[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->settings = new ArrayCollection();

        $this->active = true;
        $this->salt = md5(uniqid(null, true));
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
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
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return Boolean true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return Boolean true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return $this->active;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return Boolean true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return Boolean true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->active;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * Add roles
     *
     * @param RoleInterface $role
     *
     * @return User
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param RoleInterface $role
     */
    public function removeRole(RoleInterface $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     *
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array($this->id));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     *
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        list ($this->id) = unserialize($serialized);
    }

    /**
     * Set dbDriver
     *
     * @param string $dbDriver
     * @return User
     */
    public function setDbDriver($dbDriver)
    {
        $this->dbDriver = $dbDriver;
    
        return $this;
    }

    /**
     * Get dbDriver
     *
     * @return string 
     */
    public function getDbDriver()
    {
        return $this->dbDriver;
    }

    /**
     * Set dbHost
     *
     * @param string $dbHost
     * @return User
     */
    public function setDbHost($dbHost)
    {
        $this->dbHost = $dbHost;
    
        return $this;
    }

    /**
     * Get dbHost
     *
     * @return string 
     */
    public function getDbHost()
    {
        return $this->dbHost;
    }

    /**
     * Set dbUser
     *
     * @param string $dbUser
     * @return User
     */
    public function setDbUser($dbUser)
    {
        $this->dbUser = $dbUser;
    
        return $this;
    }

    /**
     * Get dbUser
     *
     * @return string 
     */
    public function getDbUser()
    {
        return $this->dbUser;
    }

    /**
     * Set dbPass
     *
     * @param string $dbPass
     * @return User
     */
    public function setDbPass($dbPass)
    {
        $this->dbPass = $dbPass;
    
        return $this;
    }

    /**
     * Get dbPass
     *
     * @return string 
     */
    public function getDbPass()
    {
        return $this->dbPass;
    }

    /**
     * Set dbPort
     *
     * @param integer $dbPort
     * @return User
     */
    public function setDbPort($dbPort)
    {
        $this->dbPort = $dbPort;
    
        return $this;
    }

    /**
     * Get dbPort
     *
     * @return integer 
     */
    public function getDbPort()
    {
        return $this->dbPort;
    }

    /**
     * Set dbName
     *
     * @param string $dbName
     * @return User
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
}
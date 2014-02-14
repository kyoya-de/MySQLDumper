<?php

namespace MSD\CoreBundle\Twig\Extension;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Process\Process;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\DBAL\Connection;
use MSD\CoreBundle\Database\Connection\FactoryService;
use MSD\UserBundle\Entity\User;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class MenuBuilder
 *
 * @package MSD\CoreBundle\Twig\Extension
 */
class MenuBuilder extends Twig_Extension
{
    /**
     * @var Connection
     */
    private $dbService;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var TwigEngine
     */
    private $engine;

    /**
     * @param Container  $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->dbService = $container->get('msd.db_connection');
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('buildMenu', array($this, 'buildMenu'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @return string
     */
    public function buildMenu()
    {
        if (!$this->dbService) {
            return '&nbsp;';
        }

        return $this->getEngine()->render(
            'MSDCoreBundle:Menu:layout.html.twig',
            array(
                'connections' => $this->getConnections(),
                'currentConnection' => $this->getCurrentConnection(),

                'databases' => $this->getDatabases('sort'),
                'currentDatabase' => $this->getCurrentDatabase(),

                'tables' => $this->getTables('sort'),
                'currentTable' => $this->getCurrentTable(),
            )
        );
    }

    /**
     * @param Callable $sortCallback
     *
     * @return string
     */
    protected function getTables($sortCallback = null)
    {
        $tables = $this->dbService->getSchemaManager()->listTableNames();

        if (is_callable($sortCallback)) {
            call_user_func_array($sortCallback, array(&$tables));
        }

        return $tables;
    }

    /**
     * @param Callable $sortCallback
     *
     * @return string
     */
    protected function getDatabases($sortCallback = null)
    {
        $databases = $this->dbService->getSchemaManager()->listDatabases();

        if (is_callable($sortCallback)) {
            call_user_func_array($sortCallback, array(&$databases));
        }

        return $databases;
    }

    protected function getConnections()
    {
        /**
         * @var SecurityContext $securityContext
         * @var User $user
         */
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        return $user->getDatabases();
    }

    public function getCurrentConnection()
    {
        $session = $this->container->get('session');
        return $session->get('connection.current', 0);
    }

    protected function getCurrentDatabase()
    {
        return $this->dbService->query('SELECT DATABASE()')->fetchColumn();
    }

    public function getCurrentTable()
    {
        $session = $this->container->get('session');
        return $session->get('table.current');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "menu_builder_extension";
    }

    /**
     * @return TwigEngine
     */
    protected function getEngine()
    {
        if (!$this->engine) {
            $this->engine = $this->container->get('templating');
        }

        return $this->engine;
    }
}
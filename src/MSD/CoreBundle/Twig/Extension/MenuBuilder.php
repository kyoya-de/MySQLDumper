<?php

namespace MSD\CoreBundle\Twig\Extension;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\DBAL\Connection;
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
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
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
        $this->dbService = $this->container->get('msd.db_connection');
        if (!$this->dbService) {

            return '&nbsp;';
        }

        return $this->buildDbSelect() . $this->buildTablesSelect();
    }

    /**
     * @return string
     */
    public function buildTablesSelect()
    {
        /**
         * TODO: System-Views are hidden. Create a database management helper class or
         */
        $tables = $this->dbService->getSchemaManager()->listTableNames();
        $views = $this->dbService->getSchemaManager()->listTables();
        $engine = $this->getEngine();

        return $engine->render(
            'MSDCoreBundle:Menu:tables.html.twig',
            array('tables' => $tables)
        );
    }

    /**
     * @return string
     */
    public function buildDbSelect()
    {
        /** @var User $user */
        $user = $this->container->get('security.context')->getToken()->getUser();

        $templating = $this->getEngine();

        return $templating->render(
            'MSDCoreBundle:Menu:databases.html.twig',
            array(
                 'connections' => $user->getDatabases(),
                 'databases' => $this->dbService->getSchemaManager()->listDatabases(),
                 'currentConnection' => $user->getCurrentConnection(),
                 'currentDatabase' => $this->dbService->getDatabase(),
            )
        );
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
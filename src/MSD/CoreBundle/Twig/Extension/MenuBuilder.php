<?php

namespace MSD\CoreBundle\Twig\Extension;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\DBAL\Connection;
use MSD\CoreBundle\Database\Connection\FactoryService;
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
     * @param Connection $dbConnection
     * @param Container  $container
     */
    public function __construct(Connection $dbConnection, Container $container)
    {
        $this->container = $container;
        $this->dbService = $dbConnection;
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

        return $this->buildDbSelect() . $this->buildTablesSelect();
    }

    /**
     * @return string
     */
    public function buildTablesSelect()
    {
        $tables = $this->dbService->getSchemaManager()->listTableNames();
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
        $databases = $this->dbService->getSchemaManager()->listDatabases();
        $templating = $this->getEngine();

        return $templating->render('MSDCoreBundle:Menu:databases.html.twig', array('databases' => $databases));
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
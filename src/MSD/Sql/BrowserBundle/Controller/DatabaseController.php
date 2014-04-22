<?php

namespace MSD\Sql\BrowserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DatabaseController extends Controller
{
    public function indexAction($dbName)
    {
        $tablesMeta = $this->get('msd.metadata.tables');
        $tables = $tablesMeta->getTables($dbName);
        return $this->render(
            'MSDSqlBrowserBundle:Database:index.html.twig',
            array('tables' => $tables)
        );
    }
} 
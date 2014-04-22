<?php

namespace MSD\Sql\BrowserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $schemata = $this->get('msd.metadata.schemata');
        $databases = $schemata->getSchemata();
        return $this->render(
            'MSDSqlBrowserBundle:Default:index.html.twig',
            array('databases' => $databases)
        );
    }
}

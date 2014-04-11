<?php

namespace MSD\Sql\BrowserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MSDSqlBrowserBundle:Default:index.html.twig', array('name' => $name));
    }
}

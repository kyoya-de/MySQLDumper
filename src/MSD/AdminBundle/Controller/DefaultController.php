<?php

namespace MSD\AdminBundle\Controller;

use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repo  = $this->getDoctrine()->getRepository('MSDUserBundle:User');
        $users = $repo->findBy(array(), array('username' => 'ASC'));

        return $this->render('MSDAdminBundle:Default:index.html.twig', array('users' => $users));
    }
}

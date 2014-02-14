<?php

namespace MSD\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use MSD\UserBundle\Entity\User;
use MSD\UserBundle\Form\Settings\UserType;

/**
 * Class DefaultController
 *
 * @package MSD\UserBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->get('security.context')->getToken()->getUser();
//        $u = new UserType();
        $form = $this->createForm('msd_user', $user);
        return $this->render('MSDUserBundle:Default:index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'MSDUserBundle::login.html.twig',
            array(
                 // last username entered by the user
                 'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                 'error'         => $error,
            )
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logoutAction()
    {
        return $this->render('MSDUserBundle::logout.html.twig');
    }
}

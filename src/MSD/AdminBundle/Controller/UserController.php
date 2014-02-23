<?php

namespace MSD\AdminBundle\Controller;

use MSD\CoreBundle\Database\ConnectionService;
use MSD\UserBundle\Entity\User;
use MSD\UserBundle\Entity\UserDatabase;
use MSD\UserBundle\Form\Settings\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserController extends Controller
{
    public function editAction(Request $request)
    {
        /**
         * @var User           $user
         * @var User           $newUser
         * @var EncoderFactory $factory
         */

        $userId = $request->get('userId');
        if (0 == $userId) {
            $user     = new User();
            $userRole = $this->getDoctrine()->getRepository('MSDUserBundle:Role')->find(2);
            $user->clearRoles()->addRole($userRole);
        } else {
            $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);
        }

        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $newUser = $form->getData();
            if (null !== $user->getPassword()) {
                $factory  = $this->get('security.encoder_factory');
                $encoder  = $factory->getEncoder($user);
                $password = $encoder->encodePassword($newUser->getPassword(), $user->getSalt());
                $user->setPassword($password);
            }

            $user->setUsername($newUser->getUsername());
            $user->setEmail($newUser->getEmail());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            if (0 == $userId) {
                $redirectUrl = $this->generateUrl('msd_admin_user_edit_connection', array('userId' => $user->getId()));
            } else {
                $redirectUrl = $this->generateUrl('msd_admin_homepage');
            }

            return $this->redirect($redirectUrl);
        }

        return $this->render(
            'MSDAdminBundle:User:edit.html.twig',
            array(
                'form' => $form->createView(),
                'user' => $user,
            )
        );
    }

    public function deleteAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);
        $em   = $this->getDoctrine()->getManager();

        $user->clearRoles();
        $connections = $user->getDatabases();
        foreach ($connections as $connection) {
            $em->remove($connection);
        }

        $user->clearDatabases();
        $em->persist($user);

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('msd_admin_homepage'));
    }

    public function lockAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);
        $em   = $this->getDoctrine()->getManager();
        $user->setActive(false);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('msd_admin_homepage'));
    }

    public function unlockAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);
        $em   = $this->getDoctrine()->getManager();
        $user->setActive(true);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('msd_admin_homepage'));
    }

    public function manageConnectionsAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);

        $connections = $user->getDatabases();

        return $this->render(
            'MSDAdminBundle:User:manageConnections.html.twig',
            array('connections' => $connections, 'user' => $user)
        );
    }

    public function manageRolesAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);

        if ($this->getRequest()->isMethod('post')) {
            $request  = $this->getRequest();
            $newRoles = $request->get('role');
            $roleRepo = $this->getDoctrine()->getRepository('MSDUserBundle:Role');

            foreach ($newRoles as $roleId => $active) {
                $role = $roleRepo->find($roleId);
                $user->removeRole($role);
                if ($active) {
                    $user->addRole($role);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('msd_admin_homepage'));
        }

        $roles = $this->getDoctrine()->getRepository('MSDUserBundle:Role')->findBy(array(), array('name' => 'ASC'));

        return $this->render(
            'MSDAdminBundle:User:manageRoles.html.twig',
            array('roles' => $roles, 'user' => $user)
        );
    }

    public function editConnectionAction(Request $request)
    {
        /** @var User $user */
        /** @var UserDatabase $connection */

        $userId       = $request->get('userId');
        $connectionId = $request->get('connectionId');
        $user         = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);

        if (0 == $connectionId) {
            $connection = new UserDatabase();
            $connection->setDriver('pdo_mysql');
            $connection->setCharset('UTF8');
            $connection->setMsdUser($user);
        } else {
            $connection = $this->getDoctrine()->getRepository('MSDUserBundle:UserDatabase')->find($connectionId);
        }

        $form = $this->createForm('msd_db_connection', $connection);
        $form->handleRequest($request);
        $connection = $form->getData();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($connection);
            $em->flush();

            return $this->redirect($this->generateUrl('msd_admin_homepage'));
        }

        return $this->render(
            'MSDAdminBundle:User:editConnection.html.twig',
            array(
                'form'       => $form->createView(),
                'user'       => $user,
                'connection' => $connection,
            )
        );
    }

    public function checkConnectionAction(Request $request)
    {
        $form = $this->createForm('msd_db_connection', new UserDatabase());
        $form->handleRequest($request);
        $connection = $form->getData();

        /** @var ConnectionService $connectionService */
        $connectionService = $this->get('msd.db_connection.service');
        try {
            $con = $connectionService->createConnection($connection);
            $success = $con->connect();
        } catch (\Exception $exception) {
            return new Response(
                json_encode(array('success' => false, 'message' => $exception->getMessage())),
                200,
                array('Content-Type' => 'application/json')
            );
        }

        return new Response(
            json_encode(array('success' => $success)),
            200,
            array('Content-Type' => 'application/json')
        );
    }

    public function deleteConnectionAction(Request $request)
    {
        $connectionId = $request->get('connectionId');
        $connection   = $this->getDoctrine()->getRepository('MSDUserBundle:UserDatabase')->find($connectionId);
        $em           = $this->getDoctrine()->getManager();
        $em->remove($connection);
        $em->flush();

        return $this->redirect($this->generateUrl('msd_admin_homepage'));
    }
}

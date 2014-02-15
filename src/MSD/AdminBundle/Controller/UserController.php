<?php

namespace MSD\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function editAction($userId)
    {
    }

    public function deleteAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('msd_admin_homepage'));
    }

    public function lockAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);
        $em = $this->getDoctrine()->getManager();
        $user->setActive(false);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('msd_admin_homepage'));
    }

    public function unlockAction($userId)
    {
        /** @var \MSD\UserBundle\Entity\User $user */
        $user = $this->getDoctrine()->getRepository('MSDUserBundle:User')->find($userId);
        $em = $this->getDoctrine()->getManager();
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
}

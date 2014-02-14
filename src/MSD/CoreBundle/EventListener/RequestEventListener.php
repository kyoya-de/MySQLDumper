<?php

namespace MSD\CoreBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\Session;

class RequestEventListener extends ContainerAware
{
    public function changeConnection(GetResponseEvent $event)
    {
        if (null === ($connectionId = $event->getRequest()->get('_connection'))) {
            return;
        }

        /** @var Session $session */
        $session = $this->container->get('session');
        $session->set('connection.current', (int) $connectionId);
    }

    public function changeDatabase(GetResponseEvent $event)
    {
        if (null === ($database = $event->getRequest()->get('_database'))) {
            return;
        }

        /** @var Session $session */
        $session = $this->container->get('session');
        $session->set('database.current', $database);
    }

    public function changeTable(GetResponseEvent $event)
    {
        if (null === ($table = $event->getRequest()->get('_table'))) {
            return;
        }

        /** @var Session $session */
        $session = $this->container->get('session');
        $session->set('table.current', $table);
    }
}
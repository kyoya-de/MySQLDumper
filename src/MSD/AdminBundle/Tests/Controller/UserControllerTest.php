<?php

namespace MSD\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/edit');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/delete');
    }

    public function testLock()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/lock');
    }

    public function testUnlock()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/unlock');
    }

    public function testManageconnection()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/manageConnections');
    }

}

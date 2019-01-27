<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{

    public function testShowPost(): void {
        $client = static::createClient();

        $client->request('GET', '/hello/world');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testDetail(): void
    {
        $client = self::createClient();
        $client->enableProfiler();

        $client->request('GET', '/product/2');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals($client->getResponse()->getContent(), 2);
    }
}
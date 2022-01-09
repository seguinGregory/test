<?php


namespace App\Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = self::createClient();
        $client->enableProfiler();

        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testPayment(): void
    {
        $client = self::createClient();
        $client->enableProfiler();

        $client->request('GET', '/payment');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}

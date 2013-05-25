<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ftassi
 * Date: 22/05/13
 * Time: 19:02
 * To change this template use File | Settings | File Templates.
 */

namespace PugM\RestDemoBundle\Tests\Controller;


use Liip\FunctionalTestBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase{

    public function setUp()
    {
        $this->loadFixtures(array('PugM\RestDemoBundle\Tests\Fixtures\CustomerControllerTestFixtures'));
    }

    public function testGetCustomer()
    {
        $client = static::createClient();

        $client->request('GET', '/customers/1', array(), array(), array(
                'HTTP_ACCEPT' => 'application/json'
            ));

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(1, $response['id']);
        $this->assertEquals('foo customer name', $response['name']);
        $this->assertEquals('foo customer address', $response['address']);
        $this->assertEquals('foocustomer@example.org', $response['email']);
        $this->assertEquals('logo.jpg', $response['logo']);
    }

    public function testPostCustomer()
    {
        $client = static::createClient();

        $client->request('POST', '/customer', array(), array(), array(
                'HTTP_ACCEPT' => 'application/json'
            ),
            '{"name": "New customer name","address": "New customer adress","email": "newcustomer@example.org","logo": "logo.jpg"}'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $client->request('GET', $client->getResponse()->headers->get('Location'), array(), array(), array(
                'HTTP_ACCEPT' => 'application/json'
            ));

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(2, $response['id']);
        $this->assertEquals('New customer name', $response['name']);
        $this->assertEquals('New customer adress', $response['address']);
        $this->assertEquals('newcustomer@example.org', $response['email']);
        $this->assertEquals('logo.jpg', $response['logo']);
    }

    public function testDeleteCustomer()
    {
        $client = static::createClient();

        $client->request('DELETE', '/customers/1', array(), array(), array(
            'HTTP_ACCEPT' => 'application/json'
        ));
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testLinkInvoiceToCustomer()
    {
        $client = static::createClient();

        $client->request('LINK', '/customers/1', array(), array(), array(
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_LINK' => array('<http://localhost/invoices/1>; rel="invoice"', '<http://localhost/invoices/2>; rel="invoice"'),
            ));

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
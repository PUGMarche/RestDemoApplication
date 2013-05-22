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

    public function testGetCustomer()
    {
        $client = static::createClient();

        $client->request('GET', '/customers/1', array(), array(), array(
                'HTTP_ACCEPT' => 'application/json'
            ));

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }
}
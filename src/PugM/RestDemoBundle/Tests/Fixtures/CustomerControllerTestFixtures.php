<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ftassi
 * Date: 22/05/13
 * Time: 20:13
 * To change this template use File | Settings | File Templates.
 */

namespace PugM\RestDemoBundle\Tests\Fixtures;


use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PugM\RestDemoBundle\Entity\Customer;

class CustomerControllerTestFixtures implements FixtureInterface{

    /**
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer->setName('foo customer name');
        $customer->setAddress('foo customer address');
        $customer->setLogo('logo.jpg');
        $customer->setEmail('foocustomer@example.org');

        $manager->persist($customer);
        $manager->flush();
    }
}